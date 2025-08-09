<?php

namespace App\Http\Controllers;

use App\Models\Recipient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ImportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (!auth()->user()->isAdmin()) {
                abort(403, 'Unauthorized');
            }
            return $next($request);
        });
    }

    public function showImportForm()
    {
        return view('admin.import');
    }

    public function import(Request $request)
    {
        $request->validate([
            'excel_file' => 'required|mimes:xlsx,xls,csv|max:2048'
        ]);

        try {
            $file = $request->file('excel_file');
            $spreadsheet = IOFactory::load($file->getPathname());
            $worksheet = $spreadsheet->getActiveSheet();
            $rows = $worksheet->toArray();

            // Skip header row
            array_shift($rows);

            $imported = 0;
            $errors = [];

            foreach ($rows as $index => $row) {
                $rowNumber = $index + 2; // +2 because we skipped header and array is 0-indexed

                // Skip empty rows
                if (empty(array_filter($row))) {
                    continue;
                }

                $data = [
                    'qr_code' => $row[0] ?? '',
                    'child_name' => $row[1] ?? '',
                    'Ayah_name' => $row[2] ?? '',
                    'Ibu_name' => $row[3] ?? '',
                    'birth_place' => $row[4] ?? '',
                    'birth_date' => $row[5] ?? '',
                    'school_level' => $row[6] ?? '',
                    'school_name' => $row[7] ?? '',
                    'address' => $row[8] ?? '',
                    'class' => $row[9] ?? '',
                    'shoe_size' => $row[10] ?? '',
                    'shirt_size' => $row[11] ?? '',
                ];

                $validator = Validator::make($data, [
                    'qr_code' => 'required|unique:recipients,qr_code',
                    'child_name' => 'required|string|max:255',
                    'Ayah_name' => 'required|string|max:255',
                    'Ibu_name' => 'required|string|max:255',
                    'birth_place' => 'required|string|max:255',
                    'birth_date' => 'required|date',
                    'school_level' => 'required|in:SD,SMP,SMA,SMK',
                    'school_name' => 'required|string|max:255',
                    'address' => 'required|string',
                    'class' => 'required|string|max:50',
                    'shoe_size' => 'required|string|max:10',
                    'shirt_size' => 'required|in:XS,S,M,L,XL,XXL',
                ]);

                if ($validator->fails()) {
                    $errors[] = "Baris {$rowNumber}: " . implode(', ', $validator->errors()->all());
                    continue;
                }

                try {
                    Recipient::create($data);
                    $imported++;
                } catch (\Exception $e) {
                    $errors[] = "Baris {$rowNumber}: Gagal menyimpan data - " . $e->getMessage();
                }
            }

            $message = "Berhasil mengimpor {$imported} data.";
            if (!empty($errors)) {
                $message .= " Terdapat " . count($errors) . " error.";
            }

            return redirect()->route('admin.import')
                ->with('success', $message)
                ->with('errors', $errors);

        } catch (\Exception $e) {
            return redirect()->route('admin.import')
                ->with('error', 'Gagal mengimpor file: ' . $e->getMessage());
        }
    }

    public function downloadTemplate()
    {
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="template_import_penerima.csv"',
        ];

        $callback = function() {
            $file = fopen('php://output', 'w');
            
            // Header
            fputcsv($file, [
                'qr_code',
                'child_name', 
                'Ayah_name',
                'Ibu_name',
                'birth_place',
                'birth_date',
                'school_level',
                'school_name',
                'address',
                'class',
                'shoe_size',
                'shirt_size'
            ]);

            // Sample data
            fputcsv($file, [
                'CBP0001',
                'Ahmad Fauzi',
                'Budi Santoso',
                'Siti Aminah',
                'Jakarta',
                '2010-05-15',
                'SD',
                'SDN 01 Jakarta',
                'Jl. Merdeka No. 123, Jakarta',
                '5A',
                '35',
                'M'
            ]);

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
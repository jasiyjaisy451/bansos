<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Recipient extends Model
{
    use HasFactory;

    protected $fillable = [
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
        'shirt_size',
        'uniform_received',
        'shoes_received',
        'bag_received',
        'is_distributed',
        'distributed_at',
        'status',
        'user_id',
    ];

    protected $casts = [
        'birth_date' => 'date',
        'uniform_received' => 'boolean',
        'shoes_received' => 'boolean',
        'bag_received' => 'boolean',
        'is_distributed' => 'boolean',
        'distributed_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getDistributionStatusAttribute()
    {
        return match($this->status) {
            'belum_register' => 'Belum Register',
            'sudah_register' => 'Sudah Register',
            'sudah_menerima' => 'Sudah Menerima',
            default => 'Belum Register'
        };
    }

    public function getStatusBadgeClassAttribute()
    {
        return match($this->status) {
            'belum_register' => 'bg-secondary',
            'sudah_register' => 'bg-warning',
            'sudah_menerima' => 'bg-success',
            default => 'bg-secondary'
        };
    }

    public function canDistribute()
    {
        return $this->status === 'sudah_register';
    }
}
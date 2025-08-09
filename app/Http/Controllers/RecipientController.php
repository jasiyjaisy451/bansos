@@ .. @@
     public function distribute(Request $request, Recipient $recipient)
     {
+        // Check if recipient can distribute (must be registered)
+        if (!$recipient->canDistribute()) {
+            return response()->json([
+                'success' => false,
+                'message' => 'Penerima belum terdaftar. Silakan registrasi QR Code terlebih dahulu.'
+            ], 400);
+        }
+
         $uniformReceived = $request->has('uniform_received');
         $shoesReceived = $request->has('shoes_received');
         $bagReceived = $request->has('bag_received');

         $recipient->update([
             'uniform_received' => $uniformReceived,
             'shoes_received' => $shoesReceived,
             'bag_received' => $bagReceived,
             'is_distributed' => $uniformReceived && $shoesReceived && $bagReceived,
             'distributed_at' => $uniformReceived && $shoesReceived && $bagReceived ? now() : $recipient->distributed_at,
+            'status' => $uniformReceived && $shoesReceived && $bagReceived ? 'sudah_menerima' : 'sudah_register',
         ]);

         return response()->json([
@@ .. @@
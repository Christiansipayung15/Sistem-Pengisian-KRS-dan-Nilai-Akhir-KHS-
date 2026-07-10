<?php

namespace App\Services;

use App\Models\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class OtpService
{
    public function generateOtp($email)
    {
        $otp = random_int(100000, 999999);
        // Hapus kode lama jika ada agar user selalu mendapatkan yang terbaru
        PasswordReset::where('email', $email)->delete();

        PasswordReset::create([
            'email' => $email,
            'otp_code' => Hash::make($otp),
            'expires_at' => Carbon::now()->addMinutes(5),
            'is_used' => false
        ]);

        return $otp;
    }

    // Fungsi untuk memvalidasi OTP
    public function isValidOtp($email, $inputOtp)
    {
        $record = PasswordReset::where('email', $email)->latest()->first();

        if ($record && !$record->is_used && Carbon::now()->lessThan($record->expires_at)) {
            return Hash::check($inputOtp, $record->otp_code);
        }

        return false;
    }
}
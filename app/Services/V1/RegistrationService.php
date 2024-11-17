<?php

namespace App\Services\V1;

use Exception;
use Carbon\Carbon;
use App\Models\User;
use App\Models\OtpLog;
use Illuminate\Support\Str;
use App\Enums\HttpStatusCode;
use App\Actions\SendOtpAction;
use App\Models\SetPasswordOtpLog;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\PersonalAccessToken;

class RegistrationService
{
    public function loginWithPassword($data)
    {
        $user = User::where('email', $data['email'])->first();

        if (!$user) {
            throw new Exception('User not found', HttpStatusCode::NOT_FOUND);
        }

        if (!Hash::check($data['password'], $user->password)) {
            throw new Exception('Password is incorrect', HttpStatusCode::VALIDATION_ERROR);
        }

        return $this->generateAndGetToken($user);
    }

    private function generateAndGetToken($user): array
    {
        $token = $user->createToken('auth_token', ['*'], now()->addHours(config('constants.jwt_token_expire_time')))->plainTextToken;

        return [
            'access_token' => $token,
            'token_type' => 'Bearer',
            'expires_at' => now()->addHours(config('constants.jwt_token_expire_time'))->timestamp,
        ];
    }
}

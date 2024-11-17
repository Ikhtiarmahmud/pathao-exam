<?php

namespace App\Rules;

use Closure;
use Carbon\Carbon;
use App\Models\OtpLog;
use App\Enums\HttpStatusCode;
use App\Response\ApiResponse;
use App\Repositories\OtpLogRepository;
use App\Repositories\SetPasswordOtpLogRepository;
use Illuminate\Contracts\Validation\ValidationRule;

class VerifyOtpValidationRule implements ValidationRule
{
    protected int $otp;
    protected string $type;

    public function __construct(int $otp, string $type)
    {
        $this->otp = $otp;
        $this->type = $type;
    }
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if ($this->type === 'otp') {
            $userOtp = (new OtpLogRepository())->findLatestOne(['phone' => $value]);
        } else {
            $userOtp = (new SetPasswordOtpLogRepository())->findLatestOne(['phone' => $value]);
        }

        if (strlen($value) !== 11) {
            $fail('The :attribute must be 11 characters');
            return;
        }

        if (empty($userOtp) || (int) $userOtp->otp !== $this->otp || Carbon::now() > Carbon::parse($userOtp->created_at)->addMinutes(5)) {
            $fail('Otp is incorrect');
        }
    }
}

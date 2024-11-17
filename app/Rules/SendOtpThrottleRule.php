<?php

namespace App\Rules;

use App\Repositories\OtpLogRepository;
use App\Repositories\SetPasswordOtpLogRepository;
use Carbon\Carbon;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class SendOtpThrottleRule implements ValidationRule
{
    protected string $type;

    public function __construct(string $type)
    {
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
            $fail('Please provide a valid number');
        }

        if ($userOtp && Carbon::parse($userOtp->created_at)->addMinutes(5) > Carbon::now()) {
            $fail('You can not send multiple otp within 5 minutes.');
        }
    }
}

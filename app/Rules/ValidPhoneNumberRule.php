<?php

namespace App\Rules;

use App\Models\Country;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidPhoneNumberRule implements ValidationRule
{
    protected $country_id;


    public function __construct($country_id)
    {
        $this->country_id = $country_id;
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $country = Country::find($this->country_id);

        if (!$country) {
            $fail(__('messages.countryNotFound'));
            return;
        }

        if (!preg_match("/^\\{$country->code}\\d{{$country->digits_count}}$/", $value)) {
            $fail(__('messages.invalidPhone'));
        }
    }
}

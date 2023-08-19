<?php

namespace App\Helpers;


use Illuminate\Validation\Validator;

class FormatHelpers
{
    public static function formatErrors(Validator $validator)
    {
        return collect($validator->errors()->messages())->map(function ($messages) {
            return $messages[0];
        });
    }
}

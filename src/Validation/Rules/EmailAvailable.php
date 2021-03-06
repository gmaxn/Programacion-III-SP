<?php
namespace App\Validation\Rules;

use App\Models\Users;
use Respect\Validation\Rules\AbstractRule;

class EmailAvailable extends AbstractRule
{
    public function validate($input) : bool
    {
        return Users::where('email', $input)->count() === 0;
    }
}
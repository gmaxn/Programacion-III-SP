<?php
namespace App\Validation\Rules;

use App\Models\Users;
use Respect\Validation\Rules\AbstractRule;

class LegajoDisponible extends AbstractRule
{
    public function validate($input) : bool
    {
        return Users::where('legajo', '=', $input)->count() === 0;
    }
}
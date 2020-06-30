<?php
namespace App\Validation\Rules;

use App\Models\Users;
use Respect\Validation\Rules\AbstractRule;

class VetExists extends AbstractRule
{
    public function validate($input) : bool
    {
        return Users::where('id', '=',  $input)
                    ->where('role', '=', 'veterinario')->count() > 0;
    }
}
<?php
namespace App\Validation\Rules;

use App\Models\User;
use Respect\Validation\Rules\AbstractRule;

class VetExists extends AbstractRule
{
    public function validate($input) : bool
    {
        return User::where('id', '=',  $input)
                    ->where('role', '=', 'veterinario')->count() > 0;
    }
}
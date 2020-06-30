<?php
namespace App\Validation\Rules;

use App\Models\Role;
use Respect\Validation\Rules\AbstractRule;

class RoleAvailable extends AbstractRule
{
    public function validate($input) : bool
    {
        return Role::where('tipo', strtolower($input))->count() > 0;
    }
}
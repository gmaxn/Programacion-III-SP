<?php
namespace App\Validation\Exceptions;
use Respect\Validation\Exceptions\ValidationException;

final class RoleAvailableException extends ValidationException
{
    protected $defaultTemplates = [
        self::MODE_DEFAULT => [
            self::STANDARD => 'Invalid Role.'
        ]
    ];
}
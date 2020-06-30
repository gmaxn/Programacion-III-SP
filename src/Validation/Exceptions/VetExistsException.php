<?php
namespace App\Validation\Exceptions;
use Respect\Validation\Exceptions\ValidationException;

final class VetExists extends ValidationException
{
    protected $defaultTemplates = [
        self::MODE_DEFAULT => [
            self::STANDARD => 'wrong veterinarian id.'
        ]
    ];
}
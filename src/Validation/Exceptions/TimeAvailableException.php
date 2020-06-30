<?php
namespace App\Validation\Exceptions;
use Respect\Validation\Exceptions\ValidationException;

final class TimeAvailableException extends ValidationException
{
    protected $defaultTemplates = [
        self::MODE_DEFAULT => [
            self::STANDARD => 'wrong date.'
        ]
    ];
}
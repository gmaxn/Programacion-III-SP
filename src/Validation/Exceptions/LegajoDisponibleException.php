<?php
namespace App\Validation\Exceptions;
use Respect\Validation\Exceptions\ValidationException;

final class LegajoDisponibleException extends ValidationException
{
    protected $defaultTemplates = [
        self::MODE_DEFAULT => [
            self::STANDARD => 'El legajo ingresado ya existe en la base de datos.'
        ]
    ];
}
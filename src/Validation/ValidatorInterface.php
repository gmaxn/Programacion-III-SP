<?php
namespace App\Validation;

interface ValidatorInterface {

    function validate($request, array $rules);
}
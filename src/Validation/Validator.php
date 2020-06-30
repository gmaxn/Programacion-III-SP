<?php

namespace App\Validation;
use Respect\Validation\Validator as RespectValidator;
use Respect\Validation\Exceptions\NestedValidationException;


class Validator implements ValidatorInterface
{
    protected $errors;

    public function __construct()
    {
    }

    public function validate($request, array $rules)
    {
        foreach ($rules as $field => $rule)
        {
            try {

                $res = $request->getParsedBody();

                $rule->setName(ucfirst($field))
                     ->assert($res[$field]);

            } catch (NestedValidationException $e) {

                $this->errors[$field] = $e->getMessages();
            }
        }

        return $this;
    }

    public function failed() 
    {
        return !empty($this->errors);
    }

    public function getValidationErrors()
    {
        return json_encode($this->errors);
    }
}
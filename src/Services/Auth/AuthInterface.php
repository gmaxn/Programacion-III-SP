<?php
namespace App\Services\Auth;

interface AuthInterface 
{
    function authenticate($email, $password);
    function generateToken($userId, $email, $role, $iat, $exp);
    function authorize($token);

}
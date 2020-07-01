<?php
namespace App\Services\Auth;

interface AuthInterface 
{
    function authenticate($email, $password);
    function generateToken($userId, $nombre, $email, $legajo, $role, $iat, $exp);
    function authorize($token);

}
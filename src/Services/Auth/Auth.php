<?php

namespace App\Services\Auth;
use App\Models\Users;
use Exception;
use stdClass;
use Firebase\JWT\JWT;

class Auth implements AuthInterface
{
    public function authenticate($email, $password)
    {

        $result = new stdClass();
        $result->succeed = false;

        $user = Users::where('email', "=", $email)->first();

        if(!isset($user))
        {

            $result->content = "user does not exist";
        }
        else if (!password_verify($password, $user->clave))
        {

            $result->content = "user and password does not match";
        }
        else
        {
            $result->succeed = true;
            $result->content = 
                $this->generateToken(
                    $user->id,
                    $user->nombre,
                    $user->email,
                    $user->legajo,
                    $user->tipo_id,
                    strtotime('now'),
                    strtotime('now') + 120
                );

        }

        return $result;
    }

    public function generateToken($userId, $nombre, $email, $legajo, $role, $iat, $exp)
    {

        $payload = array(
            "iat" => $iat,
            "exp" => $exp,
            "userId" => $userId,
            "nombre" => $userId,
            "email" => $email,
            "legajo" => $userId,
            "roleId" => $role
        );

        return JWT::encode($payload, $_ENV['ACCESS_TOKEN_SECRET']);
    }

    public function authorize($token)
    {
        $authorizationResult = new AuthorizationResult('failure', 'unauthorized', false);

        try {

            $decoded = new stdClass();

            $decoded->userContext = JWT::decode($token[0], $_ENV['ACCESS_TOKEN_SECRET'], array('HS256'));

            $authorizationResult->status = 'succeed';
            $authorizationResult->data = $decoded;
            $authorizationResult->isValid = true;

            return $authorizationResult;
            
        } catch (\Throwable $th) {

            if ($th->getMessage() == 'Malformed UTF-8 characters') {

                throw new Exception('Invalid token');
            }

            throw new Exception($th->getMessage());
        }
    }
}
class AuthorizationResult
{
    public $status;
    public $data;
    public $isValid;

    public function __construct($status = 'failure', $errorMessage = 'unauthorized', $isValid = false)
    {
        $this->status = $status;
        $this->errorMessage = $errorMessage;
        $this->isValid = $isValid;
    }
}

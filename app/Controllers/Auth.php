<?php

namespace App\Controllers;

class Auth extends ApiController
{
	public function index()
	{
		return view('welcome_message');
	}

    public function login(){
        switch ($_SERVER['REQUEST_METHOD']) {
           case 'POST':
                $login = service('request')->getJSON();
                $cuentas = model('CuentasModel', true, $this->db);
                $cuenta = (object) $cuentas->where('email', $login->user)->first();
                $credencial = false;

                if(isset($cuenta->password)){
                    $credencial = password_verify($login->password, $cuenta->password);
                }

                if($credencial){
                    unset($cuenta->password);
                    $token = bin2hex(random_bytes(64));

                    $token = (object) ['auth' => bin2hex(random_bytes(64)),'cuenta_id' => $cuenta->id, 'ip' => $_SERVER['REMOTE_ADDR']];
                    $tokens = model('TokensModel', true, $this->db);
                    $inserted = $tokens->insert($token);

                    if ($inserted === false){
                        $respuesta = ['messages' => ['login' => 'Error interno del servidor al crear su código de autorización'], 'code' => 500];
                    }else{
                        $respuesta = [
                            'messages' => [
                                'login' => 'Autorizado correctamente'
                            ],
                            'code' => 200,
                            'data' => [
                                'cuenta' => $cuenta,
                                'auth' => $token->auth
                            ]
                        ];
                    }
                }else{
                    $respuesta = ['messages' => ['login' => 'Las credenciales no coinciden con ningún registro'], 'code' => 400];
                }
                
                return $this->respond($respuesta);
           default:
               return $this->respond(['messages' => ["method" => "Solicitud inválida"], 'code' => 400]);
        }
   }

    public function register(){
         switch ($_SERVER['REQUEST_METHOD']) {
            case 'POST':
                $nueva_cuenta = service('request')->getJSON();
                $cuentas = model('CuentasModel', true, $this->db);
                $nueva_cuenta->password = password_hash($nueva_cuenta->password, PASSWORD_DEFAULT);
                $resultado = $cuentas->insert($nueva_cuenta);

                if ($resultado === false){
                    $errors = $cuentas->errors();
                    $respuesta = [
                        "messages" => $errors,
                        "code" => 409
                    ];
                }else{
                    $respuesta = [
                        "messages" => ["registro" => "Registro exitoso!"],    
                        "code" => 200,
                    ];
                }
                return $this->respond($respuesta);
            default:
                return $this->respond(['messages' => ["method" => "Solicitud inválida"], 'code' => 400]);
        }
    }
}

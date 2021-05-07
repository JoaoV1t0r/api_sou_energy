<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Laravel\Sanctum\HasApiTokens;

class UserController extends Controller
{
    /**
     * Método responsável cadastrar um novo usuario
     *
     * @return \Illuminate\Http\Response
     */
    public function postUser(Request $request)
    {
        //DEFINE OS DADOS DO USUARIO A SER CADASTRADO
        $dados = [
            'nome' => trim($request['nome']),
            'email' => trim($request['email']),
            'senha' => password_hash($request['senha'], PASSWORD_DEFAULT)
        ];

        //VERIFICA SE O EMIAL JÁ ESTA CADASTRADO
        if(User::emailVerify($dados['email'])){
            // RETORNA O TOKEN DE ACESSO
            $token = ['token' => User::cadastrar($dados)];

            return response()->json($token, status:Response::HTTP_OK);
        } else{
            return response('E-mail já cadastrado.');
        }
    }

    /**
     * Método responsável por consultar o token de um usuario cadastrado
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getToken(Request $request)
    {
        //DEFINE OS DADOS PARA LOGIN
        $dados = [
            'email' => trim($request['email']),
            'senha' => $request['senha']
        ];

        //BUSCA O TOKEN
        $token = User::getToken($dados);

        if($token == false){
            //RETORNO CASO O USUARIO NÃO SEJA CADASTRADO
            return response('E-mail ou senha errados.');
        } else{
            //RETORNA O TOKEN DO USUARIO
            return response()->json($token, status:Response::HTTP_OK);
        }
    }
}

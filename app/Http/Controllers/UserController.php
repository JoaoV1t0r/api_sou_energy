<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Laravel\Sanctum\HasApiTokens;

class UserController extends Controller
{
    /**
     * Método responsável por buscar um produto pelo seu Id e retorna-lo
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
     * Método responsável por inserir novos produtos no banco de dados
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

        $token = User::getToken($dados);

        if($token == false){
            return response('E-mail ou senha errados.');
        } else{
            return response()->json($token, status:Response::HTTP_OK);
        }
    }
}

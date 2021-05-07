<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Firebase\JWT\JWT;

class User extends Model
{
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * Método responsável por cadastrar um novo usuario
     * 
     * @param array $dados
     */
    public static function cadastrar($dados)
    {
        //DEFINE A QUERY DE CADASTRO
        $query = "
            INSERT INTO
                usuarios
            VALUES( 0, :nome, :email, :senha, NOW(), NULL
        )";

        //INSERI OS DADOS NO BANCO
        DB::insert($query, $dados);

        //DEFINE A CHAVE PARA GERAR UM TOKEN
        $key = "a9aeaa72f8b86edc9c34113e518a897554293ab8";

        //GERA UM TOKEN
        $jwt = JWT::encode($dados, $key);

        //QUERY PARA CADASTRAR O TOKEN
        $queryToken = "
            INSERT INTO
                tokens
            VALUES( 0, :id_user, :token
        )";

        $paramsToken = [
            'id_user' => self::getIdUser(),
            'token' => $jwt
        ];

        //INSERI O TOKEN NO BANCO DE DADOS
        DB::insert($queryToken, $paramsToken);

        //RETORNA O TOKEN
        return $jwt;
    }

    /**
     * Método responsável por verificar se existe um email já cadastrado
     * 
     * @param string $email
     */
    public static function emailVerify($email)
    {
        //DEFINE A QUERY DE BUSCA
        $query = "
            SELECT
                email
            FROM
                usuarios
            WHERE
                email = :email
        ";

        //RETORNA SE O EMAIL EXITE
        return count(DB::select($query, ['email' => $email])) != 0 ? false : true;
    }

    /**
     * Método responsável por buscar o id de um usuario
     */
    public static function getIdUser()
    {
        //DEFINE A QUERY DE BUSCA
        $query = "
            SELECT
                MAX(id) as id
            FROM
                usuarios
        ";

        //RETORNA O ID
        return DB::select($query)[0]->id;
    }

    /**
     * Método responsável por buscar um token de um usuario
     * 
     * @param array $dados
     */
    public static function getToken($dados)
    {
        //DEFINE A QUERY DE BUSCA
        $query = "
            SELECT
                id, email, senha
            FROM
                usuarios
            WHERE
                email = :email
        ";

        $params = [
            'email' => $dados['email']
        ];

        //RESULTADO DA BUSCA
        $resultado = DB::select($query, $params);

        if (count($resultado) != 1) {
            //RETORNA FALSO CASO NÃO SEJA ENCONTRADO O USUARIO
            return false;
        } else {
            //DEFINE A QUERY DE BUSCA
            $queryToken = "
                SELECT
                    token
                FROM
                    tokens
                WHERE
                    id_user = :id_user
            ";
            $paramsToken = [
                'id_user' => $resultado[0]->id
            ];

            //RETONA O TOKEN BUSCADO
            return DB::select($queryToken, $paramsToken);;
        }
    }

    /**
     * Método responsável por verificar se um token existe no banco de dados
     * 
     * @param string $token
     */
    public static function VerifyToken($token)
    {
        //DEFINE A QUERY DE BUSCA
        $query = "
            SELECT
                token
            FROM
                tokens
            WHERE
                token = :token
        ";
        $params = [
            'token' => $token
        ];

        //RETORNA SE O TOKEN EXISTE OU NÃO  
        return count(DB::select($query, $params)) == 1 ? true : false;
    }
}

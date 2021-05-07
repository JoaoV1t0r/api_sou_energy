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

    public static function cadastrar($dados){
        //DEFINE A QUERY DE CADASTRO
        $query = "
            INSERT INTO
                usuarios
            VALUES( 0, :nome, :email, :senha, NOW(), NULL
        )";

        DB::insert($query,$dados);

        $key = "a9aeaa72f8b86edc9c34113e518a897554293ab8";

        $jwt = JWT::encode($dados, $key);
        $queryToken = "
            INSERT INTO
                tokens
            VALUES( 0, :id_user, :token
        )";
        $paramsToken = [
            'id_user' => self::getIdUser(),
            'token' => $jwt
        ];

        DB::insert($queryToken,$paramsToken);
        return $jwt;
    }

    public static function emailVerify($email){
        //DEFINE A QUERY DE BUSCA
        $query = "
            SELECT
                email
            FROM
                usuarios
            WHERE
                email = :email
        ";

        return count(DB::select($query,['email' => $email])) != 0 ? false : true;
    }

    public static function getIdUser(){
        //DEFINE A QUERY DE BUSCA
        $query = "
            SELECT
                MAX(id) as id
            FROM
                usuarios
        ";

        return DB::select($query)[0]->id;
    }

    public static function getToken($dados){
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

        $resultado = DB::select($query,$params);

        if(count($resultado) != 1){
            return false;
        } else {
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

            $token = DB::select($queryToken,$paramsToken);

            return $token;
        }
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Produto extends Model
{
    protected $fillable = ['nome', 'preco'];

    /**
     * Método responsável por retornar todos os produtos do banco de dados
     * 
     * @return array
     */
    public static function get(){
        return DB::select('
            SELECT
                id,nome,preco
            FROM
                produtos
        ');
    }

    /**
     * Método responsável por retornar um produto do banco de dados com base no seu id
     * 
     * @return array
     */
    public static function getById($id){
        return DB::select('
            SELECT
                id,nome,preco
            FROM
                produtos
            WHERE
                id = :id
        ',['id' => $id]);
    }

    /**
     * Método responsável por retornar um produto do banco de dados com base no seu id
     * 
     * @return array
     */
    public static function postProduto($dados){
        return DB::insert('
            INSERT INTO
                produtos
            VALUES(
                0,:nome, :preco, NOW(), NULL
        )',$dados);
    }

    /**
     * Método responsável por retornar um produto do banco de dados com base no seu id
     * 
     * @return array
     */
    public static function atualizar($attProduto, $id){
        $produto = self::getById($id);
        $query = "
            UPDATE
                produtos
            SET
                updated_at = NOW(),
        ";
        $query .= isset($attProduto['nome']) && isset($attProduto['preco']) ? "nome = :nome, preco = :preco" : '';
        $query .= isset($attProduto['preco']) && !isset($attProduto['nome']) ? "preco = :preco  " : '';
        $query .= !isset($attProduto['preco']) && isset($attProduto['nome']) ? "nome = :nome  " : '';
        $query .= " 
            WHERE
                id = :id 
        ";

        $params = [];
        if(isset($attProduto['nome'])){
            $params['nome'] = $attProduto['nome'];
        }
        if(isset($attProduto['preco'])){
            $params['preco'] = $attProduto['preco'];
        }
        $params['id'] = $id;
        if(isset($attProduto['preco']) || isset($attProduto['nome']) ){
            DB::update($query,$params);
        }
        return self::getById($id);
    }

    /**
     * Método responsável por remover um produto do banco de dados com base no seu id
     * 
     * @return array
     */
    public static function deleteProduto($id){
        $produto = self::getById($id);
        $query = "
            DELETE FROM
                produtos
            WHERE
                id = :id
        ";
        $params['id'] = $id;
        
        DB::delete($query,$params);
        return $produto;
    }
}

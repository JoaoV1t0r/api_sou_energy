<?php

namespace App\Models;

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
        //DEFINE A QUERY DE BUSCA
        $query = "
            SELECT
                id,nome,preco
            FROM
                produtos
        ";

        //RETRONA OS PRODUTOS ENCONTRADOS
        return DB::select($query);
    }

    /**
     * Método responsável por retornar um produto do banco de dados com base no seu id
     * 
     * @return array
     */
    public static function getById($id){
        //DEFINE A QUERY DE BUSCA
        $query = "
            SELECT
                id,nome,preco
            FROM
                produtos
            WHERE
                id = :id
        ";

        //DEFINE OS PARAMETROS DE BUSCA
        $params = [
            'id' => $id
        ];

        //FAZ A BUSCA E RETORNA O PRODUTO CASO ENCONTRADO
        return DB::select($query, $params);
    }

    /**
     * Método responsável por inserir um produto mo banco de dados
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
     * Método responsável por atualizar um produto no banco de dados com base no seu id
     * 
     * @return array
     */
    public static function atualizar($attProduto, $id){
        //BUSCA O PRODUTO A SER ATUALIZADO
        $produto = self::getById($id);

        //DEFININDO A QUERY COM BASE NOS ITENS A SEREM ATUALIZADOS
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

        //DEFININDO OS PARAMETROS A SEREM ATUALIZADOS
        $params = [];
        if(isset($attProduto['nome'])){
            $params['nome'] = $attProduto['nome'];
        }
        if(isset($attProduto['preco'])){
            $params['preco'] = $attProduto['preco'];
        }
        $params['id'] = $id;

        //ATUALIZA O PRODUTO CASO EXISTA PARAMETROS
        if(isset($attProduto['preco']) || isset($attProduto['nome']) ){
            DB::update($query,$params);
        }

        //RETORNA O PRODUTO ATUALIZADO
        return self::getById($id);
    }

    /**
     * Método responsável por remover um produto do banco de dados com base no seu id
     * 
     * @return array
     */
    public static function deleteProduto($id){
        //BUCA O PRODUTO A SER DELETADO
        $produto = self::getById($id);

        //DEFINE A QUERY
        $query = "
            DELETE FROM
                produtos
            WHERE
                id = :id
        ";

        //DEFINE O ID DO PRODUTO A SER DELETADO
        $params['id'] = $id;
        
        //DELETA O PRODUTO DO BANCO DE DADOS
        DB::delete($query,$params);

        //RETORNA O PRODUTO QUE FOI DELETADO
        return $produto;
    }
}

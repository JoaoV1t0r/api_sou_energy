<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProdutoController extends Controller
{
    /**
     * Método responsável por buscar todos produtos e retorna-los
     *
     * @return \Illuminate\Http\Response
     */
    public function getProdutos(Request $request)
    {
        //BUSCA OS PRODUTOS NO BANCO DE DADOS
        $produtos = Produto::get();

        //RETRONA OS PRODUTOS ENCONTRADOS
        if(count($produtos) == 0){
            return response('Nenhum produto encontrado' ,status:Response::HTTP_OK);
        }else{
            return response()->json($produtos, status:Response::HTTP_OK);
        }
    }

    /**
     * Método responsável por buscar um produto pelo seu Id e retorna-lo
     *
     * @return \Illuminate\Http\Response
     */
    public function getProdutosById(Request $request)
    {
        //BUSCA O PRODUTO PELO SEU ID
        $produto = Produto::getById($request['id']);

        //RETORNA O PRODUTO CASO ENCONTRADO
        if(count($produto) == 0){
            return response('Produto não encontrado' ,status:Response::HTTP_OK);
        }else{
            return response()->json($produto, status:Response::HTTP_OK);
        }
    }

    /**
     * Método responsável por inserir novos produtos no banco de dados
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function postProdutos(Request $request)
    {
        //DEFINE OS DADOS A SEREM INSERIDOS
        $dados = [
            'nome' => $request->input('nome'),
            'preco' => $request->input('preco')
        ];
        
        //INSERI OS DADOS NO BANCO DE DADOS
        $produto = Produto::postProduto($dados);

        //RETRONA O PRODUTO CADASTRADO
        return response()->json($produto, status:Response::HTTP_OK);
    }

    /**
     * Atualização dos produtos no banco de dados com bas eme seu id
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Produto  $produto
     * @return \Illuminate\Http\Response
     */
    public function putProdutos(Request $request)
    {
        //DEFININDO OS PARAMETROS A SEREM ATUALIZADOS
        $attProduto = [];
        $attProduto['nome'] = $request->input('nome') ?? null;
        $attProduto['preco'] = $request->input('preco') ?? null;

        //ATUALIZA O PRODUTO PELO ID
        $produto = Produto::atualizar($attProduto, $request['id']);

        //RETORNA O PRODUTO ATUALIZADO
        return response()->json($produto, status:Response::HTTP_OK);
        
    }

    /**
     * Remove um produto do banco de dados com base em seu id
     *
     * @param  \App\Models\Produto  $produto
     * @return \Illuminate\Http\Response
     */
    public function deleteProdutos(Produto $produto, Request $request)
    {
        //DELETA O PRODUTO COM BASE ME SEU ID
        $produto = Produto::deleteProduto($request['id']);

        //RETORNA O PRODUTO DELETADO CASO ENCONTRADO
        if(count($produto) == 0){
            return response('Produto não encontrado' ,status:Response::HTTP_OK);
        }else{
            return response()->json($produto, status:Response::HTTP_OK);
        }
    }
}

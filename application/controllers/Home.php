<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    /**
     * Carrega a view principal
     */
    public function index() {
        $this->load->view('home');
    }
    
    /**
     * Recebe o CEP via post e retorna os dados
     * consultados via JSON
     */
    public function consulta(){

        $cep = $this->input->post('cep');

        //pesquisa no banco se existe o cep
        $consulta = $this->cep_model->get_byId($cep);
        //$msg = "Pesquisa Realizada direto do Banco!";
        if($this->db->affected_rows() > 0 ){
             foreach($consulta->result() as $endereco){
                $dados['bairro'] = $endereco->bairro;
                $dados['cep'] = $endereco->cep;
                $dados['complemento'] = $endereco->complemento;
                $dados['gia'] = $endereco->gia;
                $dados['ibge'] = $endereco->ibge;
                $dados['localidade'] = $endereco->localidade;
                $dados['logradouro'] = $endereco->logradouro;
                $dados['uf'] = $endereco->uf;
                $dados['unidade'] = $endereco->unidade;
                $dados['msg'] = "local";
              echo json_encode($endereco);
            }

        }else{
            //carregando a biblioteca do curl
            $this->load->library('curl');    

            $consulta =  $this->curl->consulta($cep);
            $decode = json_decode($consulta);
            $cep = str_replace("-", "", $decode->cep);

            $dados['cep'] = $cep;
            $dados['logradouro'] = $decode->logradouro;
            $dados['complemento'] = $decode->complemento;
            $dados['bairro'] = $decode->bairro;
            $dados['localidade'] = $decode->localidade;
            $dados['uf'] = $decode->uf;
            //$dados['unidade'] = $decode->unidade;
            $dados['ibge'] = $decode->ibge;
            $dados['gia'] = $decode->gia;
            $dados['msg'] = "viacep";
            //$dados = json_decode($novo);
            //echo"<pre>";print_r($dados);echo"</pre>";exit;
            //inserindo novo registro no banco 
            if($this->cep_model->inserir($dados)){
                //pesquisa no banco se existe o cep
                $dados = $this->cep_model->get_byId($cep);
                //echo"<pre>";print_r($dados);echo"</pre>";exit;
                if($this->db->affected_rows() > 0 ){
                    foreach($dados->result() as $endereco){
                        echo json_encode($endereco);
                    }
                }
                //echo"<br>Dados Inseridos com Sucesso!";
            }else{
                echo "Erro ao Inserir os Dados!";
            }
            //carrega os dados na view
            echo $this->curl->consulta($cep);
        }
  
    }

}
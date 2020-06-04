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
        $dados['enderecos'] = $this->cep_model->get_byId('88130675 ');
        $this->load->view('home', $dados);
        //$this->load->view('home');
    }
    
    /**
     * Recebe o CEP via post e retorna os dados
     * consultados via JSON
     */
    public function consulta(){

        $cep = $this->input->post('cep');

        //pesquisa no banco se existe o cep
        $dados = $this->cep_model->get_byId($cep);
        $alert_msg = "Pesquisa Realizada direto do Banco!";
        if($this->db->affected_rows() > 0 ){
             foreach($dados->result() as $endereco){
              echo json_encode($endereco);
            }

        }else{
            //carregando a biblioteca do curl
            $this->load->library('curl');    

            $novo =  $this->curl->consulta($cep);
            $dados = json_decode($novo);
            //inserindo novo registro no banco 
            if($this->cep_model->inserir($dados)){
                //pesquisa no banco se existe o cep
                $dados = $this->cep_model->get_byId($cep);

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
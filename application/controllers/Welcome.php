<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

    /**
     * Carrega a view principal
     */
    public function index() {
        $dados['enderecos'] = $this->cep_model->getAll();
        $this->load->view('welcome_message', $dados);
    }
    
    public function inserir(){
        $dados = [
            'cep' => '8800001',
            'rua' => 'santos silva Florianopolis'
        ];

        if($this->cep_model->inserir($dados)){
            echo"Dados inseridos com sucesso";
        }else{
            echo"erro ao inserir";
        }    	
    }
}

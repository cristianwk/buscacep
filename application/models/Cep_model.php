<?php

class Cep_model extends CI_Model {
	
	public function inserir($dados){
		return $this->db->insert('enderecos', $dados);
	}

	public function getAll(){
		return $this->db->get('enderecos');
	}

	public function get_byId($cep = null){
		
		if($cep != NULL){
	
			$this->db->where('cep', $cep);
			$this->db->limit(1);
	
			return  $this->db->get('enderecos');	
	
		}else{
	
			return FALSE;
		}		
	}	

}
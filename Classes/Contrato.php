<?php
	Class Contrato(){

		include '../conection/connection.php';
		private $nome_modelo_cc;
		private $rg_modelo_cc;
		private $cpf_modelo_cc;
		private $nome_responsavel_cc;
		private $rg_responsavel_cc;
		private $cpf_responsavel_cc;

		public function getNomeModelo(){
			return $this->nome_modelo_cc;
		};

		public function setNomeModelo($nomeModelo){
			$this->nome_modelo_cc = $nomeModelo;
		};

		public function getRgModelo(){
			return $this->rg_modelo_cc;
		};

		public function setRgModelo($rgModelo){
			$this->rg_modelo_cc = $rgModelo;
		};

		public function getCpfModelo(){
			return $this->cpf_modelo_cc;
		};

		public function setCpfModelo($cpfModelo){
			$this->cpf_modelo_cc;
		};

		public function cadastrarContrato($nomeModelo, $rgModelo, $cpfModelo){
			$this->setNomeModelo($nomeModelo);
			$this->setRgModelo($rgModelo);
			$this->setCpfModelo($cpfModelo);

			echo $this->getNomeModelo()." - ".$this->getRgModelo()." - ".$this->getCpfModelo();

		};
	}
?>
<?php
class RotaController { 
	
	//Função que verificar os dados informados pelo usuário e se existe alguma rota agendada
	public function verificarPedido()
	{
		if(isset($_SESSION['dados_rota']) || isset($_SESSION['msg_erro'])){
			unset($_SESSION['dados_rota']);
			unset($_SESSION['dados_erro']);
		}

		$dataIda  = filter_input(INPUT_POST, 'dataIda');
		$origem   = filter_input(INPUT_POST, 'origem');
		$destino  = filter_input(INPUT_POST, 'destino');
		$pag_anteriror = filter_input(INPUT_POST, 'pag');

		$validacao = $this->validarDados($origem, $destino, $dataIda);

		if($validacao['erro'] && $pag_anteriror == 'index.php'){
			$_SESSION['msg_erro'] = $validacao['msg_erro'];
			header("Location: index.php");
		}else{
			$r = new Rota();

			$rotas = $r->verificarRota($origem, $destino, $dataIda);
			
			if(count($rotas) > 0){
				$_SESSION['dados_rota'] = $rotas;
				header("Location: view/RotaView.php");
			}else{
				$_SESSION['msg_erro'] = $validacao['msg_erro'];
				header("Location: view/RotaView.php");	
			}
		}
	}

	//Função que valida os dados que vem do formulário
	public function validarDados($origem, $destino, $data)
	{
		$dataAtual = date('Y-m-d');

		$result = [
			'erro' => false
		];

		if($origem == $destino){
			$result = [
				'erro' => true,
				'msg_erro'  => "Escolha locais diferentes"
			];

		}else if($origem == "invalido" || $origem == "invalido"){
			$result = [
				'erro' => true,
				'msg_erro'  => "Escolha os locais desejados"
			];
		}else if($data < $dataAtual){
			$result = [
				'erro' => true,
				'msg_erro'  => "Escolha uma data válida!"
			];

		}else if($origem == "invalido"){
			$result = [
				'erro' => true,
				'msg_erro'  => "Selecione a cidade de Origem"
			];

		}else if($destino == "invalido"){
			$result = [
				'erro' => true,
				'msg_erro'  => "Selecione a cidade de Destino"
			];

		}else if($data == ""){
			$result = [
				'erro' => true,
				'msg_erro'  => "Escolha a data da viagem."
			];

		}else if(strlen($cpf) > 11){
			$result = [
				'erro' => true,
				'msg_erro'  => "CPF Inválido"
			];
		}

		return $result;
	}

	//Função que verifica poltronas ocupadas em uma determinada rota
	public function verificarPoltronasOcupadas($idRota)
	{
		//$idRota = filter_input(INPUT_POST, 'idRota');
		$r = new Rota();
		return $r->verificarPoltronasOcupadas($idRota);
	}

	//Função que retornar todas as rotas cadastradas
	public function resgatarRotas()
	{
		$r = new Rota();
		$rotas = $r->capturarTodasRotas();
		return $rotas;
	}

	public function verRota()
	{
		$id_origem  = $_GET['origem'];
		$id_destino = $_GET['destino'];

		$r = new Rota();

		$rotas = $r->verRota($id_origem, $id_destino);

		if(count($rotas) > 0){
			$_SESSION['dados_rota'] = $rotas;
			header("Location: view/RotaView.php");
		}else{
			$_SESSION['msg_erro'] = $validacao['msg_erro'];
			header("Location: view/RotaView.php");	
		}
	}

	public function contarPoltronas($id_rota)
	{
		$p = new Passagem();
		$qtd = $p->contarPoltronas($id_rota);
		
		if(count($qtd) == 0){
			return "NENHUMA POLTRONA LIVRE";
		}else{
			return $qtd;
		}
	}

	//Função responsável por retornar os locais de destino de um determinado local
	public function getDestinos()
	{
		$id_origem = filter_input(INPUT_POST, 'id_origem');
		$rota = new Rota();
		return $rota->getDestino($id_origem);
	}

}
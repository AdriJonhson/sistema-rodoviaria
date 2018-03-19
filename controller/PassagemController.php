<?php

class PassagemController {

	//Função que abre o formulário para inserir os dados do usuário
	public function continuarCompra()
	{
		$idRota = filter_input(INPUT_POST, 'idRota');

		$numPoltrona = filter_input(INPUT_POST, 'numPoltronaSelecionada');
		
		$r = new Rota();
		$rd = new Rodoviaria();

		$dadosRota = $r->getDadosRota($idRota);

		$cidadeOrigem  = $rd->getCidade($dadosRota[0]['id_rodoviaria_origem']);
		$cidadeDestino = $rd->getCidade($dadosRota[0]['id_rodoviaria_destino']);

		$_SESSION['rota_selecionada'] = [
			'idRota' => $idRota,
			'numPoltrona' => $numPoltrona,
			'origem' => $cidadeOrigem,
			'destino' => $cidadeDestino,
			'preco' => $dadosRota[0]['preco'],
			'dt_ida' => $dadosRota[0]['dt_ida'],
			'hr_ida' => $dadosRota[0]['hr_ida']
		];

		header("Location: view/CompraView.php");
	}

	//Função para concluir a compra de uma passagem
	public function concluirCompra()
	{
		$p = new Passagem();

		//Informações da Rota selecionada
		$rota = $_SESSION['rota_selecionada'];
		$id_rota = $rota['idRota'];
		$num_poltrona = $rota['numPoltrona'];

		//Informações do Usuário
		$nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_SPECIAL_CHARS);
		$dt_nascimento = filter_input(INPUT_POST, 'dt_nascimento');
		$cpf = filter_input(INPUT_POST, 'cpf',  FILTER_SANITIZE_SPECIAL_CHARS);
		$cpf = $this->tratarCpf($cpf);

		$validacao = $this->validarDados($dt_nascimento, $cpf, $nome,$id_rota);

		if($validacao['erro']){
			$_SESSION['msg_erro']  = $validacao['msg_erro'];
			$_SESSION['dados_old'] = $validacao;
			header("Location: view/CompraView.php");	
		}else{
			$cadastro = $p->cadastrarPassageiro($id_rota, $nome, $cpf, $dt_nascimento, $num_poltrona);

			if($cadastro){
				/*$_SESSION['dados_passagem'] = [
					'origem' => $rota['origem'],
					'destino' => $rota['destino'],
					'id_rota' => $id_rota,
					'preco' => $rota['preco'],
					'dt_ida' => $rota['dt_ida'],
					'hr_ida' => $rota['hr_ida'],
					'num_poltrona' => $num_poltrona
				];*/
				$_SESSION['dados_passagem'] = [
					'id_rota' =>  $id_rota,
					'nome' => $nome,
					'num_poltrona' => $num_poltrona
				];
				header("Location: view/CompraView.php");
			}else{
				header("Location: view/CompraView.php");
			}
		}
	}

	//Função que valida os dados que vem do formulário
	public function validarDados($dt_nascimento, $cpf, $nome, $id_rota)
	{
		$dataAtual = date('Y-m-d');
		$p = new Passagem();

		$result = [
			'erro' => false
		];

		if($dt_nascimento == "" || $dt_nascimento >= $dataAtual){
			$result = [
				'erro'     => true,
				'msg_erro' => 'Escolha uma data válida',
				'cpf_old'  => $cpf,
				'nome_old' => $nome
			];		
		}else if(strlen($cpf) < 11 || strlen($cpf) > 15 || !(is_numeric($cpf))){
			$result = [
				'erro'     => true,
				'msg_erro' => 'Digite um CPF válido',
				'data_old' => $dt_nascimento,
				'nome_old' => $nome
			];
		}else if($p->validarCpf($cpf, $id_rota)){
			$result = [
				'erro'     => true,
				'msg_erro' => 'Esse CPF já está sendo usado nessa rota',
				'data_old' => $dt_nascimento,
				'nome_old' => $nome
			];
		}

		return $result;
	}

	//Função que remove os pontos do CPF
	public function tratarCpf($cpf)
	{
		$cpf = str_replace('.', '', $cpf);
		$cpf = str_replace('-', '', $cpf);
		return $cpf;
	}
	
	public function resgatarPassagem()
	{
		$cpf = filter_input(INPUT_POST, 'inpCpf');
		$cpf = $this->tratarCpf($cpf);
		
		$q = new Passagem();
		$rota = $q->resgatarPassagens($cpf);

		if(count($rota) > 0){

			$_SESSION['dados_passagem'] = $rota;

			header("Location: view/PassagemResgateView.php");

		}else{
			$_SESSION['msg_erro'] = "Você ainda não adquiriu nenhuma passagem";
			header("Location: index.php");
		}
	}

}
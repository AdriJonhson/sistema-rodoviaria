<?php 
	session_start();
	
	require_once 'controller/PassagemController.php';
	require_once 'controller/RodoviariaController.php';
	require_once 'controller/RotaController.php';

	require_once 'model/Rota.class.php';
	require_once 'model/Rodoviaria.class.php';
	require_once 'model/Rota.class.php';
	require_once 'model/Passagem.class.php';
	require_once 'database/Conexao.php';


	$rota = new RotaController();
	$rodo = new RodoviariaController();
	$pass = new PassagemController();

	//verTodasRotas
	$acaoForm = filter_input(INPUT_POST, 'acao');
	$acao = (isset($acaoForm) ? $acaoForm : $_GET['acao']);
	$idRota = filter_input(INPUT_POST, 'idRota');

	switch($acao){
		case 'verificarRotas':
			$rota->verificarPedido();
		break;

		case 'verificarPoltronas':
			$rota->verificarPoltronasOcupadas($idRota);
		break;

		case 'continuarCompra':
			$pass->continuarCompra();
		break;

		case 'concluirCompra':
			$pass->concluirCompra();
		break;

		case 'verRota':
			$rota->verRota();
		break;

		case 'resgatarPassagem':
			$pass->resgatarPassagem();
		break;

		case 'getDestinos':
			$rota->getDestinos();
		break;
	}
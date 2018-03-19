<?php 
	require_once '../database/Conexao.php';
	require_once '../controller/RodoviariaController.php';
	require_once '../controller/RotaController.php';
	require_once '../model/Rodoviaria.class.php';
	require_once '../model/Rota.class.php';

	$rodo = new Rodoviaria();
	$r = new RotaController();

	$rotas = $r->resgatarRotas();
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Rodoviária AS - Todas as Rotas</title>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="../public/css/bootstrap.min.css">
	<script defer src="https://use.fontawesome.com/releases/v5.0.6/js/all.js"></script>

</head>
<body>
	<nav class="navbar navbar-expand-lg  navbar-dark bg-primary">
		<a class="navbar-brand" href="../index.php">Rodoviária AS</a>
		<ul class="navbar-nav ml-auto">
			<li class="nav-item active"><a class="nav-link" href="../index.php"><i class="fas fa-chevron-left"></i> Voltar</a></li>
		</ul>
	</nav>
	
	<div class="container-fluid">
		<p><h2>Rotas Disponíveis</h2></p>
		<?php 
			foreach($rotas as $rota){ 
				$link = "../routes.php?acao=verRota&origem={$rota['id_origem']}&destino={$rota['id_destino']}";
		?>
		
			<div class="card">
  				<div class="card-body">
   					<a href="<?= $link; ?>" class="link"><?= $rodo->getCidade($rota['id_origem'])." -> ".$rodo->getCidade($rota['id_destino'])?></a>
  				</div>
  			</div>
		<?php } ?>
	</div>


	<script src="../public/js/jquery-3.3.1.js"></script>
	<script src="../public/js/bootstrap.min.js"></script>
</body>
</html>
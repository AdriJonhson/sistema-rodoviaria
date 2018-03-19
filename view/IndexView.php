<?php
	session_start();

	require_once 'model/Rodoviaria.class.php';
	require_once 'database/Conexao.php';

	$r = new Rodoviaria();
	$rodoviarias = $r->listarRodoviarias();
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Rodoviária AS</title>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="public/css/bootstrap.min.css">
	<script defer src="https://use.fontawesome.com/releases/v5.0.6/js/all.js"></script>

</head>
<body>

	<nav class="navbar navbar-expand-lg  navbar-dark bg-primary">
		<a class="navbar-brand" href="#">Rodoviária AS</a>
	</nav>

	<div class="container-fluid" id="divMain">
		
		<br>
		
		<div class="row">

			<div class="col">
				<?php require_once 'includes/mensagens.php'; ?>
			</div>
		</div>
	
		<br>

  		<div class="row">

			<div class="col">
			    
				<form action="controller/RotaController.php" method="POST">
					<input type="hidden" name="acao" value="verificarRotas">
					<input type="hidden" name="pag" value="index.php">

					<div class="form-group row">
    					<label for="dataIda" class="col-sm-2 col-form-label">Origem</label>
					    <div class="col-sm-10">
					      <select class="form-control" id="origem" name="origem">
					      	<option value="invalido">Cidade de Origem</option>

					      	<?php foreach($rodoviarias as $value){ ?>
								<option value="<?= $value['id']?>"> 
									<?= $value['name']; ?>
								</option>
					      	<?php } ?>

					      </select>
					    </div>
  					</div>

  					<div class="form-group row">
    					<label for="dataIda" class="col-sm-2 col-form-label">Destino</label>
					    <div class="col-sm-10">
					      <select class="form-control" id="destino" name="destino">
					      	<option value="invalido">Cidade de Destino</option>

					      	<?php foreach($rodoviarias as $value){ ?>
								<option value="<?= $value['id']?>">
									<?= $value['name']; ?>
								</option>
					      	<?php } ?>

					      </select>
					    </div>
  					</div>

					<div class="form-group row">
    					<label for="dataIda" class="col-sm-2 col-form-label">Ida</label>
					    <div class="col-sm-8">
					      <input type="date" class="form-control" id="dataIda" name="dataIda">
					    </div>
					    <div class="col-sm-2">
					    	<button class="btn btn-success"><i class="fas fa-suitcase"></i> Encontrar</button>
					    </div>
  					</div>
	
				</form>
			</div>
  		</div>
  	</div>

</body>
</html>
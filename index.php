<?php
	session_start();

	require_once 'model/Rodoviaria.class.php';
	require_once 'model/Horario.class.php';
	require_once 'controller/HorarioController.php';
	require_once 'database/Conexao.php';

	$r = new Rodoviaria();
	$rodoviarias = $r->listarRodoviarias();

	//Responsável por excluir do banco os horarios e rotas que já passaram da data e do horário;
	$h = new HorarioController();
	$h->encerrarHorarios();
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
		<a class="navbar-brand" href="index.php">Rodoviária AS</a>
		<ul class="navbar-nav ml-auto">
			<li class="nav-item active"><a class="nav-link" href="#" data-toggle="modal" data-target="#resgatePassagem"><i class="fas fa-address-card"></i> Resgatar Passagem</a></li>
			<li class="nav-item active"><a class="nav-link" href="view/MenuRotasView.php"><i class="fas fa-bus"></i> Ver Rotas</a></li>
		</ul>
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
			    
				<form action="routes.php" method="POST">
					<input type="hidden" name="acao" value="verificarRotas">
					<input type="hidden" name="pag" value="index.php">

					<div class="form-group row">
    					<label for="dataIda" class="col-sm-2 col-form-label">Origem</label>
					    <div class="col-sm-10">
					      <select class="form-control" id="origem" name="origem">
					      	<option value="invalido">Cidade de Origem</option>

					      	<?php foreach($rodoviarias as $value){ ?>
								<option value="<?= $value['id']?>"> 
									<?= $value['origem']; ?>
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

					      </select>
					    </div>
  					</div>

					<div class="form-group row">
    					<label for="dataIda" class="col-sm-2 col-form-label">Ida</label>
					    <div class="col-sm-8">
					      <input type="date" class="form-control" id="dataIda" name="dataIda" required="true">
					    </div>
					    <div class="col-sm-2">
					    	<button class="btn btn-success"><i class="fas fa-check-circle"></i> Encontrar</button>
					    </div>
  					</div>
	
				</form>
			</div>
  		</div>
  	</div>

	<!-- Modal -->
	<div class="modal fade" id="resgatePassagem" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="exampleModalLabel">Recuperar Passagem</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">
	        <form action="routes.php" method="POST">
	        	<input type="hidden" name="acao" value="resgatarPassagem">
	        	<div class="form-group">
	        		<label>Digite seu CPF: </label>
	        		<input type="number" class="form-control" name="inpCpf" placeholder="Apenas Números" min="1">
	        	</div>
	        
	      </div>
	      		<div class="modal-footer">
	        		<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
	        		<button type="submit" class="btn btn-primary">Continuar</button>
	    	</form>
	      </div>
	    </div>
	  </div>
	</div>


	<script src="public/js/jquery-3.3.1.js"></script>
	<script src="public/js/bootstrap.min.js"></script>
	<script src="public/js/script.js"></script>
</body>
</html>
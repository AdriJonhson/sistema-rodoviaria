<?php 
	session_start();
	require_once '../database/Conexao.php';
	require_once '../model/Horario.class.php';
	require_once '../controller/RodoviariaController.php';
	require_once '../controller/RotaController.php';
	require_once '../model/Rodoviaria.class.php';
	require_once '../model/Rota.class.php';
	require_once '../model/Passagem.class.php';

	$rc = new RodoviariaController();
	$rt = new RotaController();

	$h    = new Horario();
	$r    = new Rodoviaria();
	$rota = new Rota();

	$rodoviarias = $rc->listarRodoviarias();
	@$rotas = $_SESSION['dados_rota'];

	
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Rodoviária AS</title>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="../public/css/bootstrap.min.css">
	<script defer src="https://use.fontawesome.com/releases/v5.0.6/js/all.js"></script>
	
	<style>
		.card:hover{
			border-right: solid 1px;
			border-color: #28a745;
		}

		#resultado{
			margin-top: 5px;
		}

		#assentos-esquerda{
			float: left;
		}

		#assentos-direita{
			float: right;
		}
	</style>
</head>
<body>

	<nav class="navbar navbar-expand-lg  navbar-dark bg-primary">
		<a class="navbar-brand" href="../index.php">Rodoviária AS</a>
  		<ul class="navbar-nav ml-auto">
  			<form class="form-inline" method="POST" action="../routes.php">
  				<input type="hidden" name="acao" value="verificarRotas">
  				<input type="hidden" name="pag" value="RotaView.php">

	    		<select name="origem" id="origem" class="form-control mr-sm-2 col-form-label-sm">
				    <option value="invalido">Origem</option>
					<?php foreach($rodoviarias as $value){ ?>
							<option value="<?= $value['id']?>"> 
								<?= $value['origem']; ?>
							</option>
			      	<?php } ?>
				</select>

		     	<select name="destino" id="destino" class="form-control mr-sm-2 col-form-label-sm">
		     		
		     		<option value="invalido">Destino</option>

		     	</select>

		     	<input type="date" class="form-control mr-sm-2 col-form-label-sm" id="dataIda" name="dataIda" required="true">

		     	<button class="btn btn-success my-2 my-sm-0" type="submit" id="btnBuscar"><i class="fas fa-suitcase"></i> Encontrar</button>	
  			</form>	
  		</ul>  
	</nav>
	
	<div id="divResultado" class="container-fluid" style="margin-top: 5px;">
		<?php 
			require_once '../includes/mensagens.php';

			if(count($rotas) > 0){

				foreach($rotas as $rota){ 

					$qtd_max_assentos = 42;
					$qtd = $rt->contarPoltronas($rota['id']);
					$qtd_livre = $qtd_max_assentos - $qtd[0];

					if($qtd_livre == 0){
						$msg_lotado = "NENHUMA POLTRNA LIVRE";
					}
		?>

				<div class="card" name="card" id="card">
			  		<div class="card-header">
			    		<?php 
			    			echo $r->getCidade($rota['id_rodoviaria_origem']); 
			    			echo " ->";
			    			echo $r->getCidade($rota['id_rodoviaria_destino']); 
			    		?>
			 		</div>

			  		<div class="card-body">
				    	<blockquote class="blockquote mb-0">
				      		<p>
				      			<?php 
				      				echo "Data: ".$h->formatarData($rota['dt_ida']);
				      				echo " | Horário: ".$rota['hr_ida'];
				      				echo " | Preço:R$ ".number_format($rota['preco'], '2', ',', '.');
				      				echo " | Quantidade de poltronas livres: <span id='qtd_livre'>".(isset($msg_lotado) ? $msg_lotado : $qtd_livre).'</span>';
				      			?>
				      		</p>
				    	</blockquote>
			    		
			    		<footer>
			    			<button class="btn btn-success" data-toggle="modal" data-target="#modalPoltronas" id="btnChoice" onclick="verificarPoltronasLivre(<?= $rota['id'] ?>);setIdRota(<?= $rota['id'] ?>);">Escolher Poltrona</button>
			    		</footer>
			  		</div>
				</div>

			<br>

		<?php } }else{ ?>
		
			<div class="card text-white bg-success" style="margin-top: 5px;">
				<div class="card-header">Rodoviária AS</div>
			  		<div class="card-body">
			    		<h5 class="card-title">Nenhum viagem agendada, verifique novamente em algumas horas.</h5>
			  		</div>
				</div>
			</div>

		<?php } ?>				

	</div>
	
	<div class="modal fade" id="modalPoltronas" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	  <div class="modal-dialog modal-dialog-centered" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="exampleModalLongTitle">Escolha onde deseja se sentar: </h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body" id="assentos">
	      	<p>
	      		<label>Poltrona Selecionada: </label>
	      		<span id="spanNumPoltrona"><b></b></span>
	      	</p>
	      	<div id="assentos-esquerda">
		      	<script>
					var col = 1;

					for(let j = 1; j <= 21; j++){

						if(col == 4){
							document.write("<br>");
							col = 1;
						}
						document.write("<img width=50 name=poltrona id="+ j +" 	/>");
						col++;
					}
		      	</script>
	      	</div>

	      	<div id="assentos-direita">
		      	<script>
					var col = 1;

					for(let j = 22; j <= 42; j++){

						if(col == 4){
							document.write("<br>");
							col = 1;
						}
						document.write("<img width=50 name=poltrona id="+ j +" />");
						col++;
					}
		      	</script>
	      	</div>

	      </div>
	      <div class="modal-footer">
	      	<form action="../routes.php" method="POST">
	      		<input type="hidden" name="numPoltronaSelecionada" value="" id="poltronaSelecionada">
	      		<input type="hidden" name="idRota" value="" id="idRota">
	      		<input type="hidden" name="acao" value="continuarCompra">
	      		 
		        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
		        <button type="submit" class="btn btn-primary" id="btnContinuar" disabled>Continuar</button>
	        </form>
	      </div>
	    </div>
	  </div>
	</div>

	<script src="../public/js/jquery-3.3.1.js"></script>
	<script src="../public/js/bootstrap.min.js"></script>
	<script src="../public/js/script.js"></script>

</body>
</html>
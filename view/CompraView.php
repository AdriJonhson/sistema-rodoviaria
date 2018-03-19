<?php 
	session_start();
	require_once '../database/Conexao.php';
	require_once '../model/Horario.class.php';
	require_once '../model/Rodoviaria.class.php'; 

	$dadosViagem = $_SESSION['rota_selecionada'];
	$h = new Horario();
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Rodoviária AS</title>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="../public/css/bootstrap.min.css">
	<script defer src="https://use.fontawesome.com/releases/v5.0.6/js/all.js"></script>
	<script>
		var btnContinuar = document.getElementById('btnContinuar');

		btnContinuar.addEventListener('click', function(){
			window.location("../index.php");
			btnContinuar.value = "Continuar";
		});

	</script>

	<style>
		#card1{
			margin-top: 5px;
		}

		#card2{
			margin-top: 5px;	
		}
	</style>

</head>
<body>
	<nav class="navbar navbar-expand-lg  navbar-dark bg-primary">
		<a class="navbar-brand" href="../index.php">Rodoviária AS</a>
		<ul class="navbar-nav ml-auto">
			<li class="nav-item active"><a class="nav-link" href="RotaView.php"><i class="fas fa-chevron-left"></i> Voltar</a></li>
		</ul>
	</nav>
	
	<div class="container">
		
	<div class="card bg-light" id="card1">
		  <div class="card-header">
		  	<i class="fas fa-suitcase"></i>
		    Sobre a Viagem
		  </div>
		  <div class="card-body">
		    <blockquote class="blockquote mb-0">
			<table>
				
				<tr>
					<td>Origem: </td>
					<th><?= $dadosViagem['origem']?></th>
				</tr>
				<tr>
					<td>Destino: </td>
					<th><?= $dadosViagem['destino']?></th>
				</tr>
				<tr>
					<td>Data: </td>
					<th><?= $h->formatarData($dadosViagem['dt_ida']);?></th>
				</tr>

				<tr>
					<td>Horário: </td>
					<th><?= $dadosViagem['hr_ida']?></th>
				</tr>

				<tr>
					<td>Preço: </td>
					<th>R$<?= number_format($dadosViagem['preco'], '2', ',', '.');?></th>
				</tr>
				<tr>
					<td>Número da Poltrona: </td>
					<th> <?= $dadosViagem['numPoltrona']?></th>
				</tr>
			</table>

		    </blockquote>
		  </div>
		</div>
	</div>
	<p></p>
	<div class="container">
		<?php require_once '../includes/mensagens.php'; ?>
	</div>

	<div class="container">
		<div class="card bg-light" id="card2">
			<div class="card-header"><i class="fas fa-user-circle"></i> Dados Pessoais</div>
			<div class="card-body">
				<form action="../routes.php" method="POST">

					<div class="form-group row">
						<label for="inputNome" class="col-sm-2 col-form-label">Nome Completo</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" id="inputNome" placeholder="Digite seu nome completo" autofocus name="nome" value = "<?=isset($_SESSION['dados_old']['nome_old'])?$_SESSION['dados_old']['nome_old']:''?>" required>
						</div>
					</div>

					<div class="form-group row">
						<label for="inputDate" class="col-sm-2 col-form-label">Data de Nascimento</label>
						<div class="col-sm-10">
							<input type="date" class="form-control" id="inputDate" placeholder="Digite seu nome completo" name="dt_nascimento" value = "<?=isset($_SESSION['dados_old']['data_old'])?$_SESSION['dados_old']['data_old']:''?>" required>
						</div>
					</div>

					<div class="form-group row">
						<label for="inputDate" class="col-sm-2 col-form-label">CPF</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" id="inputDate" placeholder="Apenas Números" name="cpf" value = "<?=isset($_SESSION['dados_old']['cpf_old'])?$_SESSION['dados_old']['cpf_old']:''?>" maxlength="11" required>
						</div>
					</div>
					
					<div align="right">
						<input type="hidden" name="acao" value="concluirCompra">
						<button class="btn btn-primary" type="submit"><i class="fas fa-bus"></i> Finalizar Compra</button>
					</div>

					<?php unset($_SESSION['dados_old']); ?>
				</form>
			</div>
		</div>
	</div>

	<div class="modal fade" id="modalFinal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-backdrop="static">
		<div class="modal-dialog modal-dialog-centered" role="document">
		    <div class="modal-content">
		      <div class="modal-header">
		        <h5 class="modal-title" id="exampleModalLongTitle">Rodoviária AS</h5>
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		        </button>
		      </div>
		      <div class="modal-body">
		      	<p>Obrigado por escolher a Rodoviária AS, clique em continuar para imprimir sua passagem.</p>
		      </div>
		    <div class="modal-footer"> 
		    	<form action="PassagemView.php">	
				    <button type="submit" class="btn btn-primary" id="btnContinuar"><i class="fas fa-print"></i> Imprimir</button>
		    	</form>
		    </div>
		</div>
		</div>
	</div>

	<script src="../public/js/jquery-3.3.1.js"></script>
	<script src="../public/js/bootstrap.min.js"></script>
	<?php 
	if(isset($_SESSION['dados_passagem'])){
		echo "<script type=\"text/javascript\">
			$('#modalFinal').modal('show')
		</script>";
	}
	?>
</body>
</html>
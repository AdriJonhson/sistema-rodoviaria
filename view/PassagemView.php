<title>Passagem</title>
<link rel="stylesheet" href="../public/css/bootstrap.min.css">
<script>
	window.print();
</script>
<?php 
	session_start();
	require_once '../model/Rota.class.php';
	require_once '../database/Conexao.php';
	require_once '../model/Horario.class.php';
	require_once '../model/Rodoviaria.class.php';

	$rota = new Rota();
	$h    = new Horario();
	$r    = new Rodoviaria();

	$dados_passagem = $_SESSION['dados_passagem'];

	$dados_rota = $rota->getDadosRota($dados_passagem['id_rota']);

	$data = $h->formatarData($dados_rota[0]['dt_ida']);

	$origem = $r->getCidade($dados_rota[0]['id_rodoviaria_origem']);
	$destino = $r->getCidade($dados_rota[0]['id_rodoviaria_destino']);

?>
	
		<h1>Rodoviária AS</h1>
		<hr>
		<table width="100%">
			<tr>
				<th align="left">Origem</th>
				<td><?= $origem ?></td>
				<th align="left">Destino</th>
				<td><?= $destino ?></td>
			</tr>

			<tr>
				<th align="left">Data Embarque</th>
				<td><?= $data ?></td>
			</tr>

			<tr>
				<th align="left">Horário</th>
				<td><?= $dados_rota[0]['hr_ida'] ?></td>
				<th align="left">Número da Poltrona</th>
				<td><?= $dados_passagem['num_poltrona'] ?></td>
			</tr>

			<tr>
				<th align="left">Passageiro</th>
				<td><?= $dados_passagem['nome'];?></td>
				<th align="left">Total </th>
				<td><b>R$ <?= number_format($dados_rota[0]['preco'], 2, ',', '.') ?></b></td>
			</tr>
		</table>
		<hr>

		<a href="../index.php">Home</a>


<?php

	session_destroy();	

?>
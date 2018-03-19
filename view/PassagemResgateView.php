<title>Passagem</title>
<link rel="stylesheet" href="../public/css/bootstrap.min.css">
<script>
	window.print(); 
</script> 
<?php      
	session_start();
	require_once '../model/Rota.class.php';     
	require_once'../database/Conexao.php';     
	require_once '../model/Horario.class.php';
	require_once '../model/Rodoviaria.class.php';

	$rota = new Rota();
	$h    = new Horario();
	$r    = new Rodoviaria();

	$dados_passagem = $_SESSION['dados_passagem'];

	foreach($dados_passagem as $dados){

		$num_poltrona = $dados['num_poltrona'];

		$dados_rota = $rota->getDadosRota($dados['id_rota']);

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
				<td><?= $num_poltrona ?></td>
			</tr>

			<tr>
				<th align="left">Passageiro</th>
				<td><?= $dados['nome'];?></td>
				<th align="left">Total </th>
				<td><b>R$ <?= number_format($dados_rota[0]['preco'], 2, ',', '.') ?></b></td>
			</tr>
		</table>
		<hr>



<?php 
		@session_destroy();
	}
?>
<a href="../index.php">Home</a>
<?php 
	
class Rota{
	private $id;
	private $id_rodoviaria_origem;
	private $id_rodoviaria_destino;
	private $id_horario;
	private $preco;


	//Função que verificar se existe a rota que o usuário procura
	function verificarRota($origem, $destino, $dataIda)
	{
		$con = startConnection();
		$sql = "SELECT r.id_rodoviaria_origem, r.id_rodoviaria_destino, r.id,r.preco, h.dt_ida, h.hr_ida 
				FROM rotas AS r 
				JOIN horarios AS h
				ON r.id_horario = h.id
				WHERE r.id_rodoviaria_origem = ? AND r.id_rodoviaria_destino = ? AND h.dt_ida = ?";

		$stmt = $con->prepare($sql);
		$stmt->bindValue(1, $origem);
		$stmt->bindValue(2, $destino);
		$stmt->bindValue(3, $dataIda);
		$stmt->execute();

		$result = $stmt->fetchAll();

		return $result;
	}

	//Função que retornar as poltronas ocupas em determinada rota
	function verificarPoltronasOcupadas($idRota)
	{

		$con = startConnection();
		$sql = "SELECT num_poltrona FROM passagens WHERE id_rota = ?";
		$stmt = $con->prepare($sql);
		$stmt->bindValue(1, $idRota);
		$stmt->execute();

		$result = $stmt->fetchAll();

		echo json_encode($result);
	}

	//Função que captura os dados de uma rota específica
	function getDadosRota($idRota)
	{
		$con = startConnection();
		$sql = "SELECT r.id_rodoviaria_origem, r.id_rodoviaria_destino, r.id,r.preco, h.dt_ida, h.hr_ida 
				FROM rotas AS r 
				JOIN horarios AS h
				ON r.id_horario = h.id
				WHERE r.id = ?";

		$stmt = $con->prepare($sql);
		$stmt->bindValue(1, $idRota);
		$stmt->execute();

		$result = $stmt->fetchAll();

		return $result;
	}

	//Função que retornar todas as rotas disponíveis
	function capturarTodasRotas()
	{
		$con = startConnection();
		$sql = "SELECT id_rodoviaria_origem as id_origem, id_rodoviaria_destino as id_destino
				FROM rotas 
				GROUP BY id_rodoviaria_origem, id_rodoviaria_destino";

		$stmt = $con->prepare($sql);
		$stmt->execute();

		$result = $stmt->fetchAll();

		return $result;
	}

	function verRota($origem, $destino)
	{
		$con = startConnection();
		$sql = "SELECT r.id_rodoviaria_origem, r.id_rodoviaria_destino, r.id,r.preco, h.dt_ida, h.hr_ida 
				FROM rotas AS r 
				JOIN horarios AS h
				ON r.id_horario = h.id
				WHERE r.id_rodoviaria_origem = ? AND r.id_rodoviaria_destino = ?";

		$stmt = $con->prepare($sql);
		$stmt->bindValue(1, $origem);
		$stmt->bindValue(2, $destino);
		$stmt->execute();

		$result = $stmt->fetchAll();

		return $result;
	}

	//Retornar o nome dos lugares de destino de acordo com o lugar de origem selecionado
	function getDestino($id_origem)
	{
		$con = startConnection();
		$sql = "SELECT rt.id_rodoviaria_destino as id, CONCAT(rd.cidade, ' - ', rd.estado) AS destino
				FROM rotas AS rt
				JOIN rodoviarias AS rd
				ON rt.id_rodoviaria_destino = rd.id
				WHERE rt.id_rodoviaria_origem = ?";
		$stmt = $con->prepare($sql);
		$stmt->bindValue(1, $id_origem);
		$stmt->execute();

		$result = $stmt->fetchAll();

		echo json_encode($result);
	}

}
<?php 

class Passagem{

	public function validarCpf($cpf, $id_rota)
	{
		$con = startConnection();

		$sql = "SELECT cpf FROM passagens WHERE cpf = ? AND id_rota = ?";
		$stmt = $con->prepare($sql);
		$stmt->bindValue(1, $cpf);
		$stmt->bindValue(2, $id_rota);
		$stmt->execute();

		if($stmt->rowCount() >= 1){
			return true;
		}
	}

	public function cadastrarPassageiro($id_rota, $nome, $cpf, $dt_nascimento, $num_poltrona)
	{
		$con = startConnection();

		$sql = "INSERT INTO passagens(id_rota, nome, cpf, dt_nascimento, num_poltrona) VALUES(?, ?, ?, ?, ?)";
		$stmt = $con->prepare($sql);
		$stmt->bindValue(1, $id_rota);
		$stmt->bindValue(2, $nome);
		$stmt->bindValue(3, $cpf);
		$stmt->bindValue(4, $dt_nascimento);
		$stmt->bindValue(5, $num_poltrona);
		$stmt->execute();

		if($stmt->rowCount() > 0){
			return true;
		}else{
			// print_r($con->errorInfo());
			return false;
		}
	}

	public function resgatarPassagens($cpf)
	{
		$con = startConnection();

		$sql = "SELECT id_rota, num_poltrona,nome FROM passagens WHERE cpf = ?";
		$stmt = $con->prepare($sql);
		$stmt->bindValue(1, $cpf);
		$stmt->execute();
		$result = $stmt->fetchAll();

		if($stmt->rowCount() >= 1){
			return $result;
		}
	}

	public function contarPoltronas($id)
	{
		$con   = startConnection();
		$sql   = "SELECT COUNT(num_poltrona) as qtd_poltrona FROM passagens WHERE id_rota = ?";
		$stmt  = $con->prepare($sql);
		$stmt->bindValue(1, $id);
		$stmt->execute();

		$result = $stmt->fetchAll();

		foreach($result as $row){
			$qtd[] = $row['qtd_poltrona'];
		}

		return $qtd;
	}

}
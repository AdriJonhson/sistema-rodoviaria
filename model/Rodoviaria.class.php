<?php 

class Rodoviaria{

	private $id;
	private $estado;
	private $cidade;

	public function listarRodoviarias()
    {
		$con  = startConnection();	

        $sql = "SELECT CONCAT(r.cidade, ' - ', r.estado) AS origem, r.id 
        FROM rodoviarias AS r
        WHERE r.id IN(SELECT id_rodoviaria_origem FROM rotas);";

		$stmt = $con->prepare($sql); 
		$stmt->execute();

        $result = $stmt->fetchAll();

        return $result;
	}

    public function getCidade($idCidade)
    {
        $con  = startConnection();  

        $sql = "SELECT CONCAT(cidade, '-', estado) as local FROM rodoviarias WHERE id = ?";
        $stmt = $con->prepare($sql); 
        $stmt->bindValue(1, $idCidade);
        $stmt->execute();

        $result = $stmt->fetchAll();


        return $result[0]['local'];
    }
}
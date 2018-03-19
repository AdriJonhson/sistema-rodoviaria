<?php 

class Horario{

    public function formatarData($data)
    {
        $arrayData = explode('-', $data);

        $data = $arrayData[2].'/'.$arrayData[1].'/'.$arrayData[0];

        return $data;
    }

    public function getHorariosHoje()
    {
        date_default_timezone_set('America/Sao_Paulo');

        $con = startConnection();
        $dataAtual = date('Y-m-d');
        $hora = date('H:i:s');

        $sql = "SELECT * FROM horarios WHERE dt_ida <= ? AND hr_ida < ?";

        $stmt = $con->prepare($sql);
        $stmt->bindValue(1, $dataAtual);
        $stmt->bindValue(2, $hora);
        $stmt->execute();
        $result = $stmt->fetchAll();

        foreach($result as $row){
            $horariosDelete[] = $row['id'];
        }

        //Se por acaso não houver rotas para serem deletadas
        if(!isset($horariosDelete)){
            $horariosDelete = ['id' => 0];
        }

        return $horariosDelete;
    }

    public function encerrarHorario($horarios)
    {
        $con  = startConnection();
        $sql  = "DELETE FROM horarios WHERE id = ?";
        $stmt = $con->prepare($sql);

        foreach($horarios as $horario){
            $stmt->bindValue(1, $horario);
            $stmt->execute();
        }

    }

}
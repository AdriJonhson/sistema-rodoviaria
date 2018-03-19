<?php 

class HorarioController{

	public function encerrarHorarios(){
		$h = new Horario();
		$horariosDelete = $h->getHorariosHoje();
		$h->encerrarHorario($horariosDelete);
	}
}
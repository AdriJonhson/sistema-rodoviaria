<?php 
/*require_once '../database/Conexao.php';
require_once '../model/Rodoviaria.class.php';*/

class RodoviariaController {
	
	public function listarRodoviarias()
	{
		$r = new Rodoviaria();
		$rodoviarias = $r->listarRodoviarias();
		return $rodoviarias;
	}
}

<?php 

	function startConnection(){
		$HOST = 'mysql:host=localhost;dbname=db_rodoviaria;charset=utf8';
		$USER = 'root';
		$PASS = '';

		try{
			$conection = new PDO($HOST, $USER, $PASS);
			return $conection;
		}catch(PDOException $ex){
			die($e->getMessage());
		}

	}
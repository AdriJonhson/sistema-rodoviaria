<?php 

	if(isset($_SESSION['msg_erro'])){
		echo "<div class='alert alert alert-danger' role='alert'>";
		echo $_SESSION['msg_erro'];
		echo "</div>";

		unset($_SESSION['msg_erro']);
	}

	if(isset($_SESSION['msg_success'])){
		echo "<div class='alert alert alert-primary' role='alert'>";
		echo $_SESSION['msg_success'];
		echo "</div>";
		
		unset($_SESSION['msg_success']);
	}
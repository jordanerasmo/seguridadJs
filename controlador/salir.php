<?php
	include('validar.php');
	if(isset($_POST['btnsi'])){		
		session_destroy();
	}
	header('Location:http://localhost/poo');
?>
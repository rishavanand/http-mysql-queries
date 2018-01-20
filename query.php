<?php

require 'database.php';

if(isset($_POST['sql'], $_POST['hostname'], $_POST['database'], $_POST['user'], $_POST['pass'])){

	// Form validation
	if(empty($_POST['hostname'])){
		echo json_encode(array(
			'success' => false,
			'error' => 'Please fill hostname field'
		));
		exit();
	}else if(empty($_POST['database'])){
		echo json_encode(array(
			'success' => false,
			'error' => 'Please fill database field'
		));
		exit();
	}else if(empty($_POST['user'])){
		echo json_encode(array(
			'success' => false,
			'error' => 'Please fill user field'
		));
		exit();
	}else if(empty($_POST['pass'])){
		echo json_encode(array(
			'success' => false,
			'error' => 'Please fill password field'
		));
		exit();
	}else if(empty($_POST['sql'])){
		echo json_encode(array(
			'success' => false,
			'error' => 'Please fill sql query'
		));
		exit();
	}


	$hostname = $_POST['hostname'];
	$database = $_POST['database'];
	$user = $_POST['user'];
	$pass = $_POST['pass'];
	$q = new ProcessQuery();
	if($q->connect($hostname, $database, $user, $pass)){
		$sql = $_POST['sql'];
		echo json_encode($q->perform_query($sql));
	}else{
		echo json_encode(array(
			'success' => false,
			'error' => $q->connect_error
		));
	}
}else{ // When page is directly accessed
	echo json_encode(array(
		'success' => false,
		'error' => 'Invalid request'
	));
}

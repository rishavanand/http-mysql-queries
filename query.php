<?php

require 'database.php';

if(isset($_POST['sql']) && $_POST['sql']){
	$q = new ProcessQuery();
	if($q->connect()){
		$sql = $_POST['sql'];
		echo json_encode($q->perform_query($sql));
	}else{
		echo json_encode(array(
			'success' => false,
			'connect_error' => $q->connect_error
		));
	}
}else{
	echo json_encode(array(
		'success' => false,
		'error' => 'Error : Invalid query'
	));
}

<?php 

error_reporting(E_ERROR | E_PARSE);

class ProcessQuery{

	public $connect_error = 0;

	// Create connection
	function connect($hostname, $database, $user, $pass){

		$this->conn = new mysqli($hostname, $user, $pass, $database);
		if($this->conn->connect_error){
			$this->connect_error = $this->conn->connect_error;
			return false;
		}else{
			return true;
		}

	}

	// Perform sql query
	function perform_query($sql){

	    $result = $this->conn->query($sql);
	    $result_type = gettype($result);

	    // Response is a boolean
	    if($result_type == 'boolean'){
	    	$return_data['type'] = 'boolean';
	    	if($result){
	    		$return_data['success'] = true;
	    	}else{
	    		$return_data['success'] = false;
	    		$return_data['error'] = $this->conn->error;
	    	}
	    }elseif($result_type == 'object'){ // Response is an object containing your fetched data
	    	$return_data['type'] = 'object';
		    if($result->num_rows > 0){
		    	$return_data['success'] = true;
		    	$return_data['data'] = $this->create_markup($result);
		    }else{
		    	$return_data['success'] = false;
		        $return_data['error'] = $this->conn->error;
		    }
		}

		return $return_data;

	}

	// Return markup
	function create_markup($result){

		$table_header_flag = 0;
		$return_data = '<table class="table">';

	    while($row = $result->fetch_assoc()){
	    	if(!$table_header_flag){
	    		$keys = array_keys($row);
	    		$return_data = $return_data . '<thead><tr>';
	    		foreach ($keys as $key) {
	    			$return_data = $return_data . '<td><strong>' . $key . '</strong></td>';
	    		}
	    		$return_data = $return_data . '</tr></thead>';
	    		$table_header_flag = 1;
	    	}
	    	$return_data = $return_data .  "<tr>";
	        foreach ($row as $key=>$value){
	            $return_data = $return_data .  '<td>' . $value. '</td>';
	        }
	        $return_data = $return_data .  "</tr>";
    	}

    	$return_data = $return_data . '</table>';

    	return $return_data;

	}

}

<?php
	include('config.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Simple Sidebar - Start Bootstrap Template</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/simple-sidebar.css" rel="stylesheet">

</head>

<body>

    <div id="wrapper">

        <!-- Sidebar -->
        <div id="sidebar-wrapper">
            <ul class="sidebar-nav">
                <li class="sidebar-brand">
                    <a href="#">
                        <b>MySQL Live Queries</b>
                    </a>
                </li>
                <li>
                    <a href="#">Queries</a>
                </li>
                <li>
                    <a href="#">GitHub Repo</a>
                </li>
            </ul>
        </div>
        <!-- /#sidebar-wrapper -->

        <!-- Page Content -->
        <div id="page-content-wrapper">
            <div class="container-fluid">
                <h4><b>MySQL Live Queries</b></h4>
                <a href="#menu-toggle" class="btn btn-xs btn-primary" id="menu-toggle">Toggle Menu</a><hr>
                <table class="table">
	                <?php
	                    $conn = new mysqli($host, $dbuser, $pass, $table);
	                    if($conn->connect_error)
	                        echo $conn->connect_error;
	                    else
	                        echo 'Connected to Database!<br>';
	                    $sql = 'select * from orders';
	                    $result = $conn->query($sql);

	                    if($result->num_rows > 0){
	                    	print_table($result);
	                    }else{
	                        var_dump($conn->connect_error);
	                    }
	                ?>
            	</table>
            </div>
        </div>
        <!-- /#page-content-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- Bootstrap core JavaScript -->
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>

    <!-- Menu Toggle Script -->
    <script>
    $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });
    </script>

</body>

</html>

<?php 

function print_table($result){
	$table_header_flag = 0;
    while($row = $result->fetch_assoc()){
    	if(!$table_header_flag){
    		$keys = array_keys($row);
    		echo '<thead><tr>';
    		foreach ($keys as $key) {
    			echo '<td>' . $key . '</td>';
    		}
    		echo '<thead><tr>';
    		$table_header_flag = 1;
    	}
    	echo "<tr>";
        foreach ($row as $key=>$value){
            echo '<td>' . $value. '</td>';
        }
        echo "</tr>";
    }
}

?>

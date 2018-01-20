<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>MySQL Live Queries</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/style.css" rel="stylesheet">

</head>

<body>

    <!-- Fixed navbar -->
    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">MySQL Live Queries</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
            <li><a href="#">MySQL cheat sheet</a></li>
            <li><a href="#">Github Repo</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>

    <div class="container">
	  	<div class="col-md-12">
	  	<div class="panel panel-primary">
	  		<div class="panel-heading">
	  			Credentials
	  		</div>
	  		<div class="panel-body zero-lr-padding">
	  			<div class="col-md-3">
					<input id="database-host" class="form-control" type="text" placeholder="Host" required>
				</div>
				<div class="col-md-3">
					<input id="database-name" class="form-control" type="text" placeholder="Database name" required>
				</div>
				<div class="col-md-3">
					<input id="database-user" class="form-control" type="text" placeholder="Databse user" required>
				</div>
				<div class="col-md-3">
					<input id="database-pass" class="form-control" type="password" placeholder="Password" required>
				</div>
	  		</div>
	  	</div>
	  </div>

	<div class="col-md-12 add-query-box">
		<div class="panel panel-default">
			<div class="panel-body">
				<center>
					Add additional query boxes
					<button class="btn btn-primary btn-xs" onclick="addQueryBox()">+1</button>
				</center>
			</div>
		</div>
	</div>

	<div id="query-boxes">
  		<div class="col-md-6" id="query-div-1">
		    <div class="panel panel-default">
		      	<div class="panel-heading">
					<div class="form-group">
						<label for="comment">SQL Query:</label>
						<div class="pull-right">
							<button class="btn btn-primary btn-xs" id='1' onclick="query(this.id)">Execute</button>
						</div>
						<textarea class="form-control" rows="1" id="query-input-1"></textarea>
					</div> 
		      	</div>
		      	<div class="panel-body">
		      		<div class="query-error" id="query-error-1"></div>
		      		<div class="table-responsive" id='query-response-1'>
				        Query results will appear here after you make one.
				    </div>
				</div>
		    </div>
		</div>
	</div>

		

    </div> <!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script>window.jQuery || document.write('<script src="js/jquery.min.js"><\/script>')</script>
    <script src="js/bootstrap.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>
    <script>

    	var totalQueryBoxes = 1;

    	function addQueryBox(){
    		totalQueryBoxes += 1;
    		$('#query-boxes').append(getMarkup(totalQueryBoxes));
    	}

    	function getMarkup(id){
    		var markup = `<div class="col-md-6" id="query-div-`+ id +`">
			    <div class="panel panel-default">
			      	<div class="panel-heading">
						<div class="form-group">
							<label for="comment">SQL Query:</label>
							<div class="pull-right">
								<button class="btn btn-primary btn-xs" id="`+ id +`" onclick="query(this.id)">Execute</button>
							</div>
							<textarea class="form-control" rows="1" id="query-input-`+ id +`"></textarea>
						</div> 
			      	</div>
			      	<div class="panel-body">
			      		<div class="query-error" id="query-error-`+ id +`"></div>
			      		<div class="table-responsive" id="query-response-`+ id +`">
					        Query results will appear here after you make one.
					    </div>
					</div>
			    </div>
			</div>`;
			return markup;
    	}

    	function query(id){
    		$('#query-error-' + id).html('');
    		$('#query-response-' + id).html('');
    		var sql = $('#query-input-' + id).val();
    		var hostname = $('#database-host').val();
    		var database = $('#database-name').val();
    		var user = $('#database-user').val();
    		var pass = $('#database-pass').val();
    		$.post('query.php', {
    			'sql': sql,
    			'hostname': hostname,
    			'database': database,
    			'user': user,
    			'pass': pass
    		}, function(res, status){
    			res = JSON.parse(res);
    			console.log(res);
    			if(res.success){
    				if(res.type == 'object')
    					$('#query-response-' + id).html(res.data);
    				else if(res.type == 'boolean')
    					$('#query-response-' + id).html('<div class="success-msg"> Executed successfully. </div>');
    			}else{
    				$('#query-error-' + id).html(res.error);	
    			}
    		});
    	}
    </script>
  </body>
</html>

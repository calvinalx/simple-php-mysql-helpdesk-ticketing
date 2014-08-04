<?php
	try{
			
				$mysqli = new mysqli("localhost:3306", "root", "root", "userrequest");
				if ($mysqli->connect_errno) {
					echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
				}else{
					$date = date('Y-m-d H:i:s');
					/*Request authorisation status*/
					$sqlquery = "SELECT * FROM request";
					$result = $mysqli->query($sqlquery);
					$num_row = mysqli_num_rows($result);
				}
			} catch(Exception $e) {
				echo "error";
			}
?>

<!DOCTYPE html>
<html>
    <head>
    	<meta http-equiv="X-UA-Compatible" content="IE=Edge">
			<meta charset="UTF-8">
			<title>ADM BI User request list</title>
			<link rel="stylesheet" href="/userrequest/css/bootstrap.min.css">
			<link rel="stylesheet" href="//cdn.datatables.net/plug-ins/be7019ee387/integration/bootstrap/3/dataTables.bootstrap.css">
			<link rel="stylesheet" href="/userrequest/css/personal.css">
			
			<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
			<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js" type="text/javascript"></script>
			<script type="text/javascript" language="javascript" src="//cdn.datatables.net/1.10.1/js/jquery.dataTables.min.js"></script>
			<script src="//cdn.datatables.net/plug-ins/be7019ee387/integration/bootstrap/3/dataTables.bootstrap.js"></script>
						
			<script>
			    $( document ).ready(function() {
			    	$('#userRequestList').dataTable();
			    	
			    	/*$('#userRequestList tbody').on( 'click', 'tr', function () {
				    	$(this).toggleClass('selected');
				    });*/
				 
				    /*$('#button').click( function () {
				    	alert( table.rows('.selected').data().length +' row(s) selected' );
				    });*/
				    
				    $('#userRequestList td').click( function () {
							$('#myModal').modal('show');
						});
			    });
			</script>
    </head>
    <body>
    	<div class="container">
        <div class="row clearfix">
            <div class="col-md-12 column">
                <div class="jumbotron">
                    <h1>
                        ADM BI User request list.
                    </h1>
                </div>
            </div>
        </div>

        <div class="row clearfix">
          <div class="col-md-12 column">
						<table id="userRequestList" class="table table-striped table-bordered dataTable no-footer" cellspacing="0" width="100%" role="grid" aria-describedby="example_info" style="width: 100%;">
							<thead>
			  				<tr>
									<th>Support</th>
									<th>User name</th>
									<th>User id</th>
									<th>Email</th>
									<th>Rebilling code</th>
									<th>Subject</th>
									<th>Request</th>
								</tr>
							</thead>
							<tbody>
								<?php
								
								while ($row = mysqli_fetch_array($result)) {
								    echo "<tr>";
								    echo "<td>" . urldecode($row["support_line"]) . "</td>";
								    echo "<td>" . urldecode($row["user_name"]) . "</td>";
								    echo "<td>" . urldecode($row["user_id"]) . "</td>";
								    echo "<td>" . urldecode($row["email"]) . "</td>";
								    echo "<td>" . urldecode($row["application_code"]) . "</td>";
								    echo "<td>" . urldecode($row["request_domain"]) . "</td>";
								    echo "<td>" . urldecode($row["details"]) . "</td>";
								    echo "</tr>";
								}
								
								?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
			
			<!-- Modal -->
			<div id="myModal" class="modal fade">
			    <div class="modal-dialog">
			        <div class="modal-content">
			            <div class="modal-header">
			                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			                <h4 class="modal-title">Assign</h4>
			            </div>
			            <div class="modal-body">
			                <p>Select a person on the list to assign this task</p>
			                <p class="text-warning"><small>By default your UserId is already selected</small></p>
			            </div>
			            <div class="modal-footer">
			                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
			                <button type="button" class="btn btn-primary">Assign</button>
			            </div>
			        </div>
			    </div>
			</div>
			
			<script type="text/javascript">
				// For demo to fit into DataTables site builder...
				$('#example')
					.removeClass( 'display' )
					.addClass('table table-striped table-bordered');
			</script>
    
    </body>
</html>
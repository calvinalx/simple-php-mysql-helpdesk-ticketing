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
			<link rel="stylesheet" href="/userrequest/css/bootstrap-select.min.css" media="all"  type="text/css" />
			<link rel="stylesheet" href="/userrequest/css/personal.css">
			
			<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
			<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js" type="text/javascript"></script>
			<script src="/userrequest/js/bootstrap-select.min.js" type="text/javascript"></script>
			<!-- <script type="text/javascript" charset="utf8" src="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.0/jquery.dataTables.min.js"></script> -->
			<script type="text/javascript" language="javascript" src="//cdn.datatables.net/1.10.2/js/jquery.dataTables.min.js"></script>
			<script src="//cdn.datatables.net/plug-ins/be7019ee387/integration/bootstrap/3/dataTables.bootstrap.js"></script>
			<script src="/userrequest/js/static_values.json"></script>
						
			<script>
			    $( document ).ready(function() {
			    	// http://silviomoreto.github.io/bootstrap-select/3/
			      $('.selectpicker').selectpicker();
			    	
			    	var selected_assign = my_static_value["assign"][0];
			    	var table_row_datas = "";
			    	var aPos;
			    	var aData;
			    	
			    	var oTable = $('#userRequestList').dataTable({
				    	"columnDefs": [
					      {
					      	"targets": [ 0 ],
					        "visible": false,
					        "searchable": false
					      },
					      {
					      	"targets": [ 4 ],
					        "visible": false,
					        "searchable": false
					      }
				      ]
				    });
				    
				    $('#assign_button').click(function() {
							selected_assign = $("#assign_id option:selected").val();
							update_assign(table_row_datas[0], selected_assign, aPos, oTable);
							$('#myModal').modal('hide');
						});
				    
				    $.each(my_static_value["assign"], function( key, value ) {
				    	$("#assign_id").append(value);
				    });
				    $('#assign_id').selectpicker('refresh');
				    			    					
						$('#userRequestList tbody').on( 'click', 'tr', function () {
							aPos = oTable.fnGetPosition( this );
							if(aPos!=null){
								table_row_datas = oTable.fnGetData( aPos );//get data of the clicked row
							}
							$('#myModal').modal('show');
						});

			    });
			    
			    function update_assign(row_id, assign_id, aPos, oTable){
						/*alert(row_id + " " + assign_id);*/
									    
				    $.ajax({
					    type: 'POST',
					    url: 'assign.php',
					    data: {'row_id': row_id, 'assign_id': assign_id},
					    success: function(msg) {
					      /*$('#userRequestList').dataTable().fnUpdate(assign_id , parseInt(aPos), 4, false, false);*/
					      oTable.fnUpdate(assign_id , parseInt(aPos), 6);
					    }
					  });
					}
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
			  					<th>id</th>
									<th>Support</th>
									<th>Requester</th>
									<!-- <th>User id</th> -->
									<!-- <th>Email</th> -->
									<th>Rebilling code</th>
									<th>Subject</th>
									<th>Request</th>
									<th>Assigned</th>
								</tr>
							</thead>
							<tbody>
							<?php
								while ($row = mysqli_fetch_array($result)) {
								    echo "<tr>";
								    echo "<td>" . urldecode($row["id"]) . "</td>";
								    echo "<td>" . urldecode($row["support_line"]) . "</td>";
								    echo "<td>" . urldecode($row["user_name"]) . "</td>";
								    /*echo "<td>" . urldecode($row["user_id"]) . "</td>";*/
								    /*echo "<td>" . urldecode($row["email"]) . "</td>";*/
								    echo "<td>" . urldecode($row["application_code"]) . "</td>";
								    echo "<td>" . urldecode($row["request_domain"]) . "</td>";
								    echo "<td>" . urldecode($row["details"]) . "</td>";
								    echo "<td>" . urldecode($row["assigned"]) . "</td>";
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
			                <h4 class="modal-title">Assign this task to:</h4>
			            </div>
			            <div class="modal-body">
			                <p id="modal_body_txt"></p>
			                
			                <!-- Select Basic -->
                      <div class="control-group">
                        <div class="controls">
                          <select id="assign_id" name="assign_id" class="selectpicker" title="" data-width="100%">
                          </select>
                        </div>
                      </div>
			            </div>
			            <div class="modal-footer">
			                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
			                <button type="button" id="assign_button" class="btn btn-primary">Assign</button>
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
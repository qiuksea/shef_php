<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>My Role Form Demo</title>

    <!-- Bootstrap -->
    <!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	<!-- Optional theme -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
	<?php
	/* 
	  // db connection
	  include 'connect.php';
	  
	  // select all records
      $records_query = "SELECT 	contacts.id as contactID, contacts.name as contactName, 
						contacts.username, contacts.email, contacts.phone, contacts.further_info, 
						faculties.name as facultyName, departments.name as departmentName
						FROM contacts, faculties, departments
						WHERE contacts.faculty_id = faculties.id AND contacts.department_id = departments.id
						ORDER BY contacts.name";

	 $dispplay_records = $conn->query($records_query);
	 
	 
	// output headers so that the file is downloaded rather than displayed
	//header('Content-type: text/csv');
	//header('Content-Disposition: attachment; filename="demo.csv"');
	
	// do not cache the file
	header('Pragma: no-cache');
	header('Expires: 0'); */
	
	// create a file pointer connected to the output stream
	//$file = fopen('php://output', 'w');

	#pdf function
	function fetch_data()
	{


		// db connection
	  include 'connect.php';
	  
	  // select all records
      $records_query = "SELECT 	contacts.id as contactID, contacts.name as contactName, 
						contacts.username, contacts.email, contacts.phone, contacts.further_info, 
						faculties.name as facultyName, departments.name as departmentName
						FROM contacts, faculties, departments
						WHERE contacts.faculty_id = faculties.id AND contacts.department_id = departments.id
						ORDER BY contacts.name";
						
	 $dispplay_records = $conn->query($records_query);


		$output = '';

		if ($dispplay_records->num_rows > 0) {

			while($row = $dispplay_records->fetch_assoc()) {

				$output .= "<tr>
									<td>" . $row["contactName"] . "</td>
									<td>" . $row["facultyName"] . "</td>
									<td>" . $row["departmentName"] . "</td>
									<td>" . $row["username"] . "</td>
									<td>" . $row["email"] . "</td>
									<td>" . $row["phone"] . "</td>
									<td>"; 
									//find multiple roles for contact-record
				$contact_roles_query = "SELECT roles.name as roleName
									FROM contacts, contacts_roles, roles 
									WHERE contacts.id = {$row['contactID']}
									AND contacts.id = contacts_roles.contact_id AND contacts_roles.role_id = roles.id ";
				$role_records = $conn->query($contact_roles_query);

				$output .= "<ul>";
									foreach($role_records as $value){
										$output .= "<li>"
										. $value['roleName'] .
												   "</li>";
									}
				$output .= "</ul>
									</td>";
				$output .= "<td>" . $row["further_info"] . "</td>
									</tr>";

			}		

		} else {

			$output .= "There is 0 result";
		}

		return $output;

	}


	if(isset($_POST["create_pdf"]))
	{

		require_once("tcpdf/tcpdf.php");


		$obj_pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		$obj_pdf->AddPage();
		$obj_pdf->SetCreator(PDF_CREATOR);
		$obj_pdf->SetTitle('Export ');
		$obj_pdf->SetHeaderData('','',PDF_HEADER_TITLE, PDF_HEADER_STRING);
		$obj_pdf->SetHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$obj_pdf->SetFooterFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$obj_pdf->SetDefaultMonospacedFont('helvetica');
		$obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
		$obj_pdf->SetMargins(PDF_MARGIN_LEFT, '5', PDF_MARGIN_RIGHT);
		$obj_pdf->SetPrintHeader(false);
		$obj_pdf->setPrintFooter(false);
		$obj_pdf->SetAutoPageBreak(TRUE, 10);
		$obj_pdf->SetFont('helvetica', '', 12);

		$content = '';
		$content .= '

			<h3>Export</h3>

			<table border="1" cellspacing="0" cellpadding="5">
				<tr>
					<th width="10%">Name</th> 
					<th width="10%">Faculty</th>
					<th width="10%">Department</th>
					<th width="10%">Username</th>
					<th width="10%">Email</th>
					<th width="10%">Phone</th>
					<th width="20%">Roles</th>
					<th>Further Information</th>
				</tr>		
		';

		$content .= fetch_data();


		$content .= "</table>";

		$obj_pdf->writeHTML($content);

		#https://stackoverflow.com/questions/16011050/tcpdf-error-some-data-has-already-been-output-cant-send-pdf-file

		ob_end_clean();

		$obj_pdf->Output("sample.pdf", "I");
		


	}




 
	?>
	<section id="display_records">
		<div class="container">
			<div class="row">
				<div class="col-md-10 col-md-offset-1">
				  <h2>myTeam requests records</h2>			

				  <form method="post">
				  	<input type="submit" name="create_pdf" class="btn btn-danger" value="Create PDF" />
				  </form>

				  <br>

					<table class="table table-bordered table-hover">
					  <tr class="info">
							<th>Name</th> 
							<th>Faculty</th>
							<th>Department</th>
							<th>Username</th>
							<th>Email</th>
							<th>Phone</th>
							<th>Roles</th>
							<th>Further Information</th>
					  <?php

					  echo fetch_data();

					  /*
						   if ($dispplay_records->num_rows > 0) {
							while($row = $dispplay_records->fetch_assoc()) {
								echo "<tr>";
								echo "<td>" . $row["contactID"] . "</td>";
								echo "<td>" . $row["contactName"] . "</td>";
								echo "<td>" . $row["facultyName"] . "</td>";
								echo "<td>" . $row["departmentName"] . "</td>";
								echo "<td>" . $row["username"] . "</td>";
								echo "<td>" . $row["email"] . "</td>";
								echo "<td>" . $row["phone"] . "</td>";
								echo "<td>"; 
								//find multiple roles for contact-record
								$contact_roles_query = "SELECT roles.name as roleName
								FROM contacts, contacts_roles, roles 
								WHERE contacts.id = {$row['contactID']}
								AND contacts.id = contacts_roles.contact_id AND contacts_roles.role_id = roles.id ";
								$role_records = $conn->query($contact_roles_query);
								echo "<ul>";
								foreach($role_records as $value){
									echo "<li>";
									echo $value['roleName']; 
									echo "</li>";
								}
								echo "</ul>";
								echo "</td>";
								echo "<td>" . $row["further_info"] . "</td>";
								echo "</tr>";
								
								//fputcsv($file, $row);
							}
							} else {
								echo "<tr><td>". "0 results" ."</td></tr>";
							}
							*/
					  ?>
					</table>
				</div>
			</div>
		</div>
	</section>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <!-- Latest compiled and minified JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
  </body>
</html>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <!-- <meta http-equiv="X-UA-Compatible" content="IE=edge">-->
	<!-- http://stackoverflow.com/questions/6771258/what-does-meta-http-equiv-x-ua-compatible-content-ie-edge-do --> 
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
  	// db connection
	include 'connect.php';
	
	//select from faculty
	$faculty_query = "SELECT * FROM faculties ORDER BY name";
	$faculty_names = $conn->query($faculty_query);
	
	//select from department
	//$department_query = "SELECT * FROM departments ORDER BY name";
	//$department_names = $conn->query($department_query);
	
	//select from role
	$role_query = "SELECT * FROM roles ORDER BY name";
	$role_names = $conn->query($role_query);
		
	// define variables and set to empty values
	//$nameErr = $facultyErr = $departmentErr = $usernameErr = $emailErr = "";
	$name = $faculty_id = $department_id = $username = $email = $phone = $further_info = "";
	$errors = array();
	$rolesArray = array();
	
	function test_input($data) {
		  $data = trim($data);
		  $data = stripslashes($data);
		  $data = htmlspecialchars($data);
		  return $data;
	}
	
	//Form values
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		
	  if (empty($_POST["name"])) {
		$errors[]= "Name is required.";
	  } else {
		$name = test_input($_POST["name"]);
	  }
	  
	  if (empty($_POST["faculty_id"])) {
		$errors[] = "Please enter your faculty.";
	  } else {
		$faculty_id = $_POST["faculty_id"];
	  }
	  
	   if (empty($_POST["department_id"])) {
		$errors[] = "Please enter your department.";
	  } else {
		$department_id = $_POST["department_id"];
	  }
		
	   if (empty($_POST["username"])) {
		$errors[] = "Username is required.";
	  } else {
		$username = test_input($_POST["username"]);
	  }
	  
	   if (empty($_POST["email"])) {
		$errors[] = "Email is required";
	  } else {
		$email = test_input($_POST["email"]);
		// check if e-mail address is well-formed
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		  $errors[] = "Invalid email format"; 
		}
	  }
	  
	  if (empty($_POST["roles"])){
		$errors[] = "Please choose a role.";
	  }else {
		$rolesArray = $_POST["roles"];
	  }
	  
	  if (empty($_POST["further_info"])) {
		$errors[] = "Further Information is required.";
	  } else {
		$further_info = test_input($_POST["further_info"]);
	  }
	  
	  $phone = test_input($_POST["phone"]);
   
	   
		//insert data into contact tbl
		if (count($errors)== 0){
			$conn->begin_transaction();
			$contact_sql = "INSERT INTO contacts (name, faculty_id, department_id, username, email, phone, further_info) 
									VALUES ('$name', '$faculty_id', '$department_id', '$username', '$email', '$phone', '$further_info')";
			$insert_contact = $conn->query($contact_sql);
			if ($insert_contact === TRUE){
					$last_id = $conn->insert_id;
					foreach($rolesArray as $value){
						$contact_role_sql = "INSERT INTO contacts_roles(contact_id, role_id)
											VALUES ('$last_id', '$value')";	
						$insert_contact_role = $conn->query($contact_role_sql);									
					}
			}		
		
			if($insert_contact && $insert_contact_role) {
				$conn->commit();
				$name = $faculty_id = $department_id = $username = $email = $phone = $further_info = "";
				$rolesArray = [];
				echo "Records added successfully." . "<br>";
			} else {
				$conn->rollback();
				echo "ERROR: Could not able to execute" .  $conn->error;
			}
		};
	};
  ?>

   <a href="display_contacts.php">Demo purpose: admin display records</a>
	
	<section id="role_form">
		<div class="container">
		<div class="row">
		  <div class="col-md-6 col-md-offset-3">
		  <h2>myTeam and e-Recruitment Role access requests</h2>
			<?php include 'my_team_form.php'; ?>
		  </div>
		</div>
	</section>
	


    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script   src="https://code.jquery.com/jquery-3.1.1.min.js" integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8="  crossorigin="anonymous"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <!-- Latest compiled and minified JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    
	<script type="text/javascript">
		$(document).ready(function(){
			$('#faculty_id').on('change',function(){
				var facultyID = $(this).val();
				if(facultyID){
					$.ajax({
						type:'POST',
						url:'facultyAjax.php',
						data:'faculty_id='+facultyID,
						success:function(html){
							$('#department_id').html(html);
						}
					}); 
				}else{
					$('#department_id').html('<option value="">Department selection:</option>');
				}
			});
		
		});
	</script>
  
  
  </body>
</html>



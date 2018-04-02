<?php
// db connection
include 'connect.php';

if(isset($_POST["faculty_id"]) && !empty($_POST["faculty_id"])){
    //Get all faculty 
    $departemnt_query = $conn->query("SELECT * FROM departments WHERE faculty_id = ".$_POST['faculty_id']." ORDER BY name");
    
    //Count total number of rows
    $rowCount = $departemnt_query ->num_rows;
    
    //Display list
    if($rowCount > 0){
        echo '<option value="">Department selection:</option>';
        while($row = $departemnt_query->fetch_assoc()){ 
            echo '<option value="'.$row['id'].'">'.$row['name'].'</option>';
        }
    }else{
        echo '<option value="">slecetion not available</option>';
    }
}

?>


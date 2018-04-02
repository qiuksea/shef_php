<?php
$servername = "localhost";
$username = "root";
$password = "f00tba11";
$dbname = "country";

if (isset($_GET['term'])){

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        #echo "Connected successfully";
        
        $return_arr = array();
        
        $query = "SELECT id, country FROM countries WHERE country LIKE '%" .$_GET['term']."%'" ;  

        $stmt = $conn->prepare($query);
        $stmt->execute();

        while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $return_arr[] = array( 
                 'id' => $row['id'], 
                 'label' => $row['id'] ."--" .$row['country'],
                 'value' => $row['country']
            );
        }    

        /* Toss back results as json encoded array. */
        echo json_encode($return_arr);
        }
    catch(PDOException $e)
        {
        echo "Connection failed: " . $e->getMessage();
        die();
        }
}
?>
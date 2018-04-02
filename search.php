<?php
$servername = "localhost";
$username = "root";
$password = "f00tba11";
$dbname = "country";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    #echo "Connected successfully"; 
    }
catch(PDOException $e)
    {
    echo "Connection failed: " . $e->getMessage();
    die();
    }

    if(isset($_POST["query"])){

        $sql = "SELECT COUNT(*) FROM countries WHERE country LIKE '%" .$_POST["query"]."%'";

        if ($res = $conn->query($sql)) {

            $output = '';      

            /* Check the number of rows that match the SELECT statement */
        if ($res->fetchColumn() > 0) {
                  
            $output .= "<ul class='list-group'>";

                /* Issue the real SELECT statement and work with the results */
                $query = "SELECT id, country FROM countries WHERE country LIKE '%" .$_POST["query"]."%'" ;

                $stmt = $conn->prepare($query);
                $stmt->execute();

                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
               
            foreach ($result as $row) {
                          
                   $output .= "<li class='list-group-item'>". $row['id'] . "-" . $row['country'] ."</li>";
                }
            }
            /* No rows matched -- do something else */
        else {

            $output .= "<li class='list-group-item'>No data found</li>";

            }
        };

         $output .="</ul>";
         echo $output;
    }
?>
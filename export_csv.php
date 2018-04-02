<?php 
header('Content-type: text/csv');
header('Content-Disposition: attachment; filename="record.csv"');

// create a file pointer connected to the output stream
$file = fopen('php://output', 'w');


?>
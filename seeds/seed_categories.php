<?php 
require("../connection/connection.php");


$query = "INSERT INTO categories (name) VALUES 
    ('Tech'), 
    ('Health'), 
    ('Sports')";

$execute = $mysqli->prepare($query);
$execute->execute();
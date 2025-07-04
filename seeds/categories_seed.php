<?php 

require_once("../connection/connection.php");

$categories = [
    ['name'=>'Health'],
    ['name'=> 'Technology'],
    ['name'=> 'Sports'],
    ['name'=>'Fashion'],
    ['name'=> 'News'],
];
$query = "INSERT INTO categories (name) VALUES (?)";
foreach($categories as $category){
   $stmt = $mysqli->prepare($query);
   $stmt->bind_param('s',$category['name']);
   $stmt->execute();
}
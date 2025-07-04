<?php
require("../connection/connection.php");

$query1 = "ALTER TABLE articles ADD COLUMN category_id INT";
$mysqli->prepare($query1)->execute();

$query2 = "ALTER TABLE articles ADD CONSTRAINT fk_category FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL";
$mysqli->prepare($query2)->execute();
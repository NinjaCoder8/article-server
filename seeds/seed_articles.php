<?php 
require("../connection/connection.php");


$query = "INSERT INTO articles (name, author, description ) VALUES 
('How to stay fit', 'Charbel', 'Here are some tips...', 2),
('Latest Tech Trends', 'Ali',  'AI is taking over...', 1),
('Football World Cup', 'Hussein', Let’s talk about the final...', 3),
('Healthy Eating on a Budget', 'Maya', 'Simple ways to eat clean without spending too much.', 2),
('Future of Smartphones', 'Ziad', 'Foldables and AI chips are redefining mobile tech.', 1)";

$execute = $mysqli->prepare($query);
$execute->execute();
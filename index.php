<?php 
require_once("./routes/api.php");
// This block is used to extract the route name from the URL
//----------------------------------------------------------

//Examples: 
//http://localhost/getArticles -------> $request = "getArticles"
//http://localhost/ -------> $request = "/" (why? because of the if)

// This block is used to extract the route name from the URL
//----------------------------------------------------------


//Routing starts here (Mapping between the request and the controller & method names)
//It's an key-value array where the value is an key-value array
//----------------------------------------------------------

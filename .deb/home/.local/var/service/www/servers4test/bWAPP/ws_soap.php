<?php

// SOAP function
function get_tickets_stock($title)
{

	include("connect.php");        
	$sql = "SELECT tickets_stock FROM movies WHERE title = '" . $title . "'";
	$recordset = mysql_query($sql, $link);
        $row = mysql_fetch_array($recordset);
        mysql_close($link);
	return $row["tickets_stock"];

}

// Includes the NuSOAP library
require("soap/nusoap.php");

// Creates an instance of the soap_server class
$server = new nusoap_server();

// Specifies the name of the server and the namespace
$server->configureWSDL("*** bWAPP Movie Service ***", "urn:movie_service");

// Registers the function we created with the SOAP server and passes several different parameters to the register method
// The first parameter is the name of the function
$server->register("get_tickets_stock",
// The second parameter specifies the input type
array("title" => "xsd:string"),
// The third parameter specifies the return type
array("tickets_stock" => "xsd:integer"),
// The next two parameters specify the namespace we are operating in, and the SOAP action
"urn:tickets_stock",
"urn:tickets_stock#get_tickets_stock");
// Checks if $HTTP_RAW_POST_DATA is initialized. If it is not, it initializes it with an empty string.
$HTTP_RAW_POST_DATA = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : "";
// Calls the service. The web request is passed to the service from the $HTTP_RAW_POST_DATA variable.
$server->service($HTTP_RAW_POST_DATA);

?>
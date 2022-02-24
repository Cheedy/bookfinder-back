<?php

$host = "localhost";
$dbname = "livres"; 
$user = "mycopro";
$pass = "mycopro";
$port = "3306";

try
{
	$db = new PDO("mysql:host=$host; dbname=$dbname;port=$port",$user,$pass);
}
catch(\Throwable $th)
{
	echo "Error: " .$th->getMessage();
}
?>
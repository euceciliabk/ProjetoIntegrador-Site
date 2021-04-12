<?php

//function getConexao( ){
    //$hostname = 'localhost';
	//$database = 'tripou';
	//$username = 'root';
	//$password = '';
	//$mysqlconnection = new mysqli($hostname, $username, 
    //$password, $database);
    //return $mysqlconnection;
//}

function isLocalhost($whitelist = ['127.0.0.1', '::1']) {
    return in_array($_SERVER['REMOTE_ADDR'], $whitelist);
}

function getLocalhostConexao() {
    $hostname = 'localhost';
    $database = 'tripou';
    $username = 'root';
    $password = '';
    $connstring = "host=$hostname dbname=$database user=$username password=$password";
    return pg_connect($connstring);
}

function getConexao() {
    
    return pg_connect(getenv("DATABASE_URL"));
}


?>
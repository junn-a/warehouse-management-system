<?php
	/** 
	//MYSQL
	$server = 'localhost';
	$name 	= 'root';
	$pass 	= '';
	@$db1	= 'db_1';
	@$db2	= 'db_2';
	@$db3 	= 'db_3';
	
	@$conn 	= mysqli_connect($server,$name,$pass,$db1);
	@$conn2 	= mysqli_connect($server,$name,$pass,$db2);
	@$conn3 	= mysqli_connect($server,$name,$pass,$db3);
	
	**/
	//POSTGREE
	$host 		= "localhost";
	$dbuser 	= "postgres";
	$dbpass		= "your_pass";
	$port 		= "5432";
	$dbname		= "db_1";
	
	$conn_string = "host=localhost port=5432 dbname=db_1 user=postgres password=your_pass";
	$conn = pg_connect($conn_string);
?>
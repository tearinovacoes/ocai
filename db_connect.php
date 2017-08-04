<?php
    require("vendor/autoload.php");

	  $dbopts = parse_url(getenv("DATABASE_URL"));

    $host = $dbopts["host"];
    $user = $dbopts["user"];
    $dbname = ltrim($dbopts["path"],'/');
    $pass = $dbopts["pass"];
    $port = $dbopts["port"];

    ORM::configure("pgsql:port=$port sslmode=prefer host=$host user=$user dbname=$dbname password=$pass");

		class Item extends Model {}
		class Subitem extends Model {}
		class Response extends Model {
			public static $_id_column = "response_id";
		}

?>

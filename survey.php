<?php
require("vendor/autoload.php");
ORM::configure("pgsql:dbname=ddojpsdo74cjbu host=ec2-50-19-95-47.compute-1.amazonaws.com port=5432 user=eywxrrahqgwtff password=91459b0e009d4bde6ead7a6b82ff40f5f99b2de9e385e332fad9c83eb6446ae1 sslmode=require");

class Item extends Model {}
class Subitem extends Model {}
class Response extends Model {
	public static $_id_column = "response_id";
}

if (isset($_POST["uid"]) && $_POST["uid"] != "") {
    $subitems = Model::factory('Subitem')
        ->find_many();
	$date_survey=date("Y-m-d H:i:s");
	foreach($subitems as $subitem){
		$r = Model::factory("Response")->create();
		$r->subitem_actual=$_POST["actual-".$subitem->subitem_id];
		$r->subitem_desirable=$_POST["desirable-".$subitem->subitem_id];
		$r->response_uid=$_POST["uid"];
		$r->subitem_id=$subitem->subitem_id;
		$r->survey_date=$date_survey;
		$r->save();
	}
}
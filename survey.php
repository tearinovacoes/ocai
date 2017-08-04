<?php
    require("db_connect.php");

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

?>

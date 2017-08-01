<?php require("survey.php"); ?>

<?php 
	
	$str="select count(item_id) as dimensoes from item;";
	$result = ORM::for_table('item')->raw_query($str)->find_one();
	$dimensoes = $result->dimensoes;
	
	$str=<<<EOT
		select 
			subitem.org_culture as org_culture,
			round(avg(response.subitem_actual),0) as average_actual,
			round(avg(response.subitem_desirable),0) as average_desirable
		from 
			response
		inner join
			subitem on response.subitem_id=subitem.subitem_id
		group by 
			subitem.org_culture
		order by org_culture asc;
EOT;
	
	$result = ORM::for_table('response')->raw_query($str)->find_many();
	
	$plot=array();
	$culture=array("C","A","M","H");
	$cont=0;
	
	foreach($result as $item){
		$plot[$culture[$cont]]=array("actual"=>$item->average_actual, "desirable"=>$item->average_desirable);
		$cont++;
	}
	
	//$result
	
/*  	echo "<pre>";
	var_dump ($plot);
	echo "</pre>";
	exit();  */
	
?>

<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html;charset=utf-8"/ >
		<title>PLOT OCAI</title>

		<!-- Google fonts -->
		<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300' rel='stylesheet' type='text/css'>
		<link href='https://fonts.googleapis.com/css?family=Raleway' rel='stylesheet' type='text/css'>

		<!-- D3.js -->
		<script src="https://cdnjs.cloudflare.com/ajax/libs/d3/3.5.6/d3.min.js" charset="utf-8"></script>
		
		<style>
			body {
				font-family: 'Open Sans', sans-serif;
				font-size: 11px;
				font-weight: 600;
				fill: #242424;
				text-align: center;
				text-shadow: 0 1px 0 #fff, 1px 0 0 #fff, -1px 0 0 #fff, 0 -1px 0 #fff;
				cursor: default;
			}
			
			.legend {
				font-family: 'Raleway', sans-serif;
				fill: #333333;
			}
			
			.tooltip {
				fill: #333333;
			}
		</style>
	
	</head>
	<body>
		<div>aqui</div>
		<div class="radarChart"></div>

		<script src="js/radarchart.js"></script>	
		<script>
      
      /* Radar chart design created by Nadieh Bremer - VisualCinnamon.com */
      
			////////////////////////////////////////////////////////////// 
			//////////////////////// Set-Up ////////////////////////////// 
			////////////////////////////////////////////////////////////// 

			var margin = {top: 100, right: 100, bottom: 100, left: 100},
				width = 200; //Math.min(700, window.innerWidth - 10) - margin.left - margin.right,
				height = 200; //Math.min(width, window.innerHeight - margin.top - margin.bottom - 20);
					
			////////////////////////////////////////////////////////////// 
			////////////////////////// Data ////////////////////////////// 
			////////////////////////////////////////////////////////////// 

			var data = [
					  [//actual
						<?php foreach($plot as $index=>$value): ?>
							{axis:"<?=$index;?>",value:<?=$value["actual"];?>},
						<?php endforeach; ?>
						//{axis:"A",value:0.70},
						//{axis:"B",value:0.28},
						//{axis:"C",value:0.7},
						//{axis:"D",value:0.17},		
					  ],[//desirable
					  	<?php foreach($plot as $index=>$value): ?>
							{axis:"<?=$index;?>",value:<?=$value["desirable"];?>},
						<?php endforeach; ?>
						//{axis:"A",value:0.27},
						//{axis:"B",value:0.16},
						//{axis:"C",value:0.35},
						//{axis:"D",value:0.8},
					  ]
					];
			////////////////////////////////////////////////////////////// 
			//////////////////// Draw the Chart ////////////////////////// 
			////////////////////////////////////////////////////////////// 

			var color = d3.scale.ordinal()
				.range(["#EDC951","#CC333F","#00A0B0","#00A000"]);
				
			var radarChartOptions = {
			  w: width,
			  h: height,
			  margin: margin,
			  maxValue: 100,
			  levels: 10,
			  roundStrokes: true,
			  color: color
			};
			//Call function to draw the Radar chart
			RadarChart(".radarChart", data, radarChartOptions);
		</script>
		<div>aqui</div>
	</body>
</html>
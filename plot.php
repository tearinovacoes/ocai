<?php
  require("db_connect.php");
	require("lib.php");


	$plot = getOcaiResults();
	// print_r($plot);die();
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

		<script src="js/radarchart.js"></script>
		<script src="js/plot.js"></script>

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
		<table  align='center' style='width: 800px;'>
			<tr>
				<td colspan="3"><h1 style='padding-top: 10px; height: 40px; background-color: #eee; text-align:center;'>RESULTADO</h1>
			</tr>
		</table>
		<div class="radarChart-all"></div>

		<script>
		  var margin = {top: 100, right: 100, bottom: 100, left: 100}
			width = Math.min(800, window.innerWidth - 10) - margin.left - margin.right,
			height = Math.min(width, window.innerHeight - margin.top - margin.bottom - 20);

			var data_all = [
						[//actual
							<?php foreach($plot["all"] as $index=>$value): ?>
									{axis:"<?= $value["org_culture"] ?>",value:<?=$value["average_actual"];?>},
							<?php endforeach; ?>
						],[//desirable
							<?php foreach($plot["all"] as $index=>$value): ?>
									{axis:"<?=$value["org_culture"] ?>",value:<?=$value["average_desirable"];?>},
							<?php endforeach; ?>
						]
					];

			plotRadarChart(".radarChart-all",data_all,width,height,margin);
		</script>

		<div align='center'>
			<p align='center' style='font-size: 12px;'>Legenda:</p><strong>Amarelo:</strong> Atual / <strong>Vermelho:</strong> Desejável</br></p>
		</div>

		</br>
		</br>

    <?php foreach($plot["dimensoes"] as $dimensao): ?>
				<div class="por_dimensao">
						<div><?= $dimensao["label"] ?></div>
						<div class="radarChart-all"></div>
						<div class='<?= "radarChart-".$dimensao["item_id"] ?>'></div>
							<script>
								var margin = {top: 20, right: 20, bottom: 20, left: 20}
								width = 400;
								height = 400;


								<?php
								    $plot_data = array();
								    foreach($plot["by_dimension"] as $item) {
											if($item["item_id"]==$dimensao["item_id"]) {
												$plot_data[$item["org_culture"]] = $item;
											}
										}
							  ?>

								var data = [
											[//actual
												<?php foreach($plot_data as $org_culture=>$value): ?>
														{axis:"<?=$org_culture ?>",value:<?=$value["average_actual"];?>},
												<?php endforeach; ?>
											],[//desirable
												<?php foreach($plot_data as $org_culture=>$value): ?>
														{axis:"<?=$org_culture ?>",value:<?=$value["average_desirable"];?>},
												<?php endforeach; ?>
											]
										];

								plotRadarChart('<?= ".radarChart-".$dimensao["item_id"] ?>',data,width,height,margin);
							</script>
						</div>
				</div>
		<?php endforeach; ?>

		<table  align='center' style='width: 800px;'>
			<tr>
				<td colspan="3"><h1 style='padding-top: 10px; height: 40px; background-color: #eee; text-align:center;'>DEFINIÇÕES DE CADA DIMENSÃO</h1>
			</tr>
			<tr>
				<td colspan="3">
					<h2 style='text-align:left;'>CLAN</h2>
					<p style='text-align:justify;'>
						A organização da escola é muito pessoal, como uma segunda família. As pessoas compartilham diversos aspectos de sua vida.
						A liderança da escola tem como funções orientar, facilitar e desenvolver os demais membros.
						O estilo de direção é caracterizado por trabalho em equipe, consenso e participação.
						O que mantém a escola unida é lealdade e confiança. O comprometimento entre seus membros é alto.
						A escola enfatiza o desenvolvimento humano. Confiança, abertura e participação persistem.
						A escola atua com base em desenvolvimento humano, trabalho em equipe e comprometimento.
					</p>
				</td>
			</tr>
			<tr>
				<td style='width: 25%;'>
					<h2 style='text-align:left;'>HIERARCHY</h2>
					<p style='text-align:justify;'>
						A escola atua com base em sua eficiência formal. Entregas e produção são importantes.
						O que mantém a escola unida são regras formais e políticas.
						A escola enfatiza permanência e estabilidade. Eficiência, controle e operações padronizadas são importantes.
						O estilo de direção é caracterizado por segurança, conformidade, previsibilidade e estabilidade nas relações da equipe.
						A escola é um lugar bem estruturado e formal. Procedimentos formais governam o modo das pessoas agirem.
						A liderança é voltada para coordenar, organizar e tornar a estrutura da escola mais eficiente.
					</p>
				</td>
				<td>
            <div class="radarChart-all3"></div>
            <script>
              var margin = {top: 20, right: 20, bottom: 20, left: 20}
              width = 300,
              height = 300;

              var data_all = [
                    [//actual
                      <?php foreach($plot["all"] as $index=>$value): ?>
                          {axis:"<?= $value["org_culture"] ?>",value:<?=$value["average_actual"];?>},
                      <?php endforeach; ?>
                    ],[//desirable
                      <?php foreach($plot["all"] as $index=>$value): ?>
                          {axis:"<?=$value["org_culture"] ?>",value:<?=$value["average_desirable"];?>},
                      <?php endforeach; ?>
                    ]
                  ];

              plotRadarChart(".radarChart-all3",data_all,width,height,margin);
            </script>
          </td>
        </td>
				<td style='width: 25%;'>
					<h2 style='text-align:left;'>ADHOCRACY</h2>
					<p style='text-align:justify;'>
						A escola atua com base em processos e resultados, que são diferenciados.
						O que mantém a escola unida é inovação e desenvolvimento. Há a motivação de estar em evidência.
						A liderança é voltada para o empreendedorismo e a inovação. Geralmente assume muitos riscos.
						A escola é dinâmica e empreendedora. As pessoas costumam estar dispostas a assumir riscos.
						O estilo de direção é caracterizado por assumir riscos e oferecer liberdade de criar.
						A escola enfatiza adquirir novos recursos e criar novos desafios, além de aproveitar novas oportunidades.
					</p>
				</td>
			</tr>
			<tr>
				<td colspan="3">
					<h2 style='text-align:left;'>MARKET</h2>
					<p style='text-align:justify;'>
						O estilo de direção é caracterizado por competitividade, alta demanda e cumprimento de metas.
						A escola enfatiza ações competitivas e conquistas individuais.
						A escola é voltada para resultados. A maior preocupação é resolver as tarefas. As pessoas são competitivas e orientadas ao desempenho.
						A escola atua com base em sua posição no sistema. Competitividade é a dimensão chave.
						O que mantém a escola unida é ênfase em resultados e alcance de metas.
						O principal foco da liderança da escola são os resultados.
					</p>
				</td>
			</tr>
		</table>

		</br>
		</br>




		<table  align='center' style='width: 800px;'>
			<tr>
				<td colspan="3"><h1 style='padding-top: 10px; height: 40px; background-color: #eee; text-align:center;'>QUADRO DE VALORES COMPETITIVOS</h1>
			</tr>
			<tr>
				<td>
					<h2 style='text-align:center;'>Flexibility and discretion</h2>
				</td>
				<td>
					<h2 style='background-color: #eee; text-align:center;'>COLABORATE</h2>
				</td>
				<td>
					<h2 style='text-align:center;'>External focus and differentiation</h2>
				</td>
			</tr>
			<tr>
				<td style='width: 25%;'>
					<h2 style='background-color: #eee; text-align:center;'>CONTROL</h2>
				</td>
				<td>
          <div class="radarChart-all2"></div>
          <script>
            var margin = {top: 20, right: 20, bottom: 20, left: 20}
            width = 300,
            height = 300;

            var data_all = [
                  [//actual
                    <?php foreach($plot["all"] as $index=>$value): ?>
                        {axis:"<?= $value["org_culture"] ?>",value:<?=$value["average_actual"];?>},
                    <?php endforeach; ?>
                  ],[//desirable
                    <?php foreach($plot["all"] as $index=>$value): ?>
                        {axis:"<?=$value["org_culture"] ?>",value:<?=$value["average_desirable"];?>},
                    <?php endforeach; ?>
                  ]
                ];

            plotRadarChart(".radarChart-all2",data_all,width,height,margin);
          </script>
        </td>
				<td style='width: 25%;'>
					<h2 style='background-color: #eee; text-align:center;'>CREATE</h2>
				</td>
			</tr>
			<tr>
				<td>
					<h2 style='text-align:center;'>Internal focus and integration</h2>
				</td>
				<td>
					<h2 style='background-color: #eee; text-align:center;'>COMPETE</h2>
				</td>
				<td>
					<h2 style='text-align:center;'>Stability and control</h2>
				</td>
			</tr>
		</table>
	</body>
</html>

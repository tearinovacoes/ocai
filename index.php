<?php require("survey.php"); ?>
<?php require("formr/class.formr.php"); ?>
<?php
    $f = new Formr('bootstrap');

    $dbopts = parse_url(getenv("DATABASE_URL"));

    $host = $dbopts["host"];
    $user = $dbopts["user"];
    $dbname = ltrim($dbopts["path"],'/');
    $pass = $dbopts["pass"];
    $port = $dbopts["port"];

    //ORM::configure('pgsql:port='.$port.' sslmode=require host='.$host.' user='.$user.' dbname='.$dbname.' password='.$pass);
    ORM::configure('pgsql:host=ec2-50-19-95-47.compute-1.amazonaws.com port=5432 user=xqfnneqhrsszvg dbname=ddojpsdo74cjbu password=e21a11fa837eab9adc6270c5037796956242527b4b27a911da7fc67fcdb8eaad');

    $items = Model::factory('Item')
        ->find_many();

    $uid = uniqid("survey_");
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Cultura Organizacional</title>

    <meta name="description" content="Instrumento de Avaliação da Cultura Organizacional">
    <meta name="author" content="Instituto Tear Inovações">

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/scripts.js"></script>

    <style type="text/css">
        .form-item {
            width:90%;
        }

        .form-actual {
            width:5%;
        }

        .form-desirable {
            width:5%;
        }

        .tr-cinza {
            background-color: #CCC;
        }

        .number-negative {
            color:red;
        }

		.number-zero {
            color:#32CD32;
        }

		p {
			text-align: justify;
		}
    </style>
  </head>
  <body>

    <div class="container" style="margin-top:2em;">
        <div class="row">
        	<div class="col-md-12">
        		<div class="jumbotron well" id="divStart">
        			<h2>
        				Instrumento de Percepção da Cultura Organizacional
        			</h2><br>
        			<p>
        				O objetivo deste formulário é colaborar para a criação de uma percepção compartilhada sobre como a escola está se organizando hoje. Por isso ele não é uma avaliação dos indivíduos, mas sim de como estamos vendo nosso trabalho como grupo. As diferentes visões que surgirem aqui vão ser apresentadas em forma de gráficos, ficando as respostas anônimas. Enxergar isso deve nos ajudar a decidir sobre os passos futuros no sentido de uma melhoria da escola como um todo. E portanto também das relações de cada um com o trabalho na escola.
        			</p>
        			<p>
        				<a class="btn btn-primary btn-large" id="btnPesquisa" href="#">Preencher formulário</a>
        			</p>
        		</div>
        	</div>
        </div>
        <div class="row">
            <div class="col-md-12" id="divPesquisa" style="display:none;">
                <?php echo $f->form_open(); ?>
                <table class="table">
        			<thead id="thead">
        				<tr>
        					<th class="form-item">
        						Item
        					</th>
        					<th class="form-actual">
        						Atualmente
        					</th>
        					<th class="form-desirable">
        						Desejável
        					</th>
        				</tr>
        			</thead>
        			<tbody>
                        <!-- items -->
                        <?php foreach($items as $item) { ?>
        				<tr class="tr-cinza tr-item" data-id="<?=$item->item_id;?>">
        					<td>
        						<strong><?=$item->label; ?></strong>
        					</td>
                            <td></td>
        					<td></td>
        				</tr>
                            <!-- subitems -->
                            <?php
                                $subitems = Model::factory("Subitem")
                                            ->where('item_id', $item->item_id)
                                            ->find_many();
                                foreach($subitems as $subitem) {
                            ?>
                            <tr data-id="<?=$item->item_id; ?>">
            					<td>
            						<?=$subitem->label; ?>
            					</td>
            					<td>
            						<?php echo $f->input_number("actual-".$subitem->subitem_id, NULL, "", "", 'value="0" min="0" max="100" class="input-actual"'); ?>
            					</td>
            					<td>
                                    <?php echo $f->input_number("desirable-".$subitem->subitem_id, NULL, "", "", 'value="0" min="0" max="100" class="input-desirable"'); ?>
            					</td>
            				</tr>
                            <?php } ?>

                            <tr>
                                <td><strong>Pontos restantes:</strong></td>
                                <td><h2 id="points_left_actual_<?=$item->item_id; ?>" class="points_left_actual">100</h2></td>
                                <td><h2 id="points_left_desirable_<?=$item->item_id; ?>" class="points_left_desirable">100</h2></td>
                            </tr>
                        <?php } ?>
        			</tbody>
        		</table>
                <input type="hidden" name="uid" id="uid" value="<?=$uid; ?>">
        		<button type="button" id="btnEnviar" class="btn btn-default pull-right">
        			Enviar
        		</button>
                <?php echo $f->form_close(); ?>
            </div>
        </div>
    </div>
    <br>
    <br>
    <br>
    <br>
    <br>
  </body>
</html>

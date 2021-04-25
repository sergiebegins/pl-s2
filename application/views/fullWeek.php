<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Champions League</title>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous"></script>
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.24/datatables.min.css"/>
	<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.24/datatables.min.js"></script>

	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
	<style type="text/css">

		::selection { background-color: #E13300; color: white; }
		::-moz-selection { background-color: #E13300; color: white; }

		body {
			background-color: #fff;
			margin: 40px;
			font: 13px/20px normal Helvetica, Arial, sans-serif;
			color: #4F5155;
		}

		a {
			color: #003399;
			background-color: transparent;
			font-weight: normal;
		}

		h1 {
			color: #444;
			background-color: transparent;
			border-bottom: 1px solid #D0D0D0;
			font-size: 19px;
			font-weight: normal;
			margin: 0 0 14px 0;
			padding: 14px 15px 10px 15px;
		}

		code {
			font-family: Consolas, Monaco, Courier New, Courier, monospace;
			font-size: 12px;
			background-color: #f9f9f9;
			border: 1px solid #D0D0D0;
			color: #002166;
			display: block;
			margin: 14px 0 14px 0;
			padding: 12px 10px 12px 10px;
		}

		#body {
			margin: 0 15px 0 15px;
		}

		p.footer {
			text-align: right;
			font-size: 11px;
			border-top: 1px solid #D0D0D0;
			line-height: 32px;
			padding: 0 10px 0 10px;
			margin: 20px 0 0 0;
		}

		#container {
			margin: 10px;
			border: 1px solid #D0D0D0;
			box-shadow: 0 0 8px #D0D0D0;
		}
	</style>
	<script>
        $(document).ready(function() {
            $('#example').DataTable({
                "order": [[ 1, "desc" ]]
            } );
        } );



	</script>
</head>
<body>

<div id="container">
	<h1>Welcome to Insider (Formerly SOCIAPlus) Champions League</h1>

	<div id="body">
		<div class="container">
			<div class="row">
				<div class="col-md-6">
					<div class="card" >
						<div class="card-body">
							<h5 class="card-title">League Table</h5>
							<table id="example" class="display" cellspacing="0" width="100%">
								<thead>
								<tr>
									<th>Teams</th>
									<th>PTS</th>
									<th>P</th>
									<th>W</th>
									<th>D</th>
									<th>L</th>
									<th>GL</th>
								</tr>
								</thead>
								<tbody>
								<?php foreach ($list as $k=>$v){ ?>
									<tr>
										<td><?=$v?></td>
										<td><?php $puan[$k] = ($score[count($score)]['result']['week'][0][$k]*3)+($score[count($score)]['result']['week'][2][$k]);echo $puan[$k];?></td>
										<td><?=count($score)?></td>
										<td><?=$score[count($score)]['result']['week'][0][$k]?></td>
										<td><?=$score[count($score)]['result']['week'][2][$k]?></td>
										<td><?=$score[count($score)]['result']['week'][1][$k]?></td>
										<td><?=$score[count($score)]['result']['avg'][$k]?></td>

									</tr>
								<?php } ?>

								</tbody>
							</table>
							<a href="http://localhost/pl-simulator/index.php/PL/delete/"  class="btn btn-primary mt-2">Delete All</a>

						</div>
					</div>
				</div>
				<div class="col-md-3">
					<?php  foreach ($fixture as  $k=>$v){ ?>
						<div class="card" >
							<div class="card-body">
								<h5 class="card-title">Match Week <?=$k?></h5>
								<table  class="display" cellspacing="0" width="100%">
									<tbody>
									<?php
									$c=0;
									foreach ($v as $k2=>$v2){
										?>
										<tr>
											<td><?=$list[$k2]?></td>
											<td><?=$score[$k]['result']['score'][$c][0]?> - <?=$score[$k]['result']['score'][$c][1]?> </td>
											<td><?=$list[$v2]?></td>
										</tr>
									<?php $c++; }  ?>
									</tbody>
								</table>
							</div>
						</div>
					<?php }  ?>
				</div>
				<div class="col-md-3">
					<div class="card" >
						<div class="card-body">
							<h5 class="card-title">4 Week Predictions of Championship</h5>
							<table  class="display" cellspacing="0" width="100%">
								<tbody>
								<?php

								$sumTotal =array_sum($puan);
								foreach ($force as $k=>$v){
									$yuzde[$k] = round(((($v+$puan[$k])*100)/($sum+$sumTotal)),1) ;
								}

								foreach ($yuzde as $k=>$v){ ?>
									<tr>
										<td><?=$list[$k]?></td>
										<td>%<?=$v?></td>
									</tr>
								<?php } ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds. <?php echo  (ENVIRONMENT === 'development') ?  'CodeIgniter Version <strong>' . CI_VERSION . '</strong>' : '' ?></p>
</div>

</body>
</html>

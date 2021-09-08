<!DOCTYPE html>
<?php
	$title = "Pie Chart";
	$type = '';
	$amounts = '';
	$values = array();
	try {
		$str = $_GET['v'];
		$list = explode(';',base64_decode($str));
		try {
			foreach ($list as $item) {
				try {
					$value = explode('=',$item);
					if (strcasecmp("title",$value[0]) == 0) {
						$title = $value[1];
					} elseif (strcasecmp("type",$value[0]) == 0) {
						$type = $value[1];
					} elseif (strcasecmp("amounts",$value[0]) == 0) {
						$amounts = $value[1];
					} elseif (is_numeric($value[1]) && !($value[1] < 0)) {
						$values[] = array($value[0],$value[1]);
					}
				} catch (Exception $e1) {echo $e1} 
			}
		} catch (Exception $e2) {}
	} catch (Exception $e3) {}
?>
<html>
	<head>
		<meta charset="utf-8">
		<title><?php echo $title; ?></title>
		<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
		<script type="text/javascript">
			google.charts.load("current", {packages:["corechart"]});
			google.charts.setOnLoadCallback(drawChart);
			function drawChart() {
				var data = new google.visualization.DataTable();
				data.addColumn('string',<?php echo "'" . $type . "'"; ?>);
				data.addColumn('number',<?php echo "'" . $amounts . "'"; ?>);
				<?php
					foreach ($values as $val) {
						echo "data.addRow(['" . $val[0] . "'," . $val[1] . "]);";
					}
				?>
				var options = {
					title: <?php echo "'" . $title . "'"; ?>,
					'width':10000,
					'height':10000,
					is3D: true,
				};

				var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
				chart.draw(data,options);
			}
		</script>
		<style>
		#chart_wrap {
			position: relative;
			padding-bottom: 100%;
			height: 0;
			overflow:hidden;
		}

		#chart_div {
			position: absolute;
			top: 0;
			left: 0;
			max-width:100%;
			max-height:100%;
		}
		</style>
	</head>
	<body id="body">
		<div id="chart_wrap"><div id="chart_div"></div></div>
	</body>
</html>
<?php $this->Html->script('pages/covid/global_dashboard.js', ['block' => 'script']); ?>
<?php $this->Html->script('maps/jquery-jvectormap-world-mill.js', ['block' => 'script']); ?>

<script>
var _global_infected = [<?php foreach($global_by_date as $row) echo $row->infected.','; ?>];
var _global_dead = [<?php foreach($global_by_date as $row) echo $row->dead.','; ?>];
var _global_label = [<?php foreach($global_by_date as $row) echo '"'.$row->date.'",'; ?>];

var _global_byregions = [<?php foreach($global_by_region as $row) echo $row->_infected . ","; ?>];
var _global_regions = [<?php foreach($global_by_region as $row) echo '"'.$row->_name . '",'; ?>];

var _global_map_data = { <?php foreach($global_map as $row) echo '"' . strtoupper($row->nation_code) . '":' . $row->infected . ', '; ?> };
</script>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
	<h1 class="h2">COVID-19: Global dashboard</h1>
</div>

<?= $this->cell('Covidmenu::global') ?>

<div class="row">
    <div class="col-12 col-xl-6 mb-4">
		<canvas id="covid-chart1"></canvas>
	</div>

	<div class="col-12 col-xl-6 mb-4">
		<canvas id="covid-chart2"></canvas>
	</div>

	<div class="col-12 col-xl-6 mb-4">
		<canvas id="covid-chart3"></canvas>
	</div>

	<div class="col-12 col-xl-6 mb-4">
		<div class="jvectormap" id="globalMap" style="width: 100%; height: 50vh;"></div>
	</div>

</div>
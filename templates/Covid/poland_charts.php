<?php $this->Html->script('pages/covid/poland_charts.js', ['block' => 'script']); ?>

<script>
var _infected = [<?php foreach($covid as $row) echo $row->infected . ","; ?>];
var _infected_increase = [<?php for($i=0; $i<count($covid); $i++) echo $i>0 ? ($covid[$i]->infected - $covid[$i-1]->infected)."," : "0,"; ?>];

var _dead = [<?php foreach($covid as $row) echo $row->dead . ","; ?>];
var _dead_increase = [<?php for($i=0; $i<count($covid); $i++) echo $i>0 ? ($covid[$i]->dead - $covid[$i-1]->dead)."," : "0,"; ?>];

var _hospitalized = [<?php foreach($covid as $row) echo $row->hospitalized . ","; ?>];

var _quarantined = [<?php foreach($covid as $row) echo $row->quarantined . ","; ?>];

var _surveillance = [<?php foreach($covid as $row) echo $row->surveillance . ","; ?>];

var _labels = [<?php foreach($covid as $row) echo '"' . date('F d', strtotime($row->date)) . '",'; ?>];

var _current1_data = [<?= $current->infected ?>, <?= $current->dead ?>, <?= $current->recover ?>];
var _current1_labels = ["infected", "dead", "recover"];

var _current2_data = [<?= $current->hospitalized ?>, <?= $current->quarantined ?>, <?= $current->quarantined2 ?>, <?= $current->surveillance ?>];
var _current2_labels = ["hospitalized", "quarantined", "quarantined from outside", "surveillance"];

var _tests = [<?php foreach($covid as $row) echo $row->tests . ","; ?>];
</script>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
	<h1 class="h2">Charts with data COVID-19 in World</h1>
</div>

<?= $this->cell('Covidmenu::poland') ?>

<div class="row">
    <div class="col-12 col-lg-6 col-xl-6 col-fhd-4 mb-4">
		<canvas id="covid-chart1"></canvas>
	</div>
	<div class="col-12 col-lg-6 col-xl-6 col-fhd-4 mb-4">
		<canvas id="covid-chart2"></canvas>
	</div>
	<div class="col-12 col-lg-6 col-xl-6 col-fhd-4 mb-4">
		<canvas id="covid-chart3"></canvas>
	</div>
	<div class="col-12 col-lg-6 col-xl-6 col-fhd-4 mb-4">
		<canvas id="covid-chart4"></canvas>
	</div>
	<div class="col-12 col-lg-6 col-xl-6 col-fhd-4 mb-4">
		<canvas id="covid-chart5"></canvas>
	</div>
	<div class="col-12 col-lg-6 col-xl-6 col-fhd-4 mb-4">
		<canvas id="covid-chart6"></canvas>
	</div>
    <div class="col-12 col-lg-6 col-xl-6 col-fhd-4 mb-4">
		<canvas id="covid-chart7"></canvas>
	</div>
    <div class="col-12 col-lg-6 col-xl-6 col-fhd-4 mb-4">
		<canvas id="covid-chart8"></canvas>
	</div>
    <div class="col-12 col-lg-6 col-xl-6 col-fhd-4 mb-4">
		<canvas id="covid-chart9"></canvas>
	</div>
	<div class="col-12 col-lg-6 col-xl-6 col-fhd-4 mb-4">
		<canvas id="covid-chart10"></canvas>
	</div>
</div>
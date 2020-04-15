<?php $this->Html->script('pages/covid/global_charts.js', ['block' => 'script']); ?>

<script>
var _infected_all = <?php $infected=0; foreach($global_by_region as $row) $infected += $row->_infected; echo $infected; ?>;
var _dead_all = <?php $dead=0; foreach($global_by_region as $row) $dead += $row->_dead; echo $dead; ?>;
var _recover_all = <?php $recover=0; foreach($global_by_region as $row) $recover += $row->_recover; echo $recover; ?>;

var _global_byregion = [
	[<?= $global_by_region[0]->_infected ?>, <?= $global_by_region[0]->_dead ?>, <?= $global_by_region[0]->_recover ?>],
	[<?= $global_by_region[1]->_infected ?>, <?= $global_by_region[1]->_dead ?>, <?= $global_by_region[1]->_recover ?>],
	[<?= $global_by_region[2]->_infected ?>, <?= $global_by_region[2]->_dead ?>, <?= $global_by_region[2]->_recover ?>],
	[<?= $global_by_region[3]->_infected ?>, <?= $global_by_region[3]->_dead ?>, <?= $global_by_region[3]->_recover ?>]
];

var _labels_byregion = ["<?= $global_by_region[0]->_name ?>", "<?= $global_by_region[1]->_name ?>", "<?= $global_by_region[2]->_name ?>", "<?= $global_by_region[3]->_name ?>"];

var _global = [_infected_all, _dead_all, _recover_all];
var _labels = ["Infected", "Death", "Recover"];

var _infected = [<?php foreach($global_by_region as $row) echo $row->_infected . ","; ?>];
var _regions = [<?php foreach($global_by_region as $row) echo '"'.$row->_name . '",'; ?>];
</script>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
	<h1 class="h2">Charts with data COVID-19 in Poland</h1>
</div>

<?= $this->cell('Covidmenu::global') ?>

<div class="row">
    <div class="col-12 col-xl-6 mb-4">
		<canvas id="covid-chart1"></canvas>
	</div>

	<div class="col-12 col-xl-6 mb-4">
		
		<table class="table table-striped table-sm ">
			<thead class="thead-dark">
				<tr>
					<th class="text-left">Region</th>
					<th class="text-right">Infected</th>
					<th class="text-right">Dead</th>
					<th class="text-right">Recover</th>
				</tr>
			</thead>
			<tbody>
			<?php for($i=0; $i<count($global_by_region); $i++) { ?>
				<?php $row = $global_by_region[$i]; ?>
				<tr>
					<td class="text-left"><?= $row->_name ?></td>
					<td class="text-right col-infected"><?= number_format($row->_infected,0,',',' ') ?></td>
					<td class="text-right col-dead"><?= number_format($row->_dead,0,',',' ') ?></td>
					<td class="text-right col-recovered"><?= number_format($row->_recover,0,',',' ') ?></td>
				</tr>
			<?php } ?>
			</tbody>
		</table>
	
	</div>

	<div class="col-12 col-xl-5 mb-4">
		<canvas id="covid-chart2"></canvas>
	</div>

	<div class="col-12 col-xl-7 mb-4">
		<div class="row">
			<div class="col-6">
				<canvas id="covid-chart3"></canvas>
			</div>
			<div class="col-6">
				<canvas id="covid-chart4"></canvas>
			</div>
			<div class="col-6">
				<canvas id="covid-chart5"></canvas>
			</div>
			<div class="col-6">
				<canvas id="covid-chart6"></canvas>
			</div>
		</div>
	</div>

</div>

<div class="row">
	<div class="col-12">
		<!-- <pre><?= print_r($global_by_region, true) ?></pre> -->
	</div>
</div>
<?php $this->Html->script('pages/covid/poland.js', ['block' => 'script']); ?>

<script>
var _infected = [<?php foreach($covid as $row) echo $row->infected - $row->dead - $row->recover . ","; ?>];
var _dead = [<?php foreach($covid as $row) echo $row->dead . ","; ?>];

var _labels = [<?php foreach($covid as $row) echo '"' . date('F d', strtotime($row->date)) . '",'; ?>];

var _current1_data = [<?= $current->infected - $current->dead - $current->recover ?>, <?= $current->dead ?>, <?= $current->recover ?>];
var _current1_labels = ["infected", "dead", "recover"];
</script>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
	<h1 class="h2"><?= __("COVID-19: Statistics in Poland") ?></h1>
</div>

<?= $this->cell('Covidmenu::poland') ?>

<div class="row main-indicator">
	<div class="col-12 col-lg-6 col-xl-4 mb-4">
		<div class="main-value">
			<span class="color-infected"><?= number_format($current->infected,0,',',' ') ?></span>
			<span class="value-small">+<?= $current->infected - $covid[count($covid)-2]->infected ?></span>
		</div>
		<div class="main-name"><?= __("Total cases") ?></div>
	</div>
	<div class="col-12 col-lg-6 col-xl-4 mb-4">
		<div class="main-value">
			<span class="color-dead"><?= number_format($current->dead,0,',',' ') ?></span>
			<span class="value-small">+<?= $current->dead - $covid[count($covid)-2]->dead ?></span>
		</div>
		<div class="main-name"><?= __("Total deaths") ?></div>
	</div>
	<div class="col-12 col-lg-6 col-xl-4 mb-4">
		<div class="main-value">
			<span class="color-recovered"><?= number_format($current->recover,0,',',' ') ?></span>
			<span class="value-small">+<?= $current->recover - $covid[count($covid)-2]->recover ?></span>
		</div>
		<div class="main-name"><?= __("Total recover") ?></div>
	</div>
</div>

<div class="row">
	<div class="col-12 col-lg-6 col-xl-4 mb-4">
		<canvas id="covid-chart1"></canvas>
	</div>
	<div class="col-12 col-lg-6 col-xl-4 mb-4">
		<canvas id="covid-chart2"></canvas>
	</div>
	<div class="col-12 col-lg-6 col-xl-4 mb-4">
		<canvas id="covid-chart3"></canvas>
	</div>
</div>

<div class="row">
	<div class="col-12">

		<table class="table table-striped table-sm ">
			<thead class="thead-dark">
				<tr>
					<th><?= __("No.") ?></th>
					<th><?= __("Date") ?></th>
					<th colspan="2" class="text-center"><?= __("Hospitalized") ?></th>
					<th colspan="2" class="text-center"><?= __("Quarantined") ?></th>
					<!-- <th colspan="2" class="text-center">Quarantined2</th> -->
					<th colspan="2" class="text-center"><?= __("Surveillance") ?></th>
					<th colspan="2" class="text-center"><?= __("Tested") ?></th>
					<th colspan="2" class="text-center"><?= __("Infected") ?></th>
					<th colspan="2" class="text-center"><?= __("Dead") ?></th>
					<th colspan="2" class="text-center"><?= __("Recover") ?></th>
				</tr>
			</thead>
			<tbody>
			<?php for($i=count($covid)-15; $i<count($covid); $i++) { ?>
				<?php $row = $covid[$i]; ?>
				<tr>
					<td><?= $row->id ?></td>
					<td><?= date('Y-m-d', strtotime($row->date)) . " " . __(date('D', strtotime($row->date))) ?></td>

					<td class="text-right col-hospitalized"><?= number_format($row->hospitalized,0,',',' ') ?></td>
					<td class="text-left col-hospitalized"><?= $i>0 ? $this->Format->increase($row->hospitalized - $covid[$i-1]->hospitalized) : "(0)" ?></td>

					<td class="text-right col-quarantined"><?= number_format($row->quarantined,0,',',' ') ?></td>
					<td class="text-left col-quarantined"><?= $i>0 ? $this->Format->increase($row->quarantined - $covid[$i-1]->quarantined) : "(0)" ?></td>

					<!-- <td class="text-right col-quarantined2"><?= number_format($row->quarantined2,0,',',' ') ?></td>
					<td class="text-left col-quarantined2"><?= $i>0 ? $this->Format->increase($row->quarantined2 - $covid[$i-1]->quarantined2) : "(0)" ?></td> -->

					<td class="text-right col-surveillance"><?= number_format($row->surveillance,0,',',' ') ?></td>
					<td class="text-left col-surveillance"><?= $i>0 ? $this->Format->increase($row->surveillance - $covid[$i-1]->surveillance) : "(0)" ?></td>

					<td class="text-right col-tests"><?= number_format($row->tests,0,',',' ') ?></td>
					<td class="text-left col-tests"><?= $i>0 ? $this->Format->increase($row->tests - $covid[$i-1]->tests) : "(0)" ?></td>

					<td class="text-right col-infected"><?= number_format($row->infected,0,',',' ') ?></td>
					<td class="text-left col-infected"><?= $i>0 ? $this->Format->increase($row->infected - $covid[$i-1]->infected) : "(0)" ?></td>

					<td class="text-right col-dead"><?= number_format($row->dead,0,',',' ') ?></td>
					<td class="text-left col-dead"><?= $i>0 ? $this->Format->increase($row->dead - $covid[$i-1]->dead) : "(0)" ?></td>

					<td class="text-right col-recovered"><?= number_format($row->recover,0,',',' ') ?></td>
					<td class="text-left col-recovered"><?= $i>0 ? $this->Format->increase($row->recover - $covid[$i-1]->recover) : "(0)" ?></td>
				</tr>
			<?php } ?>
			</tbody>
		</table>

	</div>
</div>
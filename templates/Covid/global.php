<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
	<h1 class="h2">World statistics of COVID-19</h1>
</div>

<?= $this->cell('Covidmenu::global') ?>

<!-- <pre><?= print_r($summary_today,true) ?></pre> -->

<div class="row main-indicator">
	<div class="col-12 col-lg-6 col-xl-4 mb-4">
		<div class="main-value">
			<span class="color-infected"><?= number_format($summary_today->infected,0,',',' ') ?></span>
			<span class="value-small">+<?= $summary_today->infected - $summary_yesterday->infected ?></span>
		</div>
		<div class="main-name"><?= __("Total cases") ?></div>
	</div>
	<div class="col-12 col-lg-6 col-xl-4 mb-4">
		<div class="main-value">
			<span class="color-dead"><?= number_format($summary_today->dead,0,',',' ') ?></span>
			<span class="value-small">+<?= $summary_today->dead - $summary_yesterday->dead ?></span>
		</div>
		<div class="main-name"><?= __("Total deaths") ?></div>
	</div>
	<div class="col-12 col-lg-6 col-xl-4 mb-4">
		<div class="main-value">
			<span class="color-recovered"><?= number_format($summary_today->recover,0,',',' ') ?></span>
			<span class="value-small">+<?= $summary_today->recover - $summary_yesterday->recover ?></span>
		</div>
		<div class="main-name"><?= __("Total recover") ?></div>
	</div>
</div>

<div class="row">
	<div class="col-6">

		<table class="table table-borderless table-sm world-nation-top">
			<thead>
				<tr>
					<th class="text-left" colspan="2">Country</th>
					<th class="text-right">Infected</th>
					<th class="text-right">Dead</th>
					<th class="text-right">Recover</th>
				</tr>
			</thead>
			<tbody>
			<?php for($i=0; $i<=16; $i++){ ?>

				<tr>
					<td class="text-center"><img src="https://www.countryflags.io/<?= $covid[$i]->nation_code ?>/flat/48.png" class="float-left"></td>
					<td class="text-left"><span class="nation-title" title="<?= ucwords($covid[$i]->nation_name) ?>"><?= empty($covid[$i]->nation_short) ? $covid[$i]->nation_name : $covid[$i]->nation_short ?></span></td>
					<td class="text-right"><span class="world-nation-value nation-infected"><?= number_format($covid[$i]->infected,0,',','&nbsp;') ?></span></td>
					<td class="text-right"><span class="world-nation-value nation-death"><?= number_format($covid[$i]->dead,0,',','&nbsp;') ?></span></td>
					<td class="text-right"><span class="world-nation-value nation-recover"><?= number_format($covid[$i]->recover,0,',','&nbsp;') ?></span></td>
				</tr>

			<?php } ?>
			</tbody>
		</table>

	</div>

	<div class="col-6">

		<table class="table table-borderless table-sm world-nation-middle">
			<thead>
				<tr>
					<th class="text-left" colspan="2">Country</th>
					<th class="text-right">Infe.</th>
					<th class="text-right">Dead</th>
					<th class="text-right">Reco.</th>
				</tr>
			</thead>
			<tbody>
			<?php for($i=17; $i<=34; $i++){ ?>

				<tr>
					<td class="text-center"><img src="https://www.countryflags.io/<?= $covid[$i]->nation_code ?>/flat/48.png" class="float-left"></td>
					<td class="text-left"><span class="nation-title" title="<?= ucwords($covid[$i]->nation_name) ?>"><?= empty($covid[$i]->nation_short) ? $covid[$i]->nation_name : $covid[$i]->nation_short ?></span></td>
					<td class="text-right"><span class="world-nation-value nation-infected"><?= number_format($covid[$i]->infected,0,',','&nbsp;') ?></span></td>
					<td class="text-right"><span class="world-nation-value nation-death"><?= $covid[$i]->dead ?></span></td>
					<td class="text-right"><span class="world-nation-value nation-recover"><?= $covid[$i]->recover ?></span></td>
				</tr>

			<?php } ?>
			</tbody>
		</table>

	</div>

	<div class="col-4">

		<table class="table table-borderless table-sm world-nation-small">
			<thead>
				<tr>
					<th class="text-left" colspan="2">Country</th>
					<th class="text-right">I</th>
					<th class="text-right">D</th>
					<th class="text-right">R</th>
				</tr>
			</thead>
			<tbody>
			<?php for($i=35; $i<60; $i++){ ?> <!-- for($i=42; $i<floor((count($covid)-42)/2)+42; $i++) -->

				<tr>
					<td class="text-center"><img src="https://www.countryflags.io/<?= $covid[$i]->nation_code ?>/flat/32.png" class="float-left"></td>
					<td class="text-left"><span class="nation-title" title="<?= ucwords($covid[$i]->nation_name) ?>"><?= empty($covid[$i]->nation_short) ? $covid[$i]->nation_name : $covid[$i]->nation_short ?></span></td>
					<td class="text-right"><span class="world-nation-value nation-infected"><?= number_format($covid[$i]->infected,0,',','&nbsp;') ?></span></td>
					<td class="text-right"><span class="world-nation-value nation-death"><?= $covid[$i]->dead ?></span></td>
					<td class="text-right"><span class="world-nation-value nation-recover"><?= $covid[$i]->recover ?></span></td>
				</tr>

			<?php } ?>
			</tbody>
		</table>

	</div>

	<div class="col-4">

		<table class="table table-borderless table-sm world-nation-small">
			<thead>
				<tr>
					<th class="text-left" colspan="2">Country</th>
					<th class="text-right">I</th>
					<th class="text-right">D</th>
					<th class="text-right">R</th>
				</tr>
			</thead>
			<tbody style="overflow-y:scrool;hight:500px;">
			<?php for($i=61; $i<count($covid); $i++){ ?> <!-- for($i=floor((count($covid)-42)/2)+42+1; $i<count($covid); $i++) -->

				<tr>
					<td class="text-center"><img src="https://www.countryflags.io/<?= $covid[$i]->nation_code ?>/flat/32.png" class="float-left"></td>
					<td class="text-left"><span class="nation-title" title="<?= ucwords($covid[$i]->nation_name) ?>"><?= empty($covid[$i]->nation_short) ? $covid[$i]->nation_name : $covid[$i]->nation_short ?></span></td>
					<td class="text-right"><span class="world-nation-value nation-infected"><?= number_format($covid[$i]->infected,0,',','&nbsp;') ?></span></td>
					<td class="text-right"><span class="world-nation-value nation-death"><?= $covid[$i]->dead ?></span></td>
					<td class="text-right"><span class="world-nation-value nation-recover"><?= $covid[$i]->recover ?></span></td>
				</tr>

			<?php } ?>
			</tbody>
		</table>

	</div>
</div>
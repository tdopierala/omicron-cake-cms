<?php $this->Html->script('pages/covid/poland.js', ['block' => 'script']); ?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
	<h1 class="h2">Data table of COVID-19 in Poland</h1>
</div>

<?= $this->cell('Covidmenu::poland') ?>

<div class="row">
	<div class="col-12">

		<table class="table table-striped table-sm ">
			<thead class="thead-dark">
				<tr>
					<th>Id</th>
					<th>Date</th>
					<th colspan="2" class="text-center">Hospitalized</th>
					<th colspan="2" class="text-center">Quarantined</th>
					<!-- <th colspan="2" class="text-center">Quarantined2</th> -->
					<th colspan="2" class="text-center">Surveillance</th>
					<th colspan="2" class="text-center">Tests</th>
					<th colspan="2" class="text-center">Infected</th>
					<th colspan="2" class="text-center">Deaths</th>
					<th colspan="2" class="text-center">Recover</th>
				</tr>
			</thead>
			<tbody>
			<?php for($i=0; $i<count($covid); $i++) { ?>
				<?php $row = $covid[$i]; ?>
				<tr>
					<td><?= $row->id ?></td>
					<td><?= date('Y-m-d D', strtotime($row->date)) ?></td>

					<td class="text-right col-hospitalized"><?= number_format($row->hospitalized,0,',',' ') ?></td>
					<td class="text-left col-hospitalized"><?= $i>0 ? $this->Format->increase($row->hospitalized - $covid[$i-1]->hospitalized) : "(0)" ?></td>

					<td class="text-right col-quarantined"><?= number_format($row->quarantined,0,',',' ') ?></td>
					<td class="text-left col-quarantined"><?= $i>0 ? $this->Format->increase($row->quarantined - $covid[$i-1]->quarantined) : "(0)" ?></td>

					<!-- <td class="text-right col-quarantined2"><?= number_format($row->quarantined2,0,',',' ') ?></td>
					<td class="text-left col-quarantined2"><?= $i>0 ? $this->Format->increase($row->quarantined2 - $covid[$i-1]->quarantined2) : "(0)" ?></td> -->

					<td class="text-right col-surveillance"><?= number_format($row->surveillance,0,',',' ') ?></td>
					<td class="text-left col-surveillance"><?= $i>0 ? $this->Format->increase($row->surveillance - $covid[$i-1]->surveillance) : "(0)" ?></td>

					<td class="text-right col-quarantined2"><?= number_format($row->tests,0,',',' ') ?></td>
					<td class="text-left col-quarantined2"><?= $i>0 ? $this->Format->increase($row->tests - $covid[$i-1]->tests) : "(0)" ?></td>

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
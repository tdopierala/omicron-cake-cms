<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
	<h1 class="h2">Home settlement</h1>
</div>

<div class="row">
	<div class="col-12">

		<div class="row">
			<div class="col-6">
				<h3>Date: <?= $settlement->date->i18nFormat('yyyy-MM-dd') ?></h3>
			</div>
		</div>

		<div class="row">
			<div class="col-12">
				<table class="table table-bordered table-striped table-hover table-sm">
					<thead class="thead-dark">
						<tr>
							<th>No.</th>
							<th>Component</th>
							<th>Description</th>
							<th>Unit</th>
							<th>State</th>
							<th>Price</th>
							<th>Amount</th>
							<th>Summary</th>
						</tr>
					</thead>
					<tbody>
						<?php $i=0; $sum=0; setlocale(LC_MONETARY, 'pl_PL'); ?>
						<?php foreach($settlementValue as $value) { ?>
							<?php $i++; ?>
							<tr>
								<td class="text-center"><?= $i ?></td>
								<td><?= $value->name ?></td>
								<td><?= $value->description ?></td>
								<td><?= $value->unit ?></td>
								<td class="text-right"><?= $value->state != 0 ? number_format($value->state, 2, ',', ' ') : "" ?></td>
								<td class="text-right"><?= number_format($value->price, 2, ',', ' ') ?></td>
								<td class="text-right"><?= number_format($value->amount, 2, ',', ' ') ?></td>
								<td class="text-right"><?= number_format(round($value->price * $value->amount, 2), 2, ',', ' ') ?> zł</td>
								<?php $sum += round($value->price * $value->amount, 2) ?>
							</tr>

						<?php } ?>
					</tbody>
					<tfoot>
						<tr>
							<td colspan="3" class="text-right">Razem:</td>
							<td colspan="5" class="text-right" style="font-weight: bold;"><?= number_format($sum, 2, ',', ' ') ?> zł</td>
						</tr>
					</tfoot>
				</table>
			</div>
		</div>

	</div>
</div>
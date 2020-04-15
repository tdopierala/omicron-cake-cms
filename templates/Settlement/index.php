<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
	<h1 class="h2">List of settlement</h1>
</div>

<div class="row">
	<div class="col-9 mb-3 mt-3">
		<?= $this->Html->link('Create new', ['controller'=>'Settlement','action'=>'new'], ['class' => 'btn btn-secondary btn-sm']) ?>
	</div>
</div>

<div class="row">
	<div class="col-12">

		<table class="table table-striped">
			<thead class="thead-dark">
				<tr>
					<th class="text-center">Id</th>
					<th class="text-center">Period</th>
                    <th class="text-center">Settlement date</th>
					<th class="text-center">Total amount</th>
                    <th class="text-center">Action</th>
				</tr>
			</thead>
			<tbody>
			<?php foreach($settlement as $row) { ?>
				<tr>
					<td class="text-center"><?= $row->id ?></td>
					<td class="text-center"><?= date('F Y', strtotime($row->date)) ?></td>
					<td class="text-center"><?= date('Y-m-d', strtotime($row->date)) ?></td>
                    <td class="text-center"><?= number_format(round($row->summary, 2), 2, ',', ' ') ?> zł</td>
					<td class="text-center">
						<div class="btn-group">
							<?= $this->Html->link('View', ['controller'=>'Settlement','action'=>'view', $row->id], ['class' => 'btn btn-outline-dark btn-sm']) ?>
							<?= $this->Html->link('Edit', ['controller'=>'Settlement','action'=>'edit', $row->id], ['class' => 'btn btn-outline-info btn-sm']) ?>
							<?= $this->Html->link('Delete', ['controller'=>'Settlement','action'=>'delete', $row->id],['class' => 'btn btn-outline-danger btn-sm','confirm' => 'Are you sure you wish to delete this article?']) ?>
						</div>
					</td>
				</tr>
			<?php } ?>
			</tbody>
		</table>

	</div>
</div>
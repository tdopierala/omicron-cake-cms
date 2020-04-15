<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
	<h1 class="h2">List of articles</h1>
</div>

<div class="row">
	<div class="col-9">
		<?= $this->Html->link('Create new', ['controller'=>'Articles','action'=>'new'], ['class' => 'btn btn-primary btn-sm']) ?>
	</div>
</div>

<div class="row">
	<div class="col-9">

		<table class="table">
			<thead>
				<tr>
					<td>Id</td>
					<td>Title</td>
					<td>Created</td>
					<td>Last update</td>
					<td></td>
				</tr>
			</thead>
			<tbody>
			<?php foreach($articles as $article) { ?>
				<tr>
					<td><?= $article->id ?></td>
					<td><?= $article->title ?></td>
					<td><?= $article->created ?></td>
					<td><?= $article->updated ?></td>
					<td>
						<?= $this->Html->link('Edit', ['controller'=>'Articles','action'=>'edit', $article->id], ['class' => 'btn btn-primary btn-sm']) ?>
						&nbsp;
						<?= $this->Html->link('Delete', ['controller'=>'Articles','action'=>'delete', $article->id],['class' => 'btn btn-danger btn-sm','confirm' => 'Are you sure you wish to delete this article?']) ?>
					</td>
				</tr>
			<?php } ?>
			</tbody>
		</table>

	</div>
</div>
<div class="row">
	<div class="col-12 mb-4 mt-3">

		<?php 
			$action = $this->request->getParam('action');
			$index = $action=="index" || $action=="poland" ? " active" : "";
			$charts = $action=="polandCharts" ? " active" : "";
			$table = $action=="polandTable" ? " active" : "";
			$map = $action=="polandMap" ? " active" : "";
		?>

		<ul class="nav nav-tabs">
			<li class="nav-item">
				<?= $this->Html->link(__('Home'), ['controller'=>'Covid','action'=>'poland'], ['class' => 'nav-link' . $index ]) ?>
			</li>
			<li class="nav-item">
				<?= $this->Html->link(__('Charts'), ['controller'=>'Covid','action'=>'poland-charts'], ['class' => 'nav-link' . $charts ]) ?>
			</li>
			<li class="nav-item">
				<?= $this->Html->link(__('Data table'), ['controller'=>'Covid','action'=>'poland-table'], ['class' => 'nav-link' . $table ]) ?>
			</li>
			<li class="nav-item">
				<?= $this->Html->link(__('Map'), ['controller'=>'Covid','action'=>'poland-map'], ['class' => 'nav-link' . $map ]) ?>
			</li>
		</ul>
	</div>
</div>
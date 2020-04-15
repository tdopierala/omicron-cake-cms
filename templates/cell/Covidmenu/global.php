<div class="row">
	<div class="col-12 mb-4 mt-3">

		<?php 
			$action = $this->request->getParam('action');
			$index = $action=="global" ? " active" : "";
			$charts = $action=="globalCharts" ? " active" : "";
			$map = $action=="globalMap" ? " active" : "";
		?>

		<ul class="nav nav-tabs">
			<li class="nav-item">
				<?= $this->Html->link(__('Main data'), ['controller'=>'Covid','action'=>'global'], ['class' => 'nav-link' . $index ]) ?>
			</li>
			<li class="nav-item">
				<?= $this->Html->link(__('Charts'), ['controller'=>'Covid','action'=>'global-charts'], ['class' => 'nav-link' . $charts ]) ?>
			</li>
			<li class="nav-item">
				<?= $this->Html->link(__('Map'), ['controller'=>'Covid','action'=>'global-map'], ['class' => 'nav-link' . $map ]) ?>
			</li>
		</ul>

		
	</div>
</div>
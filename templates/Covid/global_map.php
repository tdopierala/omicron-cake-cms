<?php $this->Html->script('pages/covid/global_map.js', ['block' => 'script']); ?>
<?php $this->Html->script('maps/jquery-jvectormap-world-mill.js', ['block' => 'script']); ?>

<script>
	var covidData = { <?php foreach($covid as $row) echo '"' . strtoupper($row->nation_code) . '":' . $row->infected . ', '; ?> };
</script>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
	<h1 class="h2">COVID-19 Global Map</h1>
</div>

<?= $this->cell('Covidmenu::global') ?>

<div class="row">
    
	<div class="col-12 mb-4">
		
		<div class="jvectormap" id="globalMap" style="width: 100%; height: 800px;"></div>
	
	</div>

</div>
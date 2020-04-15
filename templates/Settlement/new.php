<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
	<h1 class="h2">Adding new settlement</h1>
</div>

<div class="row">
	<div class="col-12">

		<?= $this->Form->create() ?>

		<div class="form-row">
			<div class="form-group col-4">
				<label for="settlement_date">Date</label>
				<input type="text" class="form-control" id="settlement_date" name="settlement_date">
			</div>
		</div>

		<div class="form-row">
			<div class="form-group col-9">
				<label>Components</label>
			</div>
			<div class="form-group col-1">
				<label>State</label>
			</div>
			<div class="form-group col-1">
				<label>Price</label>
			</div>
			<div class="form-group col-1">
				<label>Amount</label>
			</div>
		</div>

		<?php for($i=1; $i<=count($components); $i++) { ?>
			<div class="form-row">
				<div class="form-group col-9">
					<select class="custom-select" name="component_<?= $i ?>">
						<option value="" default>--- select component ---</option>
					<?php foreach($components as $component) { ?>
						<?php if($component->id == $components[$i-1]->id) { $selected="selected"; } else { $selected=""; } ?>
						<option value="<?= $component->id ?>" <?= $selected ?>><?= $component->name ?> [<?= $component->unit ?>]</option>
					<?php } ?>
					</select>
				</div>
				<div class="form-group col-1">
					<input type="text" class="form-control" name="state_<?= $i ?>" value="" placeholder="">
				</div>
				<div class="form-group col-1">
					<input type="text" class="form-control" name="price_<?= $i ?>" value="" placeholder="">
				</div>
				<div class="form-group col-1">					
					<input type="text" class="form-control" name="amount_<?= $i ?>" value="<?= $components[$i-1]->default_amount ?>" placeholder="">
				</div>
			</div>
		<?php } ?>

		<div class="form-group">
			<?= $this->Form->submit('Save', ['class' => 'btn btn-primary']) ?>
		</div>

		<?= $this->Form->end() ?>

	</div>
</div>

<div class="row">
	<div class="col-9">
		<pre><?= print_r($settlementId,true) ?></pre>
	</div>
</div>

<div class="row">
	<div class="col-9">
		<pre><?= print_r($request,true) ?></pre>
	</div>
</div>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
	<h1 class="h2">Updating settlement</h1>
</div>

<div class="row">
	<div class="col-12">

		<?= $this->Form->create() ?>

		<div class="form-row">
			<div class="form-group col-4">
				<label for="settlement_date">Date</label>
				<input type="text" class="form-control" id="settlement_date" name="settlement_date" value="<?= $settlementDate ?>" disabled>
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
		
		<?php foreach($values as $value) { ?>

			<input type="hidden" name="valueid_<?= $value->component_id ?>" value="<?= $value->id ?>">
			
			<div class="form-row">
				<div class="form-group col-9">
					<input type="hidden" name="component_<?= $value->component_id ?>" value="<?= $value->component_id ?>">
					<select class="custom-select" name="select_<?= $value->component_id ?>" disabled>
						<option value="">--- select component ---</option>
					<?php foreach($components as $component) { ?>

						<?php if($component->id == $value->component_id) $selected="selected"; else $selected=""; ?>

						<option value="<?= $component->id ?>" <?= $selected ?>><?= $component->name ?> [<?= $component->unit ?>]</option>
					<?php } ?>
					</select>
				</div>
				<div class="form-group col-1">
					<input type="text" class="form-control" name="state_<?= $value->component_id ?>" value="<?= $value->state != 0 ? number_format($value->state, 2, ',', ' ') : "" ?>" placeholder="">
				</div>
				<div class="form-group col-1">
					<input type="text" class="form-control" name="price_<?= $value->component_id ?>" value="<?= number_format($value->price, 2, ',', ' ') ?>" placeholder="price">
				</div>
				<div class="form-group col-1">					
					<input type="text" class="form-control" name="amount_<?= $value->component_id ?>" value="<?= number_format($value->amount, 2, ',', ' ') ?>" placeholder="amount">
				</div>
			</div>

		<?php } ?>
		
		<?php foreach($components as $_component) { ?>
			
			<?php if(!in_array($_component->id, $usedComponents)) { ?>

			<input type="hidden" name="valueid_<?= $_component->id ?>" value="">

			<div class="form-row">
				<div class="form-group col-9">
					<select class="custom-select" name="component_<?= $_component->id ?>">
						<option value="">--- select component ---</option>
					<?php foreach($components as $component) { ?>
						<?php if($component->id == $_component->id) { $selected="selected"; } else { $selected=""; } ?>
						<option value="<?= $component->id ?>" <?= $selected ?>><?= $component->name ?> [<?= $component->unit ?>] (<?= $component->description ?>)</option>
					<?php } ?>
					</select>
				</div>
				<div class="form-group col-1">
					<input type="text" class="form-control" name="state_<?= $_component->id ?>" value="" placeholder="state">
				</div>
				<div class="form-group col-1">
					<input type="text" class="form-control" name="price_<?= $_component->id ?>" value="" placeholder="price">
				</div>
				<div class="form-group col-1">					
					<input type="text" class="form-control" name="amount_<?= $_component->id ?>" value="" placeholder="amount">
				</div>
			</div>

			<?php } ?>

		<?php } ?>

		<div class="form-group">
			<?= $this->Form->submit('Save', ['class' => 'btn btn-primary']) ?>
		</div>

		<?= $this->Form->end() ?>

	</div>
</div>

<div class="row">
	<div class="col-9">
		<pre><?= print_r($post,true) ?></pre>
	</div>
</div>
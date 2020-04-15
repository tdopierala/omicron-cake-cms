<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
	<h1 class="h2">Article form</h1>
</div>

<div class="row">
	<div class="col-9">

		<div class="form-group">
			<?= $this->Form->create($article) ?>
		</div>

		<div class="form-group">
			<?= $this->Form->control('title', ['class' => 'form-control']) ?>
		</div>

		<div class="form-group">
			<?php echo $this->Form->textarea('text', ['id' => 'editor']); ?>
			
			<!-- <div id="editor">
				<?= $article->text ?>
			</div> -->

			<script>
				ClassicEditor
					.create( document.querySelector( '#editor' ) )
					.then( editor => {
							console.log( editor );
					} )
					.catch( error => {
							console.error( error );
					} );
			</script>
		</div>

		<div class="form-group">
			<?= $this->Form->submit('Save', ['class' => 'btn btn-primary']) ?>
		</div>


		<?= $this->Form->end() ?>

	</div>
</div>
<?php if(!$is_processed): ?>
	<?php foreach($forms as $formName => $form): ?>
		<div class="form" id="form-<?php echo $formName ?>">
		<?php $form->render(); ?>
		</div>
	<?php endforeach; ?>
<?php endif; ?>
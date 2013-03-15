<?php if(!$is_processed): ?>
	<div id="Form-Chooser" class="state-editor state-form hero-unit">
		<p><?php echo l('body_form_please_fill') ?></p>
		<h2><?php echo l('body_form_type') ?></h2>
		<div>
			<a href="#form-individual" class="btn btn-large btn-success">
				<?php echo l('body_form_individual_button') ?>
			</a>
			<a href="#form-company" class="btn btn-large btn-success">
				<?php echo l('body_form_company_button') ?>
			</a>
		</div>
	</div>
	<?php foreach($forms as $formName => $form): ?>
		<div class="form" id="form-<?php echo $formName ?>">
		<?php $form->render(); ?>
		</div>
	<?php endforeach; ?>
<?php endif; ?>
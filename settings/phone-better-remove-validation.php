<?php 
/**
 * @param array $form The form config
 */
?>

<div class="caldera-config-group">
	<fieldset>
		<legend><?php esc_html_e( 'Phone (Better) validation', 'caldera-forms'); ?></legend>
		<div class="caldera-config-field">
			<input 
				type="checkbox" 
				id="caldera-forms-phone_better_remove_js_validation" 
				value="1" 
				name="config[phone_better_remove_js_validation]" 
				class="field-config"
				<?php if ( isset( $form['phone_better_remove_js_validation'] ) ) { echo ' checked="checked"'; } ?>>
			<p class="description">
				<?php esc_html_e( 'Remove Phone (Better) field JavaScript validation (if applicable).', 'caldera-forms'); ?>
			</p>
		</div>
	</fieldset>
</div>
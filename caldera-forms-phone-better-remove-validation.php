<?php
/**
 * Plugin Name: Caldera Forms Phone (Better) - Remove JS Validation
 * Description: Adds a setting in the Form Settings tab to remove Phone (Better) JavaScript validation.
 * Version: 0.1
 * Author: Andrei Mondoc
 * Author URI: https://github.com/mecachisenros
 * Plugin URI: https://github.com/mecachisenros/caldera-forms-phone-better-remove-validation
 * GitHub Plugin URI: mecachisenros/remove-caldera-forms-phone-better-validation
 */

class Caldera_Forms_Phone_Better_Remove_Validation {

	public $version = '0.1';
	private $path;
	private $url;

	public function __construct() {
		$this->path = plugin_dir_path( __FILE__ );
		$this->url = plugin_dir_url( __FILE__ );
		add_action( 'caldera_forms_core_init', [ $this, 'register_hooks' ] ); 
	}

	public function register_hooks() {
		add_action( 'caldera_forms_general_settings_panel', [ $this, 'register_setting' ] );
		add_action( 'caldera_forms_assets_registered', [ $this, 'register_assets' ] );
		add_action( 'caldera_forms_render_get_form', [ $this, 'maybe_remove_validation' ] );
	}

	public function register_setting( $form ) {
		if ( ! is_readable( $this->path . 'settings/phone-better-remove-validation.php' ) )
            echo sprintf('<h2>Could not read <em>"%s"</em> file.<h2>', $this->path . 'settings/phone-better-remove-validation.php' );
		ob_start();
		include $this->path . 'settings/phone-better-remove-validation.php';
		$setting = ob_get_clean();
		echo $setting;

	}

	public function register_assets( $script_style_urls ) {
		wp_register_script( 'phone-better-remove-validation', $this->url . 'assets/phone-better-remove-validation.js', [ 'jquery' ], $this->version, true );
	}

	public function maybe_remove_validation( $form ) {
		slack( [ 'has' => Caldera_Forms_Field_Util::has_field_type( 'phone_better', $form ), 'is' => isset( $form['phone_better_remove_js_validation'] ) ] );

		if ( Caldera_Forms_Field_Util::has_field_type( 'phone_better', $form ) && isset( $form['phone_better_remove_js_validation'] ) )
			wp_enqueue_script( 'phone-better-remove-validation' );

		return $form;
	}

}

new Caldera_Forms_Phone_Better_Remove_Validation;

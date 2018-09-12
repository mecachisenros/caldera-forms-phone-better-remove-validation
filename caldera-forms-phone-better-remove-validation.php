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

	/**
	 * Version.
	 * @since 0.1
	 * @var string $version
	 */
	public $version = '0.1';

	/**
	 * Plugin path.
	 * @since 0.1
	 * @var string $path
	 */
	private $path;

	/**
	 * Plugin url.
	 * @since 0.1
	 * @var string $url
	 */
	private $url;

	/**
	 * Constructor.
	 * @since 0.1
	 */
	public function __construct() {
		// plugin path
		$this->path = plugin_dir_path( __FILE__ );
		// plugin url
		$this->url = plugin_dir_url( __FILE__ );
		// initiliaze
		add_action( 'caldera_forms_core_init', [ $this, 'register_hooks' ] ); 
	}

	/**
	 * Register hooks.
	 * @since 0.1
	 */
	public function register_hooks() {
		// register setting
		add_action( 'caldera_forms_general_settings_panel', [ $this, 'register_setting' ] );
		// regster script
		add_action( 'caldera_forms_assets_registered', [ $this, 'register_assets' ] );
		// enqueue script
		add_action( 'caldera_forms_render_get_form', [ $this, 'maybe_remove_validation' ] );
	}

	/**
	 * Add setting field to form Settings tab.
	 * @since 0.2
	 * @param array $form The form cofig
	 */
	public function register_setting( $form ) {

		ob_start();
		include $this->path . 'settings/phone-better-remove-validation.php';
		$setting = ob_get_clean();
		echo $setting;

	}

	/**
	 * Register scritp.
	 * @since 0.1
	 * @param array $script_style_urls The Caldera Forms scripts and styles urls
	 */
	public function register_assets( $script_style_urls ) {
		wp_register_script( 'phone-better-remove-validation', $this->url . 'assets/phone-better-remove-validation.js', [ 'jquery' ], $this->version, true );
	}

	/**
	 * Enqueues our script to override the Phone (Better) field validation if conditions are met.
	 * @since 0.1
	 * @param array $form The form config
	 * @return array $form The filtered form config
	 */
	public function maybe_remove_validation( $form ) {

		if ( Caldera_Forms_Field_Util::has_field_type( 'phone_better', $form ) && isset( $form['phone_better_remove_js_validation'] ) )
			wp_enqueue_script( 'phone-better-remove-validation' );

		return $form;

	}

}

// initialize plugin
new Caldera_Forms_Phone_Better_Remove_Validation;

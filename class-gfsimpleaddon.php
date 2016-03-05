<?php

GFForms::include_addon_framework();

class GFSimpleAddOn extends GFAddOn {

	protected $_version = GF_SIMPLE_ADDON_VERSION;
	protected $_min_gravityforms_version = '1.9';
	protected $_slug = 'simpleaddon';
	protected $_path = 'simpleaddon/simpleaddon.php';
	protected $_full_path = __FILE__;
	protected $_title = 'Gravity Forms Simple Add-On';
	protected $_short_title = 'Simple Add-On';

	private static $_instance = null;

	/**
	 * Get an instance of this class.
	 *
	 * @return GFSimpleAddOn
	 */
	public static function get_instance() {
		if ( self::$_instance == null ) {
			self::$_instance = new GFSimpleAddOn();
		}

		return self::$_instance;
	}

	/**
	 * Handles hooks and loading of language files.
	 */
	public function init() {
		parent::init();
		add_filter( 'gform_submit_button', array( $this, 'form_submit_button' ), 10, 2 );
	}


	// # SCRIPTS & STYLES -----------------------------------------------------------------------------------------------

	/**
	 * Return the scripts which should be enqueued.
	 *
	 * @return array
	 */
	public function scripts() {
		$scripts = array(
			array(
				'handle'  => 'my_script_js',
				'src'     => $this->get_base_url() . '/js/my_script.js',
				'version' => $this->_version,
				'deps'    => array( 'jquery' ),
				'strings' => array(
					'first'  => esc_html__( 'First Choice', 'simpleaddon' ),
					'second' => esc_html__( 'Second Choice', 'simpleaddon' ),
					'third'  => esc_html__( 'Third Choice', 'simpleaddon' )
				),
				'enqueue' => array(
					array(
						'admin_page' => array( 'form_settings' ),
						'tab'        => 'simpleaddon'
					)
				)
			),

		);

		return array_merge( parent::scripts(), $scripts );
	}

	/**
	 * Return the stylesheets which should be enqueued.
	 *
	 * @return array
	 */
	public function styles() {
		$styles = array(
			array(
				'handle'  => 'my_styles_css',
				'src'     => $this->get_base_url() . '/css/my_styles.css',
				'version' => $this->_version,
				'enqueue' => array(
					array( 'field_types' => array( 'poll' ) )
				)
			)
		);

		return array_merge( parent::styles(), $styles );
	}


	// # FRONTEND FUNCTIONS --------------------------------------------------------------------------------------------

	/**
	 * Add the text in the plugin settings to the bottom of the form if enabled for this form.
	 *
	 * @param string $button The string containing the input tag to be filtered.
	 * @param array $form The form currently being displayed.
	 *
	 * @return string
	 */
	function form_submit_button( $button, $form ) {
		$settings = $this->get_form_settings( $form );
		if ( isset( $settings['enabled'] ) && true == $settings['enabled'] ) {
			$text   = $this->get_plugin_setting( 'mytextbox' );
			$button = "<div>{$text}</div>" . $button;
		}

		return $button;
	}


	// # ADMIN FUNCTIONS -----------------------------------------------------------------------------------------------

	/**
	 * Creates a custom page for this add-on.
	 */
	public function plugin_page() {
		echo 'This page appears in the Forms menu';
	}

	/**
	 * Configures the settings which should be rendered on the add-on settings tab.
	 *
	 * @return array
	 */
	public function plugin_settings_fields() {
		return array(
			array(
				'title'  => esc_html__( 'Simple Add-On Settings', 'simpleaddon' ),
				'fields' => array(
					array(
						'name'              => 'mytextbox',
						'tooltip'           => esc_html__( 'This is the tooltip', 'simpleaddon' ),
						'label'             => esc_html__( 'This is the label', 'simpleaddon' ),
						'type'              => 'text',
						'class'             => 'small',
						'feedback_callback' => array( $this, 'is_valid_setting' ),
					)
				)
			)
		);
	}

	/**
	 * Configures the settings which should be rendered on the Form Settings > Simple Add-On tab.
	 *
	 * @return array
	 */
	public function form_settings_fields( $form ) {
		return array(
			array(
				'title'  => esc_html__( 'Simple Form Settings', 'simpleaddon' ),
				'fields' => array(
					array(
						'label'   => esc_html__( 'My checkbox', 'simpleaddon' ),
						'type'    => 'checkbox',
						'name'    => 'enabled',
						'tooltip' => esc_html__( 'This is the tooltip', 'simpleaddon' ),
						'choices' => array(
							array(
								'label' => esc_html__( 'Enabled', 'simpleaddon' ),
								'name'  => 'enabled',
							),
						),
					),
					array(
						'label'   => esc_html__( 'My checkboxes', 'simpleaddon' ),
						'type'    => 'checkbox',
						'name'    => 'checkboxgroup',
						'tooltip' => esc_html__( 'This is the tooltip', 'simpleaddon' ),
						'choices' => array(
							array(
								'label' => esc_html__( 'First Choice', 'simpleaddon' ),
								'name'  => 'first',
							),
							array(
								'label' => esc_html__( 'Second Choice', 'simpleaddon' ),
								'name'  => 'second',
							),
							array(
								'label' => esc_html__( 'Third Choice', 'simpleaddon' ),
								'name'  => 'third',
							),
						),
					),
					array(
						'label'   => esc_html__( 'My Radio Buttons', 'simpleaddon' ),
						'type'    => 'radio',
						'name'    => 'myradiogroup',
						'tooltip' => esc_html__( 'This is the tooltip', 'simpleaddon' ),
						'choices' => array(
							array(
								'label' => esc_html__( 'First Choice', 'simpleaddon' ),
							),
							array(
								'label' => esc_html__( 'Second Choice', 'simpleaddon' ),
							),
							array(
								'label' => esc_html__( 'Third Choice', 'simpleaddon' ),
							),
						),
					),
					array(
						'label'      => esc_html__( 'My Horizontal Radio Buttons', 'simpleaddon' ),
						'type'       => 'radio',
						'horizontal' => true,
						'name'       => 'myradiogrouph',
						'tooltip'    => esc_html__( 'This is the tooltip', 'simpleaddon' ),
						'choices'    => array(
							array(
								'label' => esc_html__( 'First Choice', 'simpleaddon' ),
							),
							array(
								'label' => esc_html__( 'Second Choice', 'simpleaddon' ),
							),
							array(
								'label' => esc_html__( 'Third Choice', 'simpleaddon' ),
							),
						),
					),
					array(
						'label'   => esc_html__( 'My Dropdown', 'simpleaddon' ),
						'type'    => 'select',
						'name'    => 'mydropdown',
						'tooltip' => esc_html__( 'This is the tooltip', 'simpleaddon' ),
						'choices' => array(
							array(
								'label' => esc_html__( 'First Choice', 'simpleaddon' ),
								'value' => 'first',
							),
							array(
								'label' => esc_html__( 'Second Choice', 'simpleaddon' ),
								'value' => 'second',
							),
							array(
								'label' => esc_html__( 'Third Choice', 'simpleaddon' ),
								'value' => 'third',
							),
						),
					),
					array(
						'label'             => esc_html__( 'My Text Box', 'simpleaddon' ),
						'type'              => 'text',
						'name'              => 'mytext',
						'tooltip'           => esc_html__( 'This is the tooltip', 'simpleaddon' ),
						'class'             => 'medium',
						'feedback_callback' => array( $this, 'is_valid_setting' ),
					),
					array(
						'label'   => esc_html__( 'My Text Area', 'simpleaddon' ),
						'type'    => 'textarea',
						'name'    => 'mytextarea',
						'tooltip' => esc_html__( 'This is the tooltip', 'simpleaddon' ),
						'class'   => 'medium merge-tag-support mt-position-right',
					),
					array(
						'label' => esc_html__( 'My Hidden Field', 'simpleaddon' ),
						'type'  => 'hidden',
						'name'  => 'myhidden',
					),
					array(
						'label' => esc_html__( 'My Custom Field', 'simpleaddon' ),
						'type'  => 'my_custom_field_type',
						'name'  => 'my_custom_field',
						'args'  => array(
							'text'     => array(
								'label'         => esc_html__( 'A textbox sub-field', 'simpleaddon' ),
								'name'          => 'subtext',
								'default_value' => 'change me',
							),
							'checkbox' => array(
								'label'   => esc_html__( 'A checkbox sub-field', 'simpleaddon' ),
								'name'    => 'my_custom_field_check',
								'choices' => array(
									array(
										'label'         => esc_html__( 'Activate', 'simpleaddon' ),
										'name'          => 'subcheck',
										'default_value' => true,
									),
								),
							),
						),
					),
				),
			),
		);
	}

	/**
	 * Define the markup for the my_custom_field_type type field.
	 *
	 * @param array $field The field properties.
	 * @param bool|true $echo Should the setting markup be echoed.
	 */
	public function settings_my_custom_field_type( $field, $echo = true ) {
		echo '<div>' . esc_html__( 'My custom field contains a few settings:', 'simpleaddon' ) . '</div>';

		// get the text field settings from the main field and then render the text field
		$text_field = $field['args']['text'];
		$this->settings_text( $text_field );

		// get the checkbox field settings from the main field and then render the checkbox field
		$checkbox_field = $field['args']['checkbox'];
		$this->settings_checkbox( $checkbox_field );
	}


	// # HELPERS -------------------------------------------------------------------------------------------------------

	/**
	 * The feedback callback for the 'mytextbox' setting on the plugin settings page and the 'mytext' setting on the form settings page.
	 *
	 * @param string $value The setting value.
	 *
	 * @return bool
	 */
	public function is_valid_setting( $value ) {
		return strlen( $value ) < 10;
	}

}
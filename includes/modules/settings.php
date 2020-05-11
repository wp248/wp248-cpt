<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @link       wp248.com
 * @since      0.0.1
 *
 * @package    cpt_services
 * @subpackage cpt_services/includes/modules
 */

/**
 * Setting class for wp248 cpt
 *
 */


class cpt_settings {


	/**
	 * The ID of this plugin.
	 *
	 * @since    0.0.1
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    0.0.1
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    0.0.1
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->load_dependencies();
		// Initialize Default setting
		if (false == get_option('wp248_cbt_display_options')) {
			$default_array = $this->default_display_options();
			add_option('wp248_cbt_display_options', $default_array);
		}
	}

	/**
	 * Load the required dependencies for this plugin.
	 */
	private function load_dependencies()
	{
		// Loading css/js and custom code
	}

	/**
	 * Check menu item exists
	 * @param string $main_menu_unique_id
	 * @return bool
	 */
	public function is_menu_item_exists($main_menu_unique_id='')
	{
		if (!( empty ( $GLOBALS['admin_page_hooks'][$main_menu_unique_id] ) ))
			return true;
	}

	/**
	 * Check sub menu item exists under top menu
	 * @param string $main_menu_unique_id
	 * @param string $submenu_unique_id
	 * @return bool
	 */
	public function is_submenu_item_exists($main_menu_unique_id='', $submenu_unique_id='')
	{
		global $submenu;
		if (isset( $submenu[ $main_menu_unique_id ] )
			&& in_array( $main_menu_unique_id, wp_list_pluck( $submenu[ $main_menu_unique_id ], 2 ) )
		)
			return true;
	}

	/**
	 * Provides default values for the Display Options.
	 *
	 * @return array
	 */
	private function default_display_options() {

		$defaults = array(
			'customers_speak'		=>	'1',
			'jobs'					=>	'1',
			'partners'				=>	'1',
			'portfolios'			=>	'1',
			'services'				=>	'1',
			'tech_terms'			=>	'0',
			'technologies'			=>	'0',
		);

		return $defaults;

	}

	public function add_action_admin_init()
	{
		$this->initialize_display_modules_options();
	}

	/**
	 * Initializes the theme's display options page by registering the Sections,
	 * Fields, and Settings.
	 *
	 * This function is registered with the 'admin_init' hook.
	 */
	private function initialize_display_modules_options()
	{
		// If the theme options don't exist, create them.
		if (false == get_option('wp248_cbt_display_options')) {
			$default_array = $this->default_display_options();
			add_option('wp248_cbt_display_options', $default_array);
		}
		add_settings_section(
			'general_settings_section',			            		// ID used to identify this section and with which to register options
			__( 'Display Options', 'wp248-cpt' ),			// Title to be displayed on the administration page
			array( $this, 'general_options_callback'),	    		// Callback used to render the description of the section
			'wp248_cbt_display_options'		            	// Page on which to add this section of options
		);
		// Next, we'll introduce the fields for toggling the visibility of content elements.
		add_settings_field(
			'show_cpt_customers_speak',						        // ID used to identify the field throughout the theme
			__( 'Show Customers Speak', 'wp248-cpt' ),			// The label to the left of the option interface element
			array( $this, 'toggle_show_cpt_customers_speak_callback'),	// The name of the function responsible for rendering the option interface
			'wp248_cbt_display_options',	    				// The page on which this option will be displayed
			'general_settings_section',			        		// The name of the section to which this field belongs
			array(								        		// The array of arguments to pass to the callback. In this case, just a description.
				__( 'Activate this setting to display CPT Customers Speak.', 'wp248-cpt' ),
			)
		);

		// Next, we'll introduce the fields for toggling the visibility of content elements.
		add_settings_field(
			'show_cpt_jobs',						        // ID used to identify the field throughout the theme
			__( 'Show Jobs', 'wp248-cpt' ),			// The label to the left of the option interface element
			array( $this, 'toggle_show_cpt_jobs_callback'),	// The name of the function responsible for rendering the option interface
			'wp248_cbt_display_options',	    				// The page on which this option will be displayed
			'general_settings_section',			        		// The name of the section to which this field belongs
			array(								        		// The array of arguments to pass to the callback. In this case, just a description.
				__( 'Activate this setting to display CPT Jobs.', 'wp248-cpt' ),
			)
		);

		// Next, we'll introduce the fields for toggling the visibility of content elements.
		add_settings_field(
			'show_cpt_partners',						        // ID used to identify the field throughout the theme
			__( 'Show Partners', 'wp248-cpt' ),			// The label to the left of the option interface element
			array( $this, 'toggle_show_cpt_partners_callback'),	// The name of the function responsible for rendering the option interface
			'wp248_cbt_display_options',	    				// The page on which this option will be displayed
			'general_settings_section',			        		// The name of the section to which this field belongs
			array(								        		// The array of arguments to pass to the callback. In this case, just a description.
				__( 'Activate this setting to display CPT Partners.', 'wp248-cpt' ),
			)
		);

		// Next, we'll introduce the fields for toggling the visibility of content elements.
		add_settings_field(
			'show_cpt_portfolios',						        // ID used to identify the field throughout the theme
			__( 'Show Portfolios', 'wp248-cpt' ),			// The label to the left of the option interface element
			array( $this, 'toggle_show_cpt_portfolios_callback'),	// The name of the function responsible for rendering the option interface
			'wp248_cbt_display_options',	    				// The page on which this option will be displayed
			'general_settings_section',			        		// The name of the section to which this field belongs
			array(								        		// The array of arguments to pass to the callback. In this case, just a description.
				__( 'Activate this setting to display CPT Portfolios.', 'wp248-cpt' ),
			)
		);

		// Next, we'll introduce the fields for toggling the visibility of content elements.
		add_settings_field(
			'show_cpt_services',						        // ID used to identify the field throughout the theme
			__( 'Show Services', 'wp248-cpt' ),			// The label to the left of the option interface element
			array( $this, 'toggle_show_cpt_services_callback'),	// The name of the function responsible for rendering the option interface
			'wp248_cbt_display_options',	    				// The page on which this option will be displayed
			'general_settings_section',			        		// The name of the section to which this field belongs
			array(								        		// The array of arguments to pass to the callback. In this case, just a description.
				__( 'Activate this setting to display CPT Services.', 'wp248-cpt' ),
			)
		);
		// Next, we'll introduce the fields for toggling the visibility of content elements.
		add_settings_field(
			'show_cpt_tech_terms',						        // ID used to identify the field throughout the theme
			__( 'Show Tech Terms', 'wp248-cpt' ),			// The label to the left of the option interface element
			array( $this, 'toggle_show_cpt_tech_terms_callback'),	// The name of the function responsible for rendering the option interface
			'wp248_cbt_display_options',	    				// The page on which this option will be displayed
			'general_settings_section',			        		// The name of the section to which this field belongs
			array(								        		// The array of arguments to pass to the callback. In this case, just a description.
				__( 'Activate this setting to display CPT Tech Terms.', 'wp248-cpt' ),
			)
		);
		// Next, we'll introduce the fields for toggling the visibility of content elements.
		add_settings_field(
			'show_cpt_technologies',						        // ID used to identify the field throughout the theme
			__( 'Show Technologies', 'wp248-cpt' ),			// The label to the left of the option interface element
			array( $this, 'toggle_show_cpt_Technologies_callback'),	// The name of the function responsible for rendering the option interface
			'wp248_cbt_display_options',	    				// The page on which this option will be displayed
			'general_settings_section',			        		// The name of the section to which this field belongs
			array(								        		// The array of arguments to pass to the callback. In this case, just a description.
				__( 'Activate this setting to display CPT Services.', 'wp248-cpt' ),
			)
		);


		// Finally, we register the fields with WordPress
		register_setting(
			'wp248_cbt_display_options',
			'wp248_cbt_display_options'
		);

	}

	/**
	 * This function provides a simple description for the General Options page.
	 *
	 * It's called from the 'wppb-demo_initialize_theme_options' function by being passed as a parameter
	 * in the add_settings_section function.
	 */
	public function general_options_callback() {
		$options = get_option('wp248_cbt_display_options');
		/** Dump variable only if debug is enabled */
		if (defined('WP_DEBUG') && WP_DEBUG) {
			var_dump($options);
		}
		echo '<p>' . __( 'Select which CPT module will be activated.', 'wp248-cpt' ) . '</p>';

	} // en

	public function toggle_show_cpt_customers_speak_callback($args)
	{
		// First, we read the options collection
		$options = get_option('wp248_cbt_display_options');
		// Next, we update the name attribute to access this element's ID in the context of the display options array
		// We also access the show_header element of the options collection in the call to the checked() helper function
		$html = '<input type="checkbox" id="show_cpt_customers_speak" name="wp248_cbt_display_options[customers_speak]" value="1" ' . checked( 1, isset( $options['customers_speak'] ) ? $options['customers_speak'] : 0, false ) . '/>';

		// Here, we'll take the first argument of the array and add it to a label next to the checkbox
		$html .= '<label for="show_cpt_customers_speak">&nbsp;'  . $args[0] . '</label>';

		echo $html;


	}

	public function toggle_show_cpt_jobs_callback($args)
	{
		// First, we read the options collection
		$options = get_option('wp248_cbt_display_options');
		// Next, we update the name attribute to access this element's ID in the context of the display options array
		// We also access the show_header element of the options collection in the call to the checked() helper function
		$html = '<input type="checkbox" id="show_cpt_jobs" name="wp248_cbt_display_options[jobs]" value="1" ' . checked( 1, isset( $options['jobs'] ) ? $options['jobs'] : 0, false ) . '/>';

		// Here, we'll take the first argument of the array and add it to a label next to the checkbox
		$html .= '<label for="show_cpt_jobs">&nbsp;'  . $args[0] . '</label>';

		echo $html;


	}

	public function toggle_show_cpt_partners_callback($args)
	{
		// First, we read the options collection
		$options = get_option('wp248_cbt_display_options');
		// Next, we update the name attribute to access this element's ID in the context of the display options array
		// We also access the show_header element of the options collection in the call to the checked() helper function
		$html = '<input type="checkbox" id="show_cpt_partners" name="wp248_cbt_display_options[partners]" value="1" ' . checked( 1, isset( $options['partners'] ) ? $options['partners'] : 0, false ) . '/>';

		// Here, we'll take the first argument of the array and add it to a label next to the checkbox
		$html .= '<label for="show_cpt_partners">&nbsp;'  . $args[0] . '</label>';

		echo $html;


	}

	public function toggle_show_cpt_portfolios_callback($args)
	{
		// First, we read the options collection
		$options = get_option('wp248_cbt_display_options');
		// Next, we update the name attribute to access this element's ID in the context of the display options array
		// We also access the show_header element of the options collection in the call to the checked() helper function
		$html = '<input type="checkbox" id="show_cpt_portfolios" name="wp248_cbt_display_options[portfolios]" value="1" ' . checked( 1, isset( $options['portfolios'] ) ? $options['portfolios'] : 0, false ) . '/>';

		// Here, we'll take the first argument of the array and add it to a label next to the checkbox
		$html .= '<label for="show_cpt_services">&nbsp;'  . $args[0] . '</label>';

		echo $html;


	}

	public function toggle_show_cpt_services_callback($args)
	{
		// First, we read the options collection
		$options = get_option('wp248_cbt_display_options');
		// Next, we update the name attribute to access this element's ID in the context of the display options array
		// We also access the show_header element of the options collection in the call to the checked() helper function
		$html = '<input type="checkbox" id="show_cpt_services" name="wp248_cbt_display_options[services]" value="1" ' . checked( 1, isset( $options['services'] ) ? $options['services'] : 0, false ) . '/>';

		// Here, we'll take the first argument of the array and add it to a label next to the checkbox
		$html .= '<label for="show_cpt_services">&nbsp;'  . $args[0] . '</label>';

		echo $html;


	}

	public function toggle_show_cpt_tech_terms_callback($args)
	{
		// First, we read the options collection
		$options = get_option('wp248_cbt_display_options');
		// Next, we update the name attribute to access this element's ID in the context of the display options array
		// We also access the show_header element of the options collection in the call to the checked() helper function
		$html = '<input type="checkbox" id="show_cpt_tech_terms" name="wp248_cbt_display_options[tech_terms]" value="1" ' . checked( 1, isset( $options['tech_terms'] ) ? $options['tech_terms'] : 0, false ) . '/>';

		// Here, we'll take the first argument of the array and add it to a label next to the checkbox
		$html .= '<label for="show_cpt_tech_terms">&nbsp;'  . $args[0] . '</label>';

		echo $html;


	}

	public function toggle_show_cpt_technologies_callback($args)
	{
		// First, we read the options collection
		$options = get_option('wp248_cbt_display_options');
		// Next, we update the name attribute to access this element's ID in the context of the display options array
		// We also access the show_header element of the options collection in the call to the checked() helper function
		$html = '<input type="checkbox" id="show_cpt_technologies" name="wp248_cbt_display_options[technologies]" value="1" ' . checked( 1, isset( $options['technologies'] ) ? $options['technologies'] : 0, false ) . '/>';

		// Here, we'll take the first argument of the array and add it to a label next to the checkbox
		$html .= '<label for="show_cpt_technologies">&nbsp;'  . $args[0] . '</label>';

		echo $html;


	}

	/**
	 * setup_plugin_options_menu
	 */
	public function add_action_add_menu()
	{
		$OPTION_NAME = 'wp248_menu_settings';
		//define($_OPTION_NAME , 'wp248_menu_settings');
		add_menu_page(
			__('WP248 Settings','wp248_cpt'),
			__('WP248 CPT', 'wp248_cpt'),
			'manage_options',
			$OPTION_NAME,
			[ $this, 'render_settings_page_content' ],
			plugins_url('../assets/images/limitlessv-logo-no-bg-logo-20x20.svg', __DIR__)
		);

		add_submenu_page(
			$OPTION_NAME,							// The parent_slug
			__( 'WP248 Settings', 'wp248_cpt' ),			// The title to be displayed in the browser window for this page.
			__( 'General', 'wp248_cpt' ),					// The text to be displayed for this menu item
			'manage_options',								// Which type of users can see this menu item
			$OPTION_NAME,							// The unique ID - that is, the slug - for this menu item
			array($this, 'render_settings_page_content')	// The name of the function to call when rendering this menu's page
		);
		add_submenu_page(
			$OPTION_NAME,							// The parent_slug
			__( 'WP248 Appearance', 'wp248_cpt' ),			// The title to be displayed in the browser window for this page.
			__( 'Appearance', 'wp248_cpt' ),					// The text to be displayed for this menu item
			'manage_options',								// Which type of users can see this menu item
			'wp248_menu_settings_appearance',							// The unique ID - that is, the slug - for this menu item
			array($this, 'render_settings_appearance_content')	// The name of the function to call when rendering this menu's page
		);


		add_settings_section(
			'general',
			false,
			'__return_false',
			'wp248_menu_settings'
		);
	}

	/**
	 * Renders a simple page to display for the theme menu defined above.
	 */
	public function render_settings_page_content( $active_tab = '' ) {
	?>
		<div class="wrap">

		<h2><?php _e( 'Settings for WP248 Custom posts', 'wp248-cpt' ); ?></h2>
		<?php settings_errors(); ?>
		<?php if( isset( $_GET[ 'tab' ] ) ) {
			$active_tab = $_GET[ 'tab' ];
		} else {
			$active_tab = 'general_display_options';
		} // end if/else ?>
		<h2 class="nav-tab-wrapper">
			<a href="?tab=general_display_options" class="nav-tab <?php echo $active_tab == 'general_display_options' ? 'nav-tab-active' : ''; ?>"><?php _e( 'Display Options', 'wp248-cpt' ); ?></a>
		</h2>

			<form method="post" action="options.php">

				<?php

				if( $active_tab == 'general_display_options' ) {
					settings_fields( 'wp248_cbt_display_options' );
					do_settings_sections( 'wp248_cbt_display_options' );
				} // end if/else

				if ( current_user_can( 'manage_options' ) ) {
					submit_button();
				?>
						<pre>Note:<br/>Disable or Enabling custom post type will not delete his posts or taxonomy. See faq sections for more details.
</pre>
				<?php
				}

				?>
			</form>

		</div><!-- /.wrap -->
		<?php
	}

	public function render_settings_appearance_content() {
		?>
		<div class="wrap">
			<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
			<?php settings_errors(); ?>
			<form id="appearance-settings" action="options.php" method="post">
				<?php
				//settings_fields( AMP_Options_Manager::OPTION_NAME );
				//do_settings_sections( AMP_Options_Manager::OPTION_NAME );
				if ( current_user_can( 'manage_options' ) ) {
					//submit_button();
				}
				echo('show_customers_speak:'.$this->is_module_enable('customers_speak'));
				echo(' Type of:'.gettype($this->is_module_enable('customers_speak')));
				echo('<br/>');
				echo('show_cpt_jobs:'.$this->is_module_enable('jobs'));
				echo(' Type of:'.gettype($this->is_module_enable('jobs')));
				?>

			</form>
		</div>
		<?php
	}

	public function is_module_enable($fld_id, $option_array='wp248_cbt_display_options')
			{
				// First, we read the options collection
				$options = get_option($option_array);
				$value="1";
				if ((isset($options[$fld_id]) ? $options[$fld_id] : null) == $value) { return true;}
				return false;
			}
}

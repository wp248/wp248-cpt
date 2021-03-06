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
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    cpt_services
 * @subpackage cpt_services/includes/modules
 * @author     wp248 <info@wp248.com>
 */

class cpt_services {

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
23	 *
	 * @since    0.0.1
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->load_dependencies();

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    0.0.1
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in cpt_services_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The cpt_services_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, WP248_CPT_ASSETS_CSS . 'wp248-cpt-services.min.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    0.0.1
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in cpt_services_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The cpt_services_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, WP248_CPT_ASSETS_JS . 'wp248-cpt.min.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Load the required dependencies for the Admin facing functionality.
	 *
	 * @since    0.0.1
	 * @access   private
	 */
	private function load_dependencies()
	{

	}

	/**
	 * Init module: Create & register taxonomy
	 */
	public function module_actions_init()
	{
		$this->create_custom_post();
		$this->  register_taxonomy();
		flush_rewrite_rules();
	}

	/** Register taxonomy */
	private function register_taxonomy() {

		/**
		 * Taxonomy: Services Category.
		 */

		$labels = [
			"name" => __( "Categories", "wp248-cpt" ),
			"singular_name" => __( "Service Category", "wp248-cpt" ),
		];

		$args = [
			"label" => __( "Category", "wp248-cpt" ),
			"labels" => $labels,
			"public" => true,
			"publicly_queryable" => true,
			"hierarchical" => true,
			"show_ui" => true,
			"show_in_menu" => true,
			"show_in_nav_menus" => true,
			"query_var" => true,
			"rewrite" => [ 'slug' => 'service_category', 'with_front' => true, ],
			"show_admin_column" => false,
			"show_in_rest" => true,
			"rest_base" => "service_category",
			"rest_controller_class" => "WP_REST_Terms_Controller",
			"show_in_quick_edit" => true,
		];
		register_taxonomy( "service_category", [ "services" ], $args );
	}

	/** create custom post */
	private function create_custom_post()
	{
		/**
		 * Post Type: Services.
		 */

		$labels = [
			"name" => __( "Services", "wp248-cpt" ),
			"singular_name" => __( "Service", "wp248-cpt" ),
		];

		$args = [
			"label" => __( "Services", "wp248-cpt" ),
			"labels" => $labels,
			"description" => "",
			"public" => true,
			"publicly_queryable" => true,
			"show_ui" => true,
			"show_in_rest" => true,
			"rest_base" => "",
			"rest_controller_class" => "WP_REST_Posts_Controller",
			"has_archive" => true,
			"show_in_menu" => true,
			"show_in_nav_menus" => true,
			"delete_with_user" => false,
			"exclude_from_search" => false,
			"capability_type" => "post",
			"map_meta_cap" => true,
			"hierarchical" => false,
			"rewrite" => [ "slug" => "services", "with_front" => true ],
			"query_var" => true,
			"supports" => [ "title", "editor", "thumbnail" ],
		];

		register_post_type( "services", $args );
	}

	/** called for wp add_action  */
	public function add_action_admin_init()
	{

	}

	/** called for wp add_menu  */
	public function add_action_add_menu()
	{

	}

}

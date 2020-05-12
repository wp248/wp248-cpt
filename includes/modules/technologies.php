<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @link       wp248.com
 * @since      0.0.1
 *
 * @package    cpt_technologies
 * @subpackage cpt_technologies/includes/modules
 */

/**
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    cpt_technologies
 * @subpackage cpt_technologies/includes/modules
 * @author     wp248 <info@wp248.com>
 */

class cpt_technologies {

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
	 * The CSS files for this module.
	 *
	 * @since    0.0.1
	 * @access   private
	 * @var      string    $module_css    The CSS files.
	 */
	private $module_css;

	/**
	 * The JS files for this module.
	 *
	 * @since    0.0.1
	 * @access   private
	 * @var      string    $module_js    The JS files.
	 */
	private $module_js;

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
		$this->module_css = WP248_CPT_ASSETS_CSS . 'wp248-cpt-technologies.min.css';
		$this->module_js = WP248_CPT_ASSETS_JS . 'wp248-cpt-technologies.min.js';
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
		 * defined in cpt_technologies_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The cpt_technologies_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		wp_enqueue_style( $this->plugin_name,  $this->module_css , array(), $this->version, 'all' );

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
		 * defined in cpt_technologies_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The cpt_technologies_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name,  $this->module_js , array( 'jquery' ), $this->version, false );

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
		 * Taxonomy: Technologies Category.
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
			"rewrite" => [ 'slug' => 'technology_category', 'with_front' => true, ],
			"show_admin_column" => false,
			"show_in_rest" => true,
			"rest_base" => "technology_category",
			"rest_controller_class" => "WP_REST_Terms_Controller",
			"show_in_quick_edit" => true,
		];
		register_taxonomy( "service_category", [ "technologies" ], $args );
	}

	/** create custom post */
	private function create_custom_post()
	{
		/**
		 * Post Type: Technologies.
		 */

		$labels = [
			"name" => __( "Technologies", "wp248-cpt" ),
			"singular_name" => __( "Technology", "wp248-cpt" ),
		];

		$args = [
			"label" => __( "Technology", "wp248-cpt" ),
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
			"rewrite" => [ "slug" => "technologies", "with_front" => true ],
			"query_var" => true,
			"supports" => [ "title", "editor", "thumbnail" ],
		];

		register_post_type( "technologies", $args );
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

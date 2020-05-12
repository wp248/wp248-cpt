<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://wp248.com
 * @since      0.0.1
 *
 * @package    wp248_cpt
 * @subpackage wp248_cpt/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      0.0.1
 * @package    wp248_cpt
 * @subpackage wp248_cpt/includes
 * @author     wp248.com <info@wp248.com>
 */
class wp248_cpt {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    0.0.1
	 * @access   protected
	 * @var      wp248_cpt_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    0.0.1
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    0.0.1
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    0.0.1
	 */
	public function __construct() {
		if ( defined( 'WP248_CPT_VERSION' ) ) {
			$this->version = WP248_CPT_VERSION;
		} else {
			$this->version = '0.0.1';
		}
		$this->plugin_name = 'wp248-cpt';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_modules_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - wp248_cpt_Loader. Orchestrates the hooks of the plugin.
	 * - wp248_cpt_i18n. Defines internationalization functionality.
	 * - wp248_cpt_Admin. Defines all hooks for the admin area.
	 * - wp248_cpt_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    0.0.1
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once WP248_CPT_INC . 'class-wp248-cpt-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once WP248_CPT_INC . 'class-wp248-cpt-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once WP248_CPT_INC_ASSETS . 'class-wp248-cpt-public.php';

		/**
		 * Loading modules Setting first
		 */
		require_once WP248_CPT_INC_MOD . 'settings.php';

		/**
		 * Loading modules
		 */
		require_once WP248_CPT_INC_MOD . 'customers_speak.php';
		require_once WP248_CPT_INC_MOD . 'jobs.php';
		require_once WP248_CPT_INC_MOD . 'partners.php';
		require_once WP248_CPT_INC_MOD . 'portfolios.php';
		require_once WP248_CPT_INC_MOD . 'services.php';
		require_once WP248_CPT_INC_MOD . 'tech_terms.php';
		require_once WP248_CPT_INC_MOD . 'technologies.php';


		$this->loader = new wp248_cpt_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the wp248_cpt_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    0.0.1
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new wp248_cpt_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}



	/**
	 * Register all of the hooks related to the modules and admin area functionality
	 * of the plugin.
	 *
	 * @since    0.0.1
	 * @access   private
	 */
	private function define_modules_hooks() {

		/** Modules setting  */
		$plugin_module_setting = new cpt_settings($this->get_plugin_name(), $this->get_version());
		$this->loader->add_action( 'admin_menu', $plugin_module_setting, 'add_action_add_menu' );
		$this->loader->add_action( 'admin_init', $plugin_module_setting, 'add_action_admin_init' );

		/** Modules setup */
		$plugin_module_customers_speak = new cpt_customers_speak($this->get_plugin_name(), $this->get_version());
		$plugin_module_jobs = new cpt_jobs($this->get_plugin_name(), $this->get_version());
		$plugin_module_partners = new cpt_partners($this->get_plugin_name(), $this->get_version());
		$plugin_module_portfolios = new cpt_portfolios($this->get_plugin_name(), $this->get_version());
		$plugin_module_services = new cpt_services($this->get_plugin_name(), $this->get_version());
		$plugin_module_tech_terms = new cpt_tech_terms($this->get_plugin_name(), $this->get_version());
		$plugin_module_technologies = new cpt_technologies($this->get_plugin_name(), $this->get_version());

		/** Activate only if enabled */
		if ($plugin_module_setting->is_module_enable('customers_speak'))
		{
			$this->loader->add_action('admin_enqueue_scripts', $plugin_module_customers_speak, 'enqueue_styles');
			$this->loader->add_action('admin_enqueue_scripts', $plugin_module_customers_speak, 'enqueue_scripts');
			/** Module hooks actions */
			$this->loader->add_action('init', $plugin_module_customers_speak, 'module_actions_init');
			$this->loader->add_action( 'admin_init', $plugin_module_customers_speak, 'add_action_admin_init' );
			$this->loader->add_action( 'admin_menu', $plugin_module_customers_speak, 'add_action_add_menu' );
		}

		/** Activate only if enabled */
		if ($plugin_module_setting->is_module_enable('jobs'))
		{
			$this->loader->add_action('admin_enqueue_scripts', $plugin_module_jobs, 'enqueue_styles');
			$this->loader->add_action('admin_enqueue_scripts', $plugin_module_jobs, 'enqueue_scripts');
			/** Module hooks actions */
			$this->loader->add_action('init', $plugin_module_jobs, 'module_actions_init');
			$this->loader->add_action( 'admin_init', $plugin_module_jobs, 'add_action_admin_init' );
			$this->loader->add_action( 'admin_menu', $plugin_module_jobs, 'add_action_add_menu' );
		}

		/** Activate only if enabled */
		if ($plugin_module_setting->is_module_enable('partners'))
		{
			$this->loader->add_action('admin_enqueue_scripts', $plugin_module_partners, 'enqueue_styles');
			$this->loader->add_action('admin_enqueue_scripts', $plugin_module_partners, 'enqueue_scripts');
			/** Module hooks actions */
			$this->loader->add_action('init', $plugin_module_partners, 'module_actions_init');
			$this->loader->add_action( 'admin_init', $plugin_module_partners, 'add_action_admin_init' );
			$this->loader->add_action( 'admin_menu', $plugin_module_partners, 'add_action_add_menu' );
		}

		/** Activate only if enabled */
		if ($plugin_module_setting->is_module_enable('portfolios'))
		{
			$this->loader->add_action('admin_enqueue_scripts', $plugin_module_portfolios, 'enqueue_styles');
			$this->loader->add_action('admin_enqueue_scripts', $plugin_module_portfolios, 'enqueue_scripts');
			/** Module hooks actions */
			$this->loader->add_action('init', $plugin_module_portfolios, 'module_actions_init');
			$this->loader->add_action( 'admin_init', $plugin_module_portfolios, 'add_action_admin_init' );
			$this->loader->add_action( 'admin_menu', $plugin_module_portfolios, 'add_action_add_menu' );
		}

		/** Activate only if enabled */
		if ($plugin_module_setting->is_module_enable('services'))
		{
			$this->loader->add_action('admin_enqueue_scripts', $plugin_module_services, 'enqueue_styles');
			$this->loader->add_action('admin_enqueue_scripts', $plugin_module_services, 'enqueue_scripts');
			/** Module hooks actions */
			$this->loader->add_action('init', $plugin_module_services, 'module_actions_init');
			$this->loader->add_action( 'admin_init', $plugin_module_services, 'add_action_admin_init' );
			$this->loader->add_action( 'admin_menu', $plugin_module_services, 'add_action_add_menu' );
		}

		/** Activate only if enabled */
		if ($plugin_module_setting->is_module_enable('tech_terms'))
		{
			$this->loader->add_action('admin_enqueue_scripts', $plugin_module_tech_terms, 'enqueue_styles');
			$this->loader->add_action('admin_enqueue_scripts', $plugin_module_tech_terms, 'enqueue_scripts');
			/** Module hooks actions */
			$this->loader->add_action('init', $plugin_module_tech_terms, 'module_actions_init');
			$this->loader->add_action( 'admin_init', $plugin_module_tech_terms, 'add_action_admin_init' );
			$this->loader->add_action( 'admin_menu', $plugin_module_tech_terms, 'add_action_add_menu' );
		}

		/** Activate only if enabled */
		if ($plugin_module_setting->is_module_enable('technologies'))
		{
			$this->loader->add_action('admin_enqueue_scripts', $plugin_module_technologies, 'enqueue_styles');
			$this->loader->add_action('admin_enqueue_scripts', $plugin_module_technologies, 'enqueue_scripts');
			/** Module hooks actions */
			$this->loader->add_action('init', $plugin_module_technologies, 'module_actions_init');
			$this->loader->add_action( 'admin_init', $plugin_module_technologies, 'add_action_admin_init' );
			$this->loader->add_action( 'admin_menu', $plugin_module_technologies, 'add_action_add_menu' );
		}
		/**
		echo("<HR>");
		echo("WP248_CPT_VERSION[".WP248_CPT_VERSION."]<br/>\n");
		echo("WP248_CPT_PLUGIN[".WP248_CPT_PLUGIN."]<br/>\n");
		echo("WP248_CPT_ID[".WP248_CPT_ID."]<br/>\n");

		echo("WP248_CPT_DIR[".WP248_CPT_DIR."]<br/>\n");
		echo("WP248_CPT_URL[".WP248_CPT_URL."]<br/>\n");

		echo("WP248_CPT_INC[".WP248_CPT_INC."]<br/>\n");
		echo("WP248_CPT_INC_MOD[".WP248_CPT_INC_MOD."]<br/>\n");

		echo("WP248_CPT_ADMIN[".WP248_CPT_ADMIN."]<br/>\n");
		echo("WP248_CPT_ADMIN_URL[".WP248_CPT_ADMIN_URL."]<br/>\n");

		echo("WP248_CPT_PUBLIC[".WP248_CPT_PUBLIC."]<br/>\n");
		echo("WP248_CPT_PUBLIC_URL[".WP248_CPT_PUBLIC_URL."]<br/>\n");

		echo("WP248_CPT_DEF_TPL[".WP248_CPT_DEF_TPL."]<br/>\n");
		echo("WP248_CPT_DEF_TPL_URI[".WP248_CPT_DEF_TPL_URI."]<br/>\n");

		echo("WP248_CPT_TPL[".WP248_CPT_ID."]<br/>\n");
		echo("WP248_CPT_TPL_URI[".WP248_CPT_ID."]<br/>\n");

		echo("WP248_CPT_ASSETS_CSS[".WP248_CPT_ASSETS_CSS."]<br/>\n");
		echo("WP248_CPT_ASSETS_JS[".WP248_CPT_ASSETS_JS."]<br/>\n");
		echo("WP248_CPT_ASSETS_SRC[".WP248_CPT_ASSETS_SRC."]<br/>\n");
		echo("WP248_CPT_ASSETS_IMG[".WP248_CPT_ASSETS_IMG."]<br/>\n");
		echo("WP248_CPT_ASSETS_PARTIALS[".WP248_CPT_ASSETS_PARTIALS."]<br/>\n");
		echo("<HR>");
		*/
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    0.0.1
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new wp248_cpt_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    0.0.1
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     0.0.1
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     0.0.1
	 * @return    wp248_cpt_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     0.0.1
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}

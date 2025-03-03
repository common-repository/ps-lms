<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       http://www.perceptionsystem.com
 * @since      1.0.0
 *
 * @package    Ps_lms
 * @subpackage Ps_lms/includes
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
 * @since      1.0.0
 * @package    Ps_lms
 * @subpackage Ps_lms/includes
 * @author     Ps Developer <soyab.sumra@perceptionsystem.com>
 */
class Ps_lms {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Ps_lms_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
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
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'PS_LMS_VERSION' ) ) {
			$this->version = PS_LMS_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'ps_lms';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Ps_lms_Loader. Orchestrates the hooks of the plugin.
	 * - Ps_lms_i18n. Defines internationalization functionality.
	 * - Ps_lms_Admin. Defines all hooks for the admin area.
	 * - Ps_lms_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-ps_lms-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-ps_lms-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-ps_lms-admin.php';
		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-ps_lms-public.php';
		$this->loader = new Ps_lms_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Ps_lms_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Ps_lms_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {
		$plugin_admin = new Ps_lms_Admin( $this->get_plugin_name(), $this->get_version() );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'psys_create_admin_menu' );
		$this->loader->add_action( 'init', $plugin_admin, 'psys_course_post_type' );
		$this->loader->add_action( 'init', $plugin_admin, 'psys_register_post_type' );
		$this->loader->add_action( 'init', $plugin_admin, 'psys_register_teacher_post_type' );
		$this->loader->add_action( 'init', $plugin_admin, 'psys_course_category' );
		$this->loader->add_action( 'add_meta_boxes', $plugin_admin, 'psys_add_meta_box' );
		$this->loader->add_action( 'add_meta_boxes', $plugin_admin, 'psys_add_course_meta_box' );
		$this->loader->add_action( 'add_meta_boxes', $plugin_admin, 'psys_remove_category_meta_box' );
		
		$this->loader->add_action( 'save_post', $plugin_admin, 'psys_save_meta_box_data' );
		$this->loader->add_action( 'save_post', $plugin_admin, 'psys_course_save_meta_box_data' );
		
		$this->loader->add_action( 'admin_init', $plugin_admin, 'psys_register_settings' );
		$this->loader->add_filter( 'post_updated_messages', $plugin_admin, 'psys_course_messages' );
		$this->loader->add_filter( 'post_updated_messages', $plugin_admin, 'psys_lesson_messages' );
		$this->loader->add_filter( 'post_updated_messages', $plugin_admin, 'psys_teacher_messages' );
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Ps_lms_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
		$this->loader->add_action( 'wp_head', $plugin_public, 'psys_custom_styling' );
		$this->loader->add_filter( 'template_include', $plugin_public, 'psys_single_lesson_page_template',99 );
		$this->loader->add_filter( 'template_include', $plugin_public, 'psys_archive_course_page_template',99 );
		$this->loader->add_filter( 'template_include', $plugin_public, 'psys_archive_teacher_page_template',99 );
		$this->loader->add_filter( 'template_include', $plugin_public, 'psys_single_course_page_template',99 );
		$this->loader->add_filter( 'template_include', $plugin_public, 'psys_single_teacher_page_template',99 );
		$this->loader->add_filter( 'template_include', $plugin_public, 'psys_course_category_page_template',99 );
		$this->loader->add_shortcode( 'psys_courses', $plugin_public, 'psys_register_shortcodes' );
		
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Ps_lms_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}

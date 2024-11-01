<?php
if( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Wb_Widget_Builder
 * @subpackage Wb_Widget_Builder/includes
 */
require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-wb-widget-builder-helper.php';
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
 * @package    Wb_Widget_Builder
 * @subpackage Wb_Widget_Builder/includes
 * @author     Your Name <email@example.com>
 */
class Wb_Widget_Builder {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Wb_Widget_Builder_Loader    $loader    Maintains and registers all hooks for the plugin.
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
		if ( defined( 'PLUGIN_NAME_VERSION' ) ) {
			$this->version = PLUGIN_NAME_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'wb-widget-builder';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->register_plugin_post_type();
		$this->registerWidgets();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Wb_Widget_Builder_Loader. Orchestrates the hooks of the plugin.
	 * - Wb_Widget_Builder_i18n. Defines internationalization functionality.
	 * - Wb_Widget_Builder_Admin. Defines all hooks for the admin area.
	 * - Wb_Widget_Builder_Public. Defines all hooks for the public side of the site.
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
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-wb-widget-builder-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-wb-widget-builder-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-wb-widget-builder-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		
		$this->loader = new Wb_Widget_Builder_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Wb_Widget_Builder_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Wb_Widget_Builder_i18n();

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

		$plugin_admin = new Wb_Widget_Builder_Admin( $this->get_Wb_Widget_Builder(), $this->get_version() );
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'menu_setup' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

	}

	

	/**
	 * Register plugin post type
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function register_plugin_post_type() {
		add_action( 'init', [$this, 'registerWbPostType'] );
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
	public function get_Wb_Widget_Builder() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Wb_Widget_Builder_Loader    Orchestrates the hooks of the plugin.
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


	public function registerWbPostType(){
		/**
		 * Register a wb-widget post type.
		 */
		$plugin_admin = new Wb_Widget_Builder_Admin( $this->get_Wb_Widget_Builder(), $this->get_version() );
		
		$args = array(
			'labels'			=> array(
			    'name'					=> __( 'Widgets', 'wb' ),
				'singular_name'			=> __( 'Widget', 'wb' ),
			    'add_new'				=> __( 'Add New' , 'wb' ),
			    'add_new_item'			=> __( 'Add New Widget' , 'wb' ),
			    'edit_item'				=> __( 'Edit Widget' , 'wb' ),
			    'new_item'				=> __( 'New Widget' , 'wb' ),
			    'view_item'				=> __( 'View Widget', 'wb' ),
			    'search_items'			=> __( 'Search Widget', 'wb' ),
			    'not_found'				=> __( 'No Widgets found', 'wb' ),
			    'not_found_in_trash'	=> __( 'No Widgets found in Trash', 'wb' ), 
			),
			'public'			=> false,
			'hierarchical'		=> true,
			'show_ui'			=> true,
			'show_in_menu'		=> false,
			'_builtin'			=> false,
			'capability_type'	=> 'post',
			/*'capabilities'		=> array(
				'edit_post'			=> $cap,
				'delete_post'		=> $cap,
				'edit_posts'		=> $cap,
				'delete_posts'		=> $cap,
			),*/
			'supports' 			=> array('title'),
			'rewrite'			=> false,
			'query_var'			=> false,
			'register_meta_box_cb' => [$plugin_admin,'wb_meta_box']
		);
	    register_post_type( 'wb-widget', $args );

	}

	private function registerWidgets() {
		add_action( 'widgets_init', [$this, 'initWidgets'] );
	}

	public function initWidgets(){
		/**
		 * Register a wb-widgets.
		 */
		$wb_widgets = getWidgets();
		if($wb_widgets->have_posts()):
			while($wb_widgets->have_posts()): $wb_widgets->the_post();
				$cname = ucfirst(str_replace('-', '', get_post_field( "post_name" )));
				$form = htmlspecialchars_decode(get_post_meta( get_the_ID(), '_wb_form', true ));
				$update_logic = htmlspecialchars_decode(get_post_meta( get_the_ID(), '_wb_update_logic', true ));
				$frontend = htmlspecialchars_decode(get_post_meta( get_the_ID(), '_wb_frontend', true ));
				$helper_functions = (trim(get_post_meta( get_the_ID(), '_wb_helper_functions', true )))."";
				if(substr($helper_functions, 0, 8) == "&lt;?php"){
					$helper_functions = substr($helper_functions,8);
				}
				if(substr($helper_functions, strlen($helper_functions)-5, strlen($helper_functions)) == "?&gt;"){
					$helper_functions = substr($helper_functions, 0, -5);
				}

				$helper_functions = htmlspecialchars_decode($helper_functions);
				if(!empty($cname)){
					try{

						require plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-wb-widget-builder-widget-template.php';	

					}catch (ParseError $e) {
					    // Report error somehow
					   wb_push_notice($e->getMessage(), "error", $e->getLine(), get_the_title());
					}

					//register widgets
					if(!empty($cname) && class_exists($cname)){
						register_widget( $cname );
					}
				}
				
			endwhile;
			wp_reset_postdata();
		endif;
	}


}



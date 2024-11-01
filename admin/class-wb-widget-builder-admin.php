<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Wb_Widget_Builder
 * @subpackage Wb_Widget_Builder/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Wb_Widget_Builder
 * @subpackage Wb_Widget_Builder/admin
 * @author     Your Name <email@example.com>
 */

class Wb_Widget_Builder_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	private $page;
	public function __construct( $plugin_name, $version ) {
		global $wpdb, $typenow;
		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->page = isset($_GET['page'])? $_GET['page']: "";
		add_action( 'add_meta_boxes_book', [$this, 'wb_meta_box'] );
		add_action( 'save_post', [$this,'save_wb_meta_box_data'] );

	}

	public function menu_setup(){
		$slug = 'edit.php?post_type=wb-widget';
		$cap = 'manage_options';
		
		// Add menu items.
		add_menu_page( __("Widget Builder",'wb'), __("Widget Builder",'wb'), $cap, $slug, false, 'dashicons-welcome-widgets-menus', '80.025' );
		add_submenu_page( $slug, __('Widgets','wb'), __('Widgets','wb'), $cap, $slug );
		add_submenu_page( $slug, __('Add New','wb'), __('Add New','wb'), $cap, 'post-new.php?post_type=wb-widget' );
		
		//add_submenu_page($slug, __('Tools','wb'), __('Tools','wb'), $cap, 'wb-tools', array($this, 'html'));

	}
	public function html() {
		?>
		<h1>Tools</h1>
		<?php
		
	}
	

	public function checSpecialChar($string){
		if(!preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬ ]/', $string)){
			return true;
		}
		else{
			return false;
		}
	}
	/**
	 * Register the stylesheets for the Dashboard.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles($hook) {
		//wp_die($hook);
		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wb_Widget_Builder_Admin_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wb_Widget_Builder_Admin_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		global $typenow;
		//var_dump(get_admin_page_title() == "Widgets");
		if($typenow == 'wb-widget') {
           // wp_enqueue_style( 'datatables', plugin_dir_url( __FILE__ ) . 'js/DataTables/datatables.min.css', array( ), $this->version, false );
			wp_enqueue_style( 'bootstrap', 'https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css', array(), $this->version, false );

			wp_enqueue_style( 'formio', plugin_dir_url( __FILE__ ) . 'assets/plugins/formio/formio.full.min.css', array(), $this->version, false );



            wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'assets/css/wb-widget-builder-admin.css', array(), $this->version, 'all' );
        }
        if( get_admin_page_title() == "Widgets"){
        	wp_enqueue_style( 'formio', plugin_dir_url( __FILE__ ) . 'assets/plugins/formio/formio.full.min.css', array(), $this->version, false );
        	//var_dump("lib loaded");
        }
        
	}

	/**
	 * Register the JavaScript for the dashboard.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts($hook) {
		//var_dump("enque script");
		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wb_Widget_Builder_Admin_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wb_Widget_Builder_Admin_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		global $typenow;
		if($typenow == 'wb-widget') {
			wp_enqueue_script( 'formio', plugin_dir_url( __FILE__ ) . 'assets/plugins/formio/formio.full.min.js', array( ), $this->version, false );
			wp_enqueue_script( 'popper', plugin_dir_url( __FILE__ ) . 'assets/plugins/popper.min.js', array(), $this->version, false );
			wp_enqueue_script( 'tippy', plugin_dir_url( __FILE__ ) . 'assets/plugins/tippy-bundle.umd.min.js', array(), $this->version, false );
			wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'assets/js/wb-widget-builder-admin.js', array( 'jquery'), $this->version, false );
			if($this->page = ""){

			}
        }
        if( get_admin_page_title() == "Widgets"){
        	wp_enqueue_script( 'formio', plugin_dir_url( __FILE__ ) . 'assets/plugins/formio/formio.full.min.js', array( ), $this->version, false );
        }
        
		

	}

	//meta box

	function wb_meta_box() {

		add_meta_box(
		    'global-notice',
		    __( 'Widget Form', 'wb' ),
		    [$this,'wb_meta_box_callback']
		);
	}
    function wb_meta_box_callback( $post ) {

	    // Add a nonce field so we can check for it later.
	    wp_nonce_field( 'wb_nonce', 'wb_nonce' );

	    include_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/wb-widget-builder-admin-cf.php'; 
	}

		/**
	 * When the post is saved, saves our custom data.
	 *
	 * @param int $post_id
	 */
	function save_wb_meta_box_data( $post_id ) {

	    // Check if our nonce is set.
	    if ( ! isset( $_POST['wb_nonce'] ) ) {
	        return;
	    }

	    // Verify that the nonce is valid.
	    if ( ! wp_verify_nonce( $_POST['wb_nonce'], 'wb_nonce' ) ) {
	        return;
	    }

	    // If this is an autosave, our form has not been submitted, so we don't want to do anything.
	    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
	        return;
	    }

	    // Check the user's permissions.
	    if ( isset( $_POST['post_type'] ) && 'page' == $_POST['post_type'] ) {

	        if ( ! current_user_can( 'edit_page', $post_id ) ) {
	            return;
	        }

	    }
	    else {

	        if ( ! current_user_can( 'edit_post', $post_id ) ) {
	            return;
	        }
	    }

	    /* OK, it's safe for us to save the data now. */

	    // Make sure that it is set.
	    /*if ( ! isset( $_POST['wb_form'] ) ) {
	        return;
	    }*/

	    // Sanitize user input.
	    $form_data = ( htmlspecialchars($_POST['wb_form']) );
	    $logic = ( htmlspecialchars($_POST['wb_update_logic']) );
	    $frontend = ( htmlspecialchars($_POST['wb_frontend']) );
	    $helper_functions = ( htmlspecialchars($_POST['wb_helper_functions']) );

	    // Update the meta field in the database.
	    update_post_meta( $post_id, '_wb_form', $form_data );
	    update_post_meta( $post_id, '_wb_update_logic', $logic );
	    update_post_meta( $post_id, '_wb_frontend', $frontend );
	    update_post_meta( $post_id, '_wb_helper_functions', $helper_functions );
	}

	

}

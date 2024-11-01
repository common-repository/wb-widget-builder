<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://example.com
 * @since             1.0.0
 * @package           Wb_Widget_Builder
 *
 * @wordpress-plugin
 * Plugin Name:       Wb Widget Builder
 * Plugin URI:        http://kishorkhambu.com.np/wp/widget-builder
 * Description:       Widget bulder is a wordpress plugin to build new widgets easily with minimal coding.
 * Version:           1.0.0
 * Author:            Kishor Khambu
 * Author URI:        http://kishorkhambu.com.np
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wb-widget-builder
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'PLUGIN_NAME_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-wb-widget-builder-activator.php
 */
function activate_Wb_Widget_Builder() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wb-widget-builder-activator.php';
	Wb_Widget_Builder_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-wb-widget-builder-deactivator.php
 */
function deactivate_Wb_Widget_Builder() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wb-widget-builder-deactivator.php';
	Wb_Widget_Builder_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_Wb_Widget_Builder' );
register_deactivation_hook( __FILE__, 'deactivate_Wb_Widget_Builder' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-wb-widget-builder.php';
/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_Wb_Widget_Builder() {

	$plugin = new Wb_Widget_Builder();
	$plugin->run();
	

}

run_Wb_Widget_Builder();

$Wb_Widget_Builder_messages = [];
/**
 * [wb_push_notice description]
 * @param  [type] $message     [description]
 * @param  [type] $notice_type [description]
 * @return [type]              [description]
 */
function wb_push_notice($message, $notice_type, $line_no = null, $title= "") {
    global $Wb_Widget_Builder_messages;
    $notice_class = "notice ";

    switch($notice_type){
        case 'error':
            $notice_class .= "notice-error";
        break;

        case 'warning':
            $notice_class .= "notice-warning";
        break;

        case 'success':
            $notice_class .= "notice-notice-error";
        break;

        case 'info':
            $notice_class .= "notice-info";
        break;
    }
    if(isset($line_no)){
        switch($line_no){
            case 60:
                $message = "<b>Error in Backend form:</b> ". $message;
            break;

            case 90:
                $message = "<b>Error in Backend update logic:</b> ". $message;
            break;

            case 30:
                $message = "<b>Error in Frontend display:</b> ". $message;
            break;
            default:
                $message = "<b>Error in Widget ".$title.":</b> ". $message;
            break;
        }
    }
    
    array_push($Wb_Widget_Builder_messages, ['message'=> $message, 'el_class' => $notice_class]);
    
}

function Wb_Widget_Builder_notice() {
    global $Wb_Widget_Builder_messages;
    foreach($Wb_Widget_Builder_messages as $msg){

    ?>
    <div class="<?php echo $msg['el_class']; ?> is-dismissible">
        <p><?php _e( $msg['message'], 'Wb_Widget_Builder' ); ?></p>
    </div>
    <?php
    }
}
add_action( 'admin_notices', 'Wb_Widget_Builder_notice' );

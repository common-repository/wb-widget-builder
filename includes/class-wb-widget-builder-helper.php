<?php 
function getWidgets(){
	$args = array(
	    'post_type' => 'wb-widget',
	    'post_status' => 'publish'
	);
	return new WP_Query( $args );
}
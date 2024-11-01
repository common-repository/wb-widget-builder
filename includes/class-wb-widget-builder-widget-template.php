<?php


//$wb_widgets; is wp_query object. must define before including this file

eval("
    class $cname extends WP_Widget {
        /**
         * Constructs the new widget.
         *
         * @see WP_Widget::__construct()
         */
        function __construct() {
            global \$post;
            // Instantiate the parent object.
            parent::__construct(
            \$post->post_name, // Base ID
            __( get_the_title(), 'wb_widget' ), // Name
            array( 'description' => __( 'Custom Widget', 'wb_widget' ), ) // Args
        );
        }
        
        /**
         * Front-end display of widget.
         *
         * @see WP_Widget::widget()
         *
         * @param array \$args     Widget arguments.
         * @param array \$instance Saved values from database.
         */
        public function widget( \$args, \$instance ) {
           ?>
            $frontend
            <?php
            
        }
     
        /**
         * Back-end widget form.
         *
         * @see WP_Widget::form()
         *
         * @param array \$instance Previously saved values from database.
         */
        public function form( \$instance ) {
            ?>
            $form
            <?php
        }
     
        /**
         * Sanitize widget form values as they are saved.
         *
         * @see WP_Widget::update()
         *
         * @param array \$new_instance Values just sent to be saved.
         * @param array \$old_instance Previously saved values from database.
         *
         * @return array Updated safe values to be saved.
         */
        public function update( \$new_instance, \$old_instance ) {
            \$instance = array();
            ?>
            $update_logic
            <?php
            return \$instance;
        }
        $helper_functions
    }
    ");
 
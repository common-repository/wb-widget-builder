<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Wb_Widget_Builder
 * @subpackage Wb_Widget_Builder/admin/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<?php 
$form = htmlspecialchars_decode(get_post_meta( $post->ID, '_wb_form', true ));
$logic = htmlspecialchars_decode(get_post_meta( $post->ID, '_wb_update_logic', true ));
$frontend = htmlspecialchars_decode(get_post_meta( $post->ID, '_wb_frontend', true ));
$helper_functions = htmlspecialchars_decode(get_post_meta( $post->ID, '_wb_helper_functions', true ));

?>
   
    <div class="wb-row">
        <label for="wb_form">Widget Form: </label>
        <a href="#" class="tpy" data-target="wb_form-tippy"><span style="text-align: right;">e.g.</span></a>
        <div id="wb_form-tippy" class="hidden">
            <pre style="color: #fff;"><code>
         <?php
                $hint = "
<?php
\$title = isset( \$instance[ 'title' ] )? \$instance[ 'title' ] : __( 'New title', 'text_domain' );
\$description = isset( \$instance[ 'description' ] )? \$instance[ 'description' ] : __( 'Widget description', 'text_domain' );
?>
<p>
    <label for=\"<?php echo \$this->get_field_name( 'title' ); ?>\"><?php _e( 'Title:' ); ?></label>
    <input class=\"widefat\" id=\"<?php echo \$this->get_field_id( 'title' ); ?>\" name=\"<?php echo \$this->get_field_name( 'title' ); ?>\" type=\"text\" value=\"<?php echo esc_attr( \$title ); ?>\" />
 </p>
 <p>
    <label for=\"<?php echo \$this->get_field_name( 'description' ); ?>\"><?php _e( 'Description:' ); ?></label>
    <input class=\"widefat\" id=\"<?php echo \$this->get_field_id( 'description' ); ?>\" name=\"<?php echo \$this->get_field_name( 'description' ); ?>\" type=\"text\" value=\"<?php echo esc_attr( \$description ); ?>\" />
 </p>
         ";
         echo htmlspecialchars($hint);

?>
            </code></pre>
        </div>
        <textarea name="wb_form" style="width: 100%" class="ace-editor hidden"><?php echo esc_attr( $form ); ?></textarea>
        <!--<input type="hidden" id="wb_form" name="wb_form" value="">
        <div id="wb-builder"></div>-->
        <div id="backend-form" class=".ace_editor" data-target="wb_form"><?php echo !empty($form)? esc_attr( $form ): esc_attr(htmlspecialchars(trim("
<?php 
    //available parameters \$instance
    //your code here
?>
        "))); ?></div>
    </div>



    <div class="wb-row">
        <label>Widget update: </label>
        <a href="#" class="tpy" data-target="wb_update_logic-tippy"><span style="text-align: right;">e.g.</span></a>
        <div id="wb_update_logic-tippy" class="hidden">
            <pre style="color: #fff;"><code>
         <?php
                $hint = "
<?php
\$instance = array();
\$instance['title'] = ( !empty( \$new_instance['title'] ) ) ? strip_tags( \$new_instance['title'] ) : '';
\$instance['description'] = ( !empty( \$new_instance['description'] ) ) ? strip_tags( \$new_instance['description'] ) : '';
return \$instance;
?>   ";
         echo htmlspecialchars($hint);

?>
            </code></pre>
        </div>
        <textarea style="width:100%; " id="wb_update_logic" name="wb_update_logic" class="ace-editor hidden"><?php echo esc_attr( $logic ) ?></textarea>
        <div id="backend-update-logic" class=".ace_editor" data-target="wb_update_logic"><?php echo !empty($logic)? esc_attr( $logic ): esc_attr(htmlspecialchars(trim("
<?php 
    //available parameters \$new_instance & \$old_instance
    //your code here
?>
        "))); ?></div>
    </div>



    <div class="wb-row">
        <label>Widget display:</label>
        <a href="#" class="tpy" data-target="wb_frontend-tippy"><span style="text-align: right;">e.g.</span></a>
        <div id="wb_frontend-tippy" class="hidden">
            <pre style="color: #fff;"><code>
         <?php
                $hint = "
<?php
extract( \$args );
\$title = apply_filters( 'widget_title', \$instance['title'] );
\$description =  \$instance['description'] ;
echo \$before_widget;
if ( ! empty( \$title ) ) {
    echo \$before_title . \$title . \$after_title;
}
echo __( \$description, 'text_domain' );
echo \$after_widget;
?>
         ";
         echo htmlspecialchars($hint);

?>
            </code></pre>
        </div>
        <textarea style="width:100%; " id="wb_frontend" name="wb_frontend" class="ace-editor hidden"><?php echo esc_attr( $frontend ) ?></textarea>
        <div id="frontend" class=".ace_editor" data-target="wb_frontend"><?php echo !empty($frontend)? esc_attr( $frontend ): esc_attr(htmlspecialchars(trim("
<?php 
    //available parameters \$args & \$instance
    //your code here
?>
        "))); ?></div>
    </div>


    <div class="wb-row">
        <label>Widget Helper Functions:</label>
        <a href="#" class="tpy" data-target="wb_helper_functions-tippy"><span style="text-align: right;">e.g.</span></a>
        <div id="wb_helper_functions-tippy" class="hidden">
            <pre style="color: #fff;"><code>
         <?php
                $hint = "
<?php
// call this fuction like \$this->sayHello();
function sayHello(){
    return \"Hello World\";
}
?>
         ";
         echo htmlspecialchars($hint);

?>
            </code></pre>
        </div>
        <textarea style="width:100%; " id="wb_helper_functions" name="wb_helper_functions" class="ace-editor hidden"><?php echo esc_attr( $helper_functions ) ?></textarea>
        <div id="helper-functions" class=".ace_editor" data-target="wb_helper_functions"><?php echo !empty($helper_functions)? esc_attr( $helper_functions ): esc_attr(htmlspecialchars(trim("
<?php 
    //your functions here
?>
        "))); ?></div>
    </div>


    <script src="<?php echo plugin_dir_url( __FILE__ ) ?>../assets/plugins/ace-editor/src-min/ace.js"></script>
    <script src="<?php echo plugin_dir_url( __FILE__ ) ?>../assets/plugins/ace-editor/src-min/snippets/php.js"></script>
    <script src="<?php echo plugin_dir_url( __FILE__ ) ?>../assets/plugins/ace-editor/src-min/mode-php.js" ></script>
    <script src="<?php echo plugin_dir_url( __FILE__ ) ?>../assets/plugins/ace-editor/src-min/worker-php.js" ></script>

    <script src="<?php echo plugin_dir_url( __FILE__ ) ?>../assets/plugins/ace-editor/src-min/theme-twilight.js" ></script>

    <script type="text/javascript">
        var typingTimer;                //timer identifier
        var doneTypingInterval = 1000;
        (function($){
            $(document).ready(function(){
               initEditor('backend-form', $('#backend-form').data('target')); 
               initEditor('backend-update-logic', $('#backend-update-logic').data('target')); 
               initEditor('frontend', $('#frontend').data('target'));
               initEditor('helper-functions', $('#helper-functions').data('target')); 
               $('.tpy').on('click', function(e){
                e.preventDefault();
               })
               tippy('.tpy', {
                  allowHTML: true,
                  interactive: true,
                  content: function(e){
                    return $("#"+$(e).data('target')).html();
                  },
                  trigger: 'click',
                });
            });
            
        })(jQuery)
        function initEditor(id, target){
            var editor = ace.edit(id);
            editor.setTheme("ace/theme/twilight");
            var phpMode = ace.require("ace/mode/php").Mode;
            editor.session.setMode(new phpMode());
            editor.session.on('change', function(delta) {
                // delta.start, delta.end, delta.lines, delta.action
                clearTimeout(typingTimer);
                typingTimer = setTimeout(doneTyping.bind(null,editor.getValue(), target), doneTypingInterval);
                
            }); 
        }
        function doneTyping (value, target) {
          //do something
          jQuery('[name="'+target+'"]').val(value);
        }
    </script>
    
<?php 
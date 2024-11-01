(function( $ ) {
	'use strict';

	/**
	 * All of the code for your admin-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */
  
	$(window).load(function(){
    if(!wp_widget_form_data) var wp_widget_form_data = {};
    Formio.builder(document.getElementById('wb-builder'), wp_widget_form_data , {
	 	  noDefaultSubmitButton: true,
          builder: {
            basic: false,
            advanced: false,
            layout: false,
            premium: false,
            data: false,

            customBasic: {
              title: 'Components',
              default: true,
              weight: 0,
              components: {
                textfield: true,
                textarea: true,
                //email: true,
                //phoneNumber: true,
                select: true
              }

            },

            /*custom: {
              title: 'User Fields',
              weight: 10,
              components: {
                firstName: {
                  title: 'First Name',
                  key: 'firstName',
                  icon: 'terminal',
                  schema: {
                    label: 'First Name',
                    type: 'textfield',
                    key: 'firstName',
                    input: true
                  }
                },
                lastName: {
                  title: 'Last Name',
                  key: 'lastName',
                  icon: 'terminal',
                  schema: {
                    label: 'Last Name',
                    type: 'textfield',
                    key: 'lastName',
                    input: true
                  }
                },
                email: {
                  title: 'Email',
                  key: 'email',
                  icon: 'at',
                  schema: {
                    label: 'Email',
                    type: 'email',
                    key: 'email',
                    input: true
                  }
                },
                phoneNumber: {
                  title: 'Mobile Phone',
                  key: 'mobilePhone',
                  icon: 'phone-square',
                  schema: {
                    label: 'Mobile Phone',
                    type: 'phoneNumber',
                    key: 'mobilePhone',
                    input: true
                  }
                }
              }
            },*/
            /*layout: {
              components: {
                table: false
              }
            }*/
          },
          editForm: {
            textfield: [
              {
                key: 'api',
                ignore: false
              } ,
              {
                key: 'layout',
                ignore: true
              } ,
              {
                key: 'logic',
                ignore: true
              },
              {
                key: 'data',
                ignore: true
              }          
            ],
            email: [
              {
                key: 'api',
                ignore: false
              } ,
              {
                key: 'layout',
                ignore: true
              } ,
              {
                key: 'logic',
                ignore: true
              },
              {
                key: 'data',
                ignore: true
              }          
            ],
            textarea: [
              {
                key: 'api',
                ignore: false
              } ,
              {
                key: 'layout',
                ignore: true
              } ,
              {
                key: 'logic',
                ignore: true
              },
              {
                key: 'data',
                ignore: true
              }          
            ],
            select: [
              {
                key: 'api',
                ignore: false
              } ,
              {
                key: 'layout',
                ignore: true
              } ,
              {
                key: 'logic',
                ignore: true
              },
              {
                key: 'data',
                ignore: true
              }          
            ]
          }
        }).then(function(builder) {
          builder.on('saveComponent', function() {
             var form_data = JSON.stringify(builder.schema);
            $('#wb_builder_form').val(form_data);
            console.log(builder.schema);
          });
        });
    });

})( jQuery );

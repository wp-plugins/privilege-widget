<?php
/**
 * Plugin Name: Privilege Widget
 * Plugin URI: http://www.fuzzguard.com.au/plugins/privilege-widget
 * Description: Used to provide Widget display to users based on their Privilege Level (Currently only either logged in/logged out)
 * Version: 1.4.1
 * Author: Benjamin Guy
 * Author URI: http://www.fuzzguard.com.au
 * Text Domain: privilege-widget
 * License: GPL2

    Copyright 2014  Benjamin Guy  (email: beng@fuzzguard.com.au)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA

*/


/**
* Don't display if wordpress admin class is not found
* Protects code if wordpress breaks
* @since 0.1
*/
if ( ! function_exists( 'is_admin' ) ) {
    header( 'Status: 403 Forbidden' );
    header( 'HTTP/1.1 403 Forbidden' );
    exit();
}

class privWidget {

        /**
        * Loads localization files for each language
        * @since 1.4
        */
        function _action_init()
        {
                // Localization
                load_plugin_textdomain('privilege-widget', false, 'privilege-widget/lang/');
        }


function privilege_widget_form_extend( $t, $return, $instance ) {

		
	$privWidget_id = $t->id;
	$logged_in_out = get_option($privWidget_id.'_priv_widget');
?>

                <input type="hidden" name="priv-widget-nonce" value="<?php echo wp_create_nonce( 'priv-widget-nonce-name' ); ?>" />
                <div class="field-priv_widget_role priv_widget_logged_in_out_field description-wide" style="margin: 10px 0px; padding: 5px 0px; overflow: hidden; border-bottom: 1px solid #DDDDDD; border-top: 1px solid #DDDDDD;">
                    <span class="description"><?php _e( "User Restrictions", 'privilege-widget' ); ?></span>
                    <br /> <br />

                    <input type="hidden" class="widget-id" value="<?php echo $privWidget_id ;?>" />

                    <div class="logged-input-holder" style="float: left; width: 35%;">
                        <input type="radio" class="widget-logged-in-out" name="priv-widget-logged-in-out[<?php echo $privWidget_id ;?>]" id="priv_widget_logged_out-for-<?php echo $privWidget_id ;?>" <?php checked( 'admin', $logged_in_out ); ?> value="admin" />
                        <label for="priv_widget_admin_user-for-<?php echo $privWidget_id ;?>">
                            <?php _e( 'Admin Users', 'privilege-widget'); ?>
                        </label>
                    </div>

                    <div class="logged-input-holder" style="float: left; width: 35%;">
                        <input type="radio" class="widget-logged-in-out" name="priv-widget-logged-in-out[<?php echo $privWidget_id ;?>]" id="priv_widget_logged_out-for-<?php echo $privWidget_id ;?>" <?php checked( 'out', $logged_in_out ); ?> value="out" />
                        <label for="priv_widget_logged_out-for-<?php echo $privWidget_id ;?>">
                            <?php _e( 'Logged Out Users', 'privilege-widget'); ?>
                        </label>
                    </div>

                    <div class="logged-input-holder" style="float: left; width: 35%;">
                        <input type="radio" class="widget-logged-in-out" name="priv-widget-logged-in-out[<?php echo $privWidget_id ;?>]" id="priv_widget_logged_in-for-<?php echo $privWidget_id ;?>" <?php checked( 'in', $logged_in_out ); ?> value="in" />
                        <label for="priv_widget_logged_in-for-<?php echo $privWidget_id ;?>">
                            <?php _e( 'Logged In Users', 'privilege-widget'); ?>
                        </label>
                    </div>

                    <div class="logged-input-holder" style="float: left; width: 30%;">
                        <input type="radio" class="widget-logged-in-out" name="priv-widget-logged-in-out[<?php echo $privWidget_id ;?>]" id="priv_widget_by_role-for-<?php echo $privWidget_id ;?>" <?php checked( '', $logged_in_out ); ?> value="" />
                        <label for="priv_widget_by_role-for-<?php echo $privWidget_id ;?>">
                            <?php _e( 'All Users', 'privilege-widget'); ?>
                        </label>
                    </div>

                </div>

<?php
		$return = null;
		return array($t,$return,$instance);
	}

/**
* Save the data returned from the users browser in the database
* @since 0.1
* @updated 1.2
*/
function privilege_widget_update($instance, $new_instance, $old_instance) {
       	$opt_arr = $_POST['priv-widget-logged-in-out'];
	if (!empty($opt_arr)) {
		foreach ($opt_arr as $key => $value) {

        		if ( !empty($value) ) {
				// Save the posted value in the database
            			update_option( $key.'_priv_widget', $value );
        		} else {
				// Remove if option has no value when posted
            			delete_option( $key.'_priv_widget' );
       			 }
		}
	}

	return $instance;
}


	
/**
* Modify's the widget data with the options for privilege widget
* @since 0.1
*/
function privilege_widget_filter( $widget )
{

	foreach($widget as $widget_area => $widget_list)
	{
		
		if ($widget_area=='wp_inactive_widgets' || empty($widget_list)) continue;

		foreach($widget_list as $pos => $widget_id)
		{
			$logged_in_out = get_option($widget_id.'_priv_widget');
                        switch( $logged_in_out ) {
                                case 'admin':
                                        $visible = current_user_can( 'manage_options' ) ? true : false;
                                        break;
                                case 'in' :
                                        $visible = is_user_logged_in() ? true : false;
                                        break;
                                case 'out' :
                                        $visible = ! is_user_logged_in() ? true : false;
                                        break;
                                default:
                                        $visible = true;
			}
			if ( ! $visible ) unset($widget_list[$pos]);
		}
		$widget[$widget_area] = $widget_list;
	}
    return $widget;
}

}

/**
* Define the Class
* @since 0.1
*/
$myprivWidgetClass = new privWidget();

/**
* Action of what function to call on wordpress initialization
* @since 1.4
*/
add_action('plugins_loaded', array($myprivWidgetClass, '_action_init'));

/**
* Filter of what function to call to modify the widget output before it is returned to the users browser
* @since 0.1
* @updated 1.3
*/
if (!is_admin()) {
	add_filter( 'sidebars_widgets', array($myprivWidgetClass, 'privilege_widget_filter'), 10);
}

/**
* Filter of what function to call to modify widget code
* @since 0.1
* @updated 1.3
*/
add_action('in_widget_form', array($myprivWidgetClass, 'privilege_widget_form_extend'), 5, 3);


/**
* Filter of what function to call to write returned data to the database
* @since 0.1
*/
add_filter( 'widget_update_callback', array($myprivWidgetClass, 'privilege_widget_update'), 10, 3 );

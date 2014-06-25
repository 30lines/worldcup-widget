<?php
/**
 * WorldCup Widget Plugin
 *
 * Built with help from The WordPress Widget Boilerplate by Tom McFarlin 
 * :: https://github.com/tommcfarlin/WordPress-Widget-Boilerplate
 *
 * @package   WorldCup Widget
 * @author    Eric Katz <eric@30lines.com>
 * @license   GPL-2.0+
 * @link      http://30lines.com
 * @copyright 2014 30 Lines
 *
 * @worldcup-widget
 * Plugin Name:       WorldCup Widget
 * Plugin URI:        http://30lines.com
 * Description:       
 * Version:           1.0.3
 * Author:            Eric Katz
 * Author URI:        http://ericnkatz.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * GitHub Plugin URI: https://github.com/30lines/worldcup-widget
 * 
 */

class WorldCup_Widget extends WP_Widget {

    /**
     * @since    1.0.0
     *
     * @var      string
     */
    protected $widget_slug = 'worldcup-widget';
    protected $api_key = '1c8265af34f7d6e618888652d32b20b6';


	/**
     * Return the team by searching specific identifier.
     *
     * @since    1.0.0
     *
     * @return    Team from API/Cache.
     */
	public function getTeamByIdentifier($identifier, $teamslist) {
	    foreach($teamslist as $key => $value) {
	        $current_key = $key;
	        if($identifier === $value OR (is_array($value) && $this->getTeamByIdentifier($identifier,$value) !== false)) {
	            return $current_key;
	        }
	    }
	    return false;
	}

	/**
     * Return json decoded array from API.
     *
     * @since    1.0.0
     *
     * @return    Array any API call. Default is teams list sorted alphabetically.
     */
	public function worldcup_api_call($request = 'teams', $parameters = '&sort=name') {
		$url = 'http://worldcup.kimonolabs.com/api/' . $request . '?apikey=' . $this->api_key . $parameters;

		$response = get_transient($url);

		if($response) {
			$r = json_decode($response, TRUE);
			return $r;
		}

		$response = file_get_contents($url);
		$saveForLater = set_transient($url, $response, 3 * 60);

		$r = json_decode($response, TRUE);

		return $r;
	}

    /**
     * Return the widget slug.
     *
     * @since    1.0.0
     *
     * @return    Plugin slug variable.
     */
    public function get_widget_slug() {
        return $this->widget_slug;
    }

    public function get_widget_path() {
    	return plugin_dir_path( __FILE__ );
    }
	
	public function flush_widget_cache() 
	{
    	wp_cache_delete( $this->get_widget_slug(), 'widget' );
	}


	/*--------------------------------------------------*/
	/* Public Functions
	/*--------------------------------------------------*/


	/**
	 * Fired when the plugin is activated.
	 *
	 * @param  boolean $network_wide True if WPMU superadmin uses "Network Activate" action, false if WPMU is disabled or plugin is activated on an individual blog.
	 */
	public function activate( $network_wide ) {
		// TODO define activation functionality here
	} // end activate

	/**
	 * Fired when the plugin is deactivated.
	 *
	 * @param boolean $network_wide True if WPMU superadmin uses "Network Activate" action, false if WPMU is disabled or plugin is activated on an individual blog
	 */
	public function deactivate( $network_wide ) {
		// TODO define deactivation functionality here
	} // end deactivate

	/**
	 * Registers and enqueues admin-specific styles.
	 */
	public function register_admin_styles() {

		wp_enqueue_style( $this->get_widget_slug().'-admin-styles', plugins_url( 'css/admin.css', __FILE__ ) );

	} // end register_admin_styles

	/**
	 * Registers and enqueues admin-specific JavaScript.
	 */
	public function register_admin_scripts() {

		wp_enqueue_script( $this->get_widget_slug().'-admin-script', plugins_url( 'js/admin.js', __FILE__ ), array('jquery') );

	} // end register_admin_scripts

	/**
	 * Registers and enqueues widget-specific styles.
	 */
	public function register_widget_styles() {

		wp_enqueue_style( $this->get_widget_slug().'-widget-styles', plugins_url( 'css/widget.css', __FILE__ ) );

	} // end register_widget_styles

	/**
	 * Registers and enqueues widget-specific scripts.
	 */
	public function register_widget_scripts() {

		wp_enqueue_script( $this->get_widget_slug().'-script', plugins_url( 'js/widget.js', __FILE__ ), array('jquery') );

	} // end register_widget_scripts

} // end class


// Include actual widget files
include( plugin_dir_path(__FILE__) . 'widgets/widget-main.php' );
include( plugin_dir_path(__FILE__) . 'widgets/widget-scorers.php' );

// Create the widgets
add_action( 'widgets_init', create_function( '', 'register_widget("WorldCup_Widget_Main");' ) );
add_action( 'widgets_init', create_function( '', 'register_widget("WorldCup_Widget_Scorers");' ) );

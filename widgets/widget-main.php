<?php

class WorldCup_Widget_Main extends WorldCup_Widget {

    /**
     * @since    1.0.0
     *
     * @var      string
     */

	/*--------------------------------------------------*/
	/* Constructor
	/*--------------------------------------------------*/

	/**
	 * Specifies the classname and description, instantiates the widget,
	 * loads necessary stylesheets and JavaScript.
	 */
	public function __construct() {


		register_activation_hook( __FILE__, array( $this, 'activate' ) );
		register_deactivation_hook( __FILE__, array( $this, 'deactivate' ) );

		WP_Widget::__construct(
			$this->get_widget_slug() . '-main',
			__( 'WorldCup Widget: Main', $this->get_widget_slug() ),
			array(
				'classname'  => $this->get_widget_slug().'-class',
				'description' => __( 'Adds a sidebar widget that let\'s you pick your favorite team, adjust some options and output content like team logo, group standings, record, goal count, points and upcoming schedule.', $this->get_widget_slug() )
			)
		);

		// Register admin styles and scripts
		add_action( 'admin_print_styles', array( $this, 'register_admin_styles' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'register_admin_scripts' ) );

		// Register site styles and scripts
		add_action( 'wp_enqueue_scripts', array( $this, 'register_widget_styles' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'register_widget_scripts' ) );

		// Refreshing the widget's cached output with each new post
		add_action( 'save_post',    array( $this, 'flush_widget_cache' ) );
		add_action( 'deleted_post', array( $this, 'flush_widget_cache' ) );
		add_action( 'switch_theme', array( $this, 'flush_widget_cache' ) );

	} // end constructor


	/*--------------------------------------------------*/
	/* Widget API Functions
	/*--------------------------------------------------*/

	/**
	 * Outputs the content of the widget.
	 *
	 * @param array args  The array of form elements
	 * @param array instance The current instance of the widget
	 */
	public function widget( $args, $instance ) {

		// Check if there is a cached output
		$cache = wp_cache_get( $this->get_widget_slug(), 'widget' );

		if ( !is_array( $cache ) )
			$cache = array();

		if ( ! isset ( $args['widget_id'] ) )
			$args['widget_id'] = $this->id;

		if ( isset ( $cache[ $args['widget_id'] ] ) )
			return print $cache[ $args['widget_id'] ];
		
		// go on with your widget logic, put everything into a string and …
		extract( $args, EXTR_SKIP );

		$widget_string = $before_widget;

		$selected_team 	= empty($instance['selected_team']) ? '' : apply_filters('selected_team', $instance['selected_team']);
		$theme 			= empty($instance['theme']) ? '' : apply_filters('theme', $instance['theme']);
		$show_matches 	= empty($instance['show_matches']) ? '' : apply_filters('show_matches', $instance['show_matches']);

		// TODO: Here is where you manipulate your widget's values based on their input fields
		ob_start();
		include( $this->get_widget_path() . 'views/widget.php' );
		$widget_string .= ob_get_clean();
		$widget_string .= $after_widget;


		$cache[ $args['widget_id'] ] = $widget_string;

		wp_cache_set( $this->get_widget_slug(), $cache, 'widget' );

		print $widget_string;

	} // end widget

	/**
	 * Processes the widget's options to be saved.
	 *
	 * @param array new_instance The new instance of values to be generated via the update.
	 * @param array old_instance The previous instance of values before the update.
	 */
	public function update( $new_instance, $old_instance ) {


		$instance = $old_instance;

		$instance['selected_team']	= strip_tags(stripslashes($new_instance['selected_team']));
		$instance['theme'] 			= strip_tags(stripslashes($new_instance['theme']));
		$instance['show_matches'] 	= strip_tags(stripslashes($new_instance['show_matches']));


		return $instance;

	} // end widget

	/**
	 * Generates the administration form for the widget.
	 *
	 * @param array instance The array of keys and values for the widget.
	 */
	public function form( $instance ) {

		// TODO: Define default values for your variables
		$instance = wp_parse_args(
			(array) $instance,
				array(
					'selected_team' => '',
					'theme' => '',
					'show_matches' => ''
				)
		);
		// TODO: Store the values of the widget in their own variable
		$selected_team 	= strip_tags(stripslashes($new_instance['selected_team']));
		$theme 			= strip_tags(stripslashes($new_instance['theme']));
		$show_matches	= strip_tags(stripslashes($new_instance['show_matches']));

		// Display the admin form
		include( $this->get_widget_path() . 'views/admin.php' );

	} // end form

} // end class
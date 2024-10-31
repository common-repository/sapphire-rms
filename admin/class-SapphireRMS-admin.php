<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    SapphireRMS
 * @subpackage SapphireRMS/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    SapphireRMS
 * @subpackage SapphireRMS/admin
 * @author     Your Name <email@example.com>
 */
class SapphireRMS_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The options name to be used in this plugin
	 *
	 * @since  	1.0.0
	 * @access 	private
	 * @var  	string 		$option_name 	Option name of this plugin
	 */
	private $option_name = 'SapphireRMS_Options';

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
	 * @param      string    $SapphireRMS       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}


    
    function add_action_links( $links ) {
        /*
        *  Documentation : https://codex.wordpress.org/Plugin_API/Filter_Reference/plugin_action_links_(plugin_file_name)
        */
       $settings_link = array(
        '<a href="' . admin_url( 'options-general.php?page=' . $this->plugin_name ) . '">' . __('Settings', $this->plugin_name) . '</a>',
       );
       return array_merge(  $settings_link, $links );

    }


	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in SapphireRMS_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The SapphireRMS_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/SapphireRMS-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in SapphireRMS_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The SapphireRMS_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/SapphireRMS-admin.js', array( 'jquery' ), $this->version, false );

	}

    /**
	 * Add an options page under the Settings submenu
	 *
	 * @since  1.0.0
	 */
    public function add_options_page() {
        
        $this->plugin_screen_hook_suffx = add_options_page(
            __( 'Sapphire RMS Settings', 'SapphireRMS' ),
            __( 'Sapphire RMS', 'SapphireRMS' ),
            'manage_options',
            $this->plugin_name,
            array( $this, 'display_options_page' )
        );

    }

    /**
	 * Render the options page for plugin
	 *
	 * @since  1.0.0
	 */
	public function display_options_page() {
		include_once 'partials/SapphireRMS-admin-display.php';
	}

    /**
	 * Register all related settings of this plugin
	 *
	 * @since  1.0.0
	 */
	public function register_setting() {

		add_settings_section(
			$this->option_name . '_general',
			__( 'General', 'SapphireRMS' ),
			array( $this, $this->option_name . '_general_cb' ),
			$this->plugin_name
		);

		add_settings_field(
			$this->option_name . '_url',
			__( 'Sapphire RMS URL', 'SapphireRMS_Options' ),
			array( $this, $this->option_name . '_url_cb' ),
			$this->plugin_name,
			$this->option_name . '_general',
			array( 'label_for' => $this->option_name . '_url' )
		);

		add_settings_field(
			$this->option_name . '_key',
			__( 'Sapphire RMS Key', 'SapphireRMS_Options' ),
			array( $this, $this->option_name . '_key_cb' ),
			$this->plugin_name,
			$this->option_name . '_general',
			array( 'label_for' => $this->option_name . '_key' )
		);

        register_setting( $this->plugin_name, $this->option_name . '_url', 'strval' );
		register_setting( $this->plugin_name, $this->option_name . '_key', 'strval' );

	}

    /**
	 * Render the text for the general section
	 *
	 * @since  1.0.0
	 */
	public function SapphireRMS_Options_general_cb() {
		echo '<p>' . __( 'Please change the settings accordingly.', 'SapphireRMS_Options' ) . '</p>';
	}

	/**
	 * Render the treshold day input for this plugin
	 *
	 * @since  1.0.0
	 */
	public function SapphireRMS_Options_url_cb() {
		$url = get_option( $this->option_name . '_url' );
		echo '<input type="text" size="40" name="' . $this->option_name . '_url' . '" id="' . $this->option_name . '_url' . '" value="' . $url . '"> ' . __( '<br>Default: https://api.sapphirerms.com', 'SapphireRMS_Options' );
	}

	/**
	 * Render the treshold day input for this plugin
	 *
	 * @since  1.0.0
	 */
	public function SapphireRMS_Options_key_cb() {
		$key = get_option( $this->option_name . '_key' );
		echo '<input type="text" size="40" name="' . $this->option_name . '_key' . '" id="' . $this->option_name . '_key' . '" value="' . $key . '"> ' . __( '<br>Example: ABCDEFGH-IJKL-MNOP-QRST-UVWXYZ123456', 'SapphireRMS_Options' );
	}

       
}

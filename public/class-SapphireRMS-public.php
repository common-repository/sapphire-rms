<?php
    /**
     * The public-facing functionality of the plugin.
     *
     * @link       http://example.com
     * @since      1.0.0
     *
     * @package    SapphireRMS
     * @subpackage SapphireRMS/public
     */
    /**
     * The public-facing functionality of the plugin.
     *
     * Defines the plugin name, version, and two examples hooks for how to
     * enqueue the admin-specific stylesheet and JavaScript.
     *
     * @package    SapphireRMS
     * @subpackage SapphireRMS/public
     * @author     Your Name <email@example.com>
     */
    class SapphireRMS_Public {
        /**
         * The ID of this plugin.
         *
         * @since    1.0.0
         * @access   private
         * @var      string    $SapphireRMS    The ID of this plugin.
         */
        private $SapphireRMS;
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
         * @param      string    $SapphireRMS       The name of the plugin.
         * @param      string    $version    The version of this plugin.
         */
        public function __construct( $SapphireRMS, $version ) {
            $this->SapphireRMS = $SapphireRMS;
            $this->version = $version;
        }
        /**
         * Register the stylesheets for the public-facing side of the site.
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
            wp_enqueue_style( $this->SapphireRMS . 'datetimepicker', plugin_dir_url( __FILE__ ) . 'css/bootstrap-datetimepicker.min.css', array(), $this->version, 'all' );
            wp_enqueue_style( $this->SapphireRMS, plugin_dir_url( __FILE__ ) . 'css/SapphireRMS-public.css', array(), $this->version, 'all' );
        }
        /**
         * Register the stylesheets for the public-facing side of the site.
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
            wp_enqueue_script( $this->SapphireRMS . 'moment', plugin_dir_url( __FILE__ ) . 'js/moment.min.js');
            wp_enqueue_script( $this->SapphireRMS . 'moment-with-locale', plugin_dir_url( __FILE__ ) . 'js/moment-with-locales.min.js');
            wp_enqueue_script( $this->SapphireRMS . 'bootstrap', plugin_dir_url( __FILE__ ) . 'js/bootstrap.min.js');
            wp_enqueue_script( $this->SapphireRMS . 'datetimepicker', plugin_dir_url( __FILE__ ) . 'js/bootstrap-datetimepicker.min.js');
            wp_enqueue_script( $this->SapphireRMS, plugin_dir_url( __FILE__ ) . 'js/SapphireRMS-public.js', array( 'jquery' ), $this->version, true );
        }
    
        /**
         * Register the custom post type
         *
         * @since    1.0.0
         */
        public function add_cpt_vehicle_class() {
    
            $labels = array(
                'name'                  => _x( 'Vehicle Classes', 'vehicle_class' ),
                'singular_name'         => _x( 'Vehicle Class', 'vehicle_class' ),
                'add_new'               => _x( 'Add New', 'vehicle_class' ),
                'add_new_item'          => _x( 'Add New Vehicle Class', 'vehicle_class' ),
                'edit_item'             => _x( 'Edit Vehicle Class', 'vehicle_class' ),
                'new_item'              => _x( 'New Vehicle Class', 'vehicle_class' ),
                'view_item'             => _x( 'View Vehicle Class', 'vehicle_class' ),
                'search_items'          => _x( 'Search Vehicle Class', 'vehicle_class' ),
                'not_found'             => _x( 'No vehicle classes found', 'vehicle_class' ),
                'not_found_in_trash'    => _x( 'No vehicle classes found in Trash', 'vehicle_class' ),
                'parent_item_colon'     => _x( 'Parent Vehicle Class:', 'vehicle_class' ),
                'menu_name'             => _x( 'Vehicle Classes', 'vehicle_class' ),
            );
    
            $args = array(
                'labels'                => $labels,
                'hierarchical'          => true,
                'description'           => 'Vehicle Classes',
                'supports'              => array( 'title', 'editor', 'author', 'thumbnail', 'trackbacks', 'custom-fields', 'comments', 'revisions', 'page-attributes' ),
                'taxonomies'            => array( 'vehicle class' ),
                'public'                => true,
                'show_ui'               => true,
                'show_in_menu'          => true,
                'menu_position'         => 5,
                'menu_icon'             => 'dashicons-admin-network',
                'show_in_nav_menus'     => true,
                'publicly_queryable'    => true,
                'exclude_from_search'   => false,
                'has_archive'           => true,
                'query_var'             => true,
                'can_export'            => true,
                'rewrite'               => true,
                'capability_type'       => 'post'
            );
    
            register_post_type('vehicle_class', $args );
    
        }
    
    
        /**
         * Register widgets
         *
         * @since    1.0.0
         */
        public function add_widgets() {
            
            include_once 'partials/SapphireRMS-reservation-widget.php';
            register_widget( 'reservation_widget' );

            include_once 'partials/SapphireRMS-member-login-widget.php';
            register_widget( 'member_login_widget' );

            include_once 'partials/SapphireRMS-partner-login-widget.php';
            register_widget( 'partner_login_widget' );

        }

        /**
         * Register shortcodes
         *
         * @since    1.0.0
         */
        public function add_shortcodes() {
            
            include_once 'partials/SapphireRMS-reservation-shortcode.php';
            add_shortcode( 'reservation-form', 'SapphireRMS_reservation_shortcode_handler' );
            add_shortcode( 'reservation-form-lookup', 'SapphireRMS_reservation_lookup_shortcode_handler' );
            add_shortcode( 'reservation-url', 'SapphireRMS_URL_Reservation_shortcode_handler' );

            include_once 'partials/SapphireRMS-member-login-shortcode.php';
            add_shortcode( 'member-login', 'SapphireRMS_member_login_shortcode_handler' );
            add_shortcode( 'member-url', 'SapphireRMS_URL_Member_shortcode_handler' );

            include_once 'partials/SapphireRMS-partner-login-shortcode.php';
            add_shortcode( 'partner-login', 'SapphireRMS_partner_login_shortcode_handler' );
            add_shortcode( 'partner-url', 'SapphireRMS_URL_Partner_shortcode_handler' );

        }
                
    
    }

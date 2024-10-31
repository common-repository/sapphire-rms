<?php
    
    /*
    Plugin Name:    Sapphire RMS
    Plugin URI:     http://wpplugin.sapphirerms.com/
    Version:        1.5.9
    Author:         Binary Solutions, Inc.
    Author URI:     http://www.binarysolutionsinc.com/
    Description:    Integrates your existing Sapphire RMS account information into your WordPress site.
    */
    
    // If this file is called directly, abort.
    if ( ! defined( 'WPINC' ) ) {
	    die;
    }

    // Activate
    function activate_SapphireRMS() {
	    require_once plugin_dir_path( __FILE__ ) . 'includes/class-SapphireRMS-activator.php';
	    SapphireRMS_Activator::activate();
    }

    // Deactivate
    function deactivate_SapphireRMS() {
	    require_once plugin_dir_path( __FILE__ ) . 'includes/class-SapphireRMS-deactivator.php';
	    SapphireRMS_Deactivator::deactivate();
    }

    register_activation_hook( __FILE__, 'activate_SapphireRMS' );
    register_deactivation_hook( __FILE__, 'deactivate_SapphireRMS' );

    require plugin_dir_path( __FILE__ ) . 'includes/class-SapphireRMS.php';

    function run_SapphireRMS() {

	    $plugin = new SapphireRMS();
	    $plugin->run();

    }

    run_SapphireRMS();

?>
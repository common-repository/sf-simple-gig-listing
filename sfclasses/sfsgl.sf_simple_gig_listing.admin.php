<?php
 * Admin Class
 */
class sfsglAdmin extends sfsglCommon
  var $options;
  function __construct()
		/**
		/**
    * Ajax Call Example
    */
    /*
  /**
    /*
    ********************** JS **********************
    */

    /**
     * Default Admin JS
     * dependencies: jquery
     * Params: Admin Ajaxurl - Custom; Home Url - homeurl
     */
    wp_register_script('sfsgl-default-admin-js', sf_simple_gig_listing_url.'admin/js/admin_default.js',array('jquery'));wp_localize_script( 'sfsgl-default-admin-js', 'Custom', array('ajaxurl'  => admin_url( 'admin-ajax.php' ),'homeurl' => home_url()));wp_enqueue_script('sfsgl-default-admin-js');
  }
   * Add Admin Menu
   * Called @__construct()
   */
  function add_menu()
	{
  /**
  /**
  /**
  /**
  /**
  /**
   * Ajax Example
   * Called @__construct()
   */
  public function ajax_example()
  {
    if ( !wp_verify_nonce( $_REQUEST['nonce'], "ajax_example_nonce")) {
      exit("No naughty business please");
    }

   die();
  }

}
$key = "sfsgladmin";
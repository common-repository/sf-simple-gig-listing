<?php
  public function __construct()
  /**
  /**
  /**
  /**
		/**
   * Styles and Scripts
   * Called @initial_settings()
   */
  public function add_front_end_styles()
		/**

    /*
    ********************** JS **********************
    */

    /**
     * Default Plugin JS
     * dependencies: jquery
     * Params: Admin Ajaxurl - Custom; Home Url - homeurl
     */
		wp_register_script('sfsgl-default-js', sf_simple_gig_listing_url.'js/default.js',array('jquery'));wp_localize_script( 'sfsgl-default-js', 'Custom', array('ajaxurl'  => admin_url( 'admin-ajax.php' ),'homeurl' => home_url(), 'upload_url' => admin_url('async-upload.php')));wp_enqueue_script('sfsgl-default-js');
}
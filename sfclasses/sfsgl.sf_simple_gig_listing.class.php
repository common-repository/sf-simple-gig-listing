<?php/** * Master Class */class SFSimpleGigListing{  var $options;  var $current_page;  var $classes_array;
  public function __construct()	{		$this->current_page = $_SERVER['REQUEST_URI'];		$this->options = get_option('sf_simple_gig_listing_options');  }
  /**   * Init Function   * Load Main Classes   * Load Admin Classes   * Initial Settings   */  public function plugin_init(){    $this->set_main_classes();    $this->load_classes();    if(is_admin()){      $this->set_admin_classes();      $this->load_classes();    }    $this->intial_settings();  }
  /**   * Set Array of main classes   */  public function set_main_classes()	{    $this->classes_array = array(      "commmonmethods" =>"sfsgl.sf_simple_gig_listing.common" ,      "shortocde" =>"sfsgl.sf_simple_gig_listing.shortcodes" ,      "show_gig_widget" =>"sfsgl.sf_simple_gig_listing.show_gig_widget" ,      "database" =>"sfsgl.sf_simple_gig_listing.database" ,    );	}  /**   * Admin Class   */  public function set_admin_classes()  {    $this->classes_array = array(      "sfsgladmin" =>"sfsgl.sf_simple_gig_listing.admin",    );  }
  /**   * Load Classes   */  function load_classes(){    foreach ($this->classes_array as $key => $class){      if(file_exists(sf_simple_gig_listing_path."sfclasses/$class.php")){        require_once(sf_simple_gig_listing_path."sfclasses/$class.php");      }    }  }
  /**   * Classes loaded.   * Initiate Settings   */  public function intial_settings()	{
		/**     * Styles und Scripts     */		add_action('wp_enqueue_scripts', array(&$this, 'add_front_end_styles'), 9);	}  /**
   * Styles and Scripts
   * Called @initial_settings()
   */
  public function add_front_end_styles()	{    /*    ********************** CSS **********************    */		/*    * Font Awesome    */		    wp_register_style( 'sf_simple_gig_listing_font_awesome', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');wp_enqueue_style('sf_simple_gig_listing_font_awesome');
		/**     * Default Plugin CSS     */		wp_register_style( 'sf_simple_gig_listing_style', sf_simple_gig_listing_url.'templates/'.sf_simple_gig_listing_template.'/css/default.css');wp_enqueue_style('sf_simple_gig_listing_style');

    /*
    ********************** JS **********************
    */

    /**
     * Default Plugin JS
     * dependencies: jquery
     * Params: Admin Ajaxurl - Custom; Home Url - homeurl
     */
		wp_register_script('sfsgl-default-js', sf_simple_gig_listing_url.'js/default.js',array('jquery'));wp_localize_script( 'sfsgl-default-js', 'Custom', array('ajaxurl'  => admin_url( 'admin-ajax.php' ),'homeurl' => home_url(), 'upload_url' => admin_url('async-upload.php')));wp_enqueue_script('sfsgl-default-js');	}
}
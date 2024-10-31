<?php/**
 * Admin Class
 */
class sfsglAdmin extends sfsglCommon{
  var $options;  var $plugin_data;  var $version;
  function __construct()  {    $this->options = get_option('sf_simple_gig_listing_options');
		/**     * Plugin slug and version     */		$this->slug = 'sf-simple-gig-listing';require_once( ABSPATH . 'wp-admin/includes/plugin.php' );$this->plugin_data = get_plugin_data( sf_simple_gig_listing_path . 'sf_simple_gig_listing.php', false, false);$this->version = $this->plugin_data['Version'];
		/**     * Priority actions     */		add_action('admin_menu', array(&$this, 'add_menu'), 9);    add_action('admin_enqueue_scripts', array(&$this, 'add_admin_styles'), 9);		add_action('admin_init', array(&$this, 'admin_init'), 9);    /*
    * Ajax Call Example
    */
    /*      add_action('wp_ajax_ajax_example', array( $this, 'ajax_example' ));      //add_action('wp_ajax_nopriv_ajax_example', array( $this, 'ajax_example' ));    */	}
  /**   * Admin Styles   * Called @__construct()   */  function add_admin_styles()  {
    /*    ********************** CSS **********************    */    /**     * Font Awesome     */    wp_register_style( 'sf_simple_gig_listing_font_awesome', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');wp_enqueue_style('sf_simple_gig_listing_font_awesome');    /**     * Default Admin Style     */    wp_register_style( 'sf_simple_gig_listing_admin_style', sf_simple_gig_listing_url.'admin/css/default_admin.css');wp_enqueue_style('sf_simple_gig_listing_admin_style');    /*
    ********************** JS **********************
    */

    /**
     * Default Admin JS
     * dependencies: jquery
     * Params: Admin Ajaxurl - Custom; Home Url - homeurl
     */
    wp_register_script('sfsgl-default-admin-js', sf_simple_gig_listing_url.'admin/js/admin_default.js',array('jquery'));wp_localize_script( 'sfsgl-default-admin-js', 'Custom', array('ajaxurl'  => admin_url( 'admin-ajax.php' ),'homeurl' => home_url()));wp_enqueue_script('sfsgl-default-admin-js');
  }  /**
   * Add Admin Menu
   * Called @__construct()
   */
  function add_menu()
	{		add_menu_page( __('Simple Gig Listing','sf_simple_gig_listing'), __('Simple Gig Listing','sf_simple_gig_listing'), 'manage_options', $this->slug, array(&$this, 'admin_page'), 'dashicons-editor-justify');	}
  /**   * Admin Menü Page   * Called @add_menu()   */  function admin_page()  {    global $sf_simple_gig_listing;    // Update Settings    if (isset($_POST['update_settings'])){      if( ! isset( $_POST['sfsgl_nonce_check'] ) || ! wp_verify_nonce( $_POST['sfsgl_nonce_check'], 'update_settings' )){        print 'Sorry, your nonce did not verify.';exit;      }      $this->update_settings();    }    ?>    <div class="wrap <?php echo $this->slug; ?>-admin">      <h2 class="nav-tab-wrapper"><?php $this->admin_tabs(); ?></h2>      <div class="<?php echo $this->slug; ?>-admin-contain">        <?php $this->include_tab_content(); ?>        <div class="clear"></div>      </div>    </div>    <?php  }
  /**   * Update Settings   * Called @admin_page   */  function update_settings()  {    foreach($_POST as $key => $value){      if ($key != 'submit'){        $this->sf_simple_gig_listing_set_option($key, $value);      }    }    $this->options = get_option('sf_simple_gig_listing_options');    echo '<div class="updated"><p><strong>'.__('Einstellungen gespeichert.','sf_simple_gig_listing').'</strong></p></div>';  }
  /**   * Einstellungen speichern   * Called @update_settings   * @param String $option key   * @param String $newvalue value   */  function sf_simple_gig_listing_set_option($option, $newvalue)  {    $settings = get_option('sf_simple_gig_listing_options');    $settings[$option] = $newvalue;    update_option('sf_simple_gig_listing_options', $settings);  }
  /**   * Admin Tabs   * Called @admin_page   */  function admin_tabs($current = null)  {    $tabs = $this->tabs;    $links = array();    // Get Tab from Param    if ( isset ( $_GET['tab'] ) ) {      $current = $_GET['tab'];    } else {      $current = $this->default_tab;    }    foreach( $tabs as $tab => $name ) :      if ( $tab == $current ) :          $links[] = "<a class='nav-tab nav-tab-active' href='?page=".$this->slug."&tab=$tab'>$name </a>";        else :          $links[] = "<a class='nav-tab' href='?page=".$this->slug."&tab=$tab'>$name </a>";      endif;    endforeach;    foreach ( $links as $link ) {      echo $link;    }  }
  /**   * Tab Content   * Called @admin_page   */  function include_tab_content()  {    $screen = get_current_screen();if( strstr($screen->id, $this->slug ) ) { if ( isset ( $_GET['tab'] ) ) { $tab = $_GET['tab'];} else {$tab = $this->default_tab;}if(isset($this->tabs[$tab])) {require_once (sf_simple_gig_listing_path.'admin/tabs/'.$tab.'.php');}else{ echo "Wrong Tab";}}  }
  /**   * Admin init   * aufgerufen vom Cunstutor   */  function admin_init()  {   $this->tabs = array(     'main' => __('Dashboard', 'sf_simple_gig_listing'),     'new' => __('Auftritt hinzufügen', 'sf_simple_gig_listing'),     'settings' => __('Einstellungen', 'sf_simple_gig_listing'),   );   $this->default_tab = 'main';  }  /**
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
$key = "sfsgladmin";$this->{$key} = new sfsglAdmin();
<?php

/* WordPress hook uninstall must be called outside*/
/**
 * Pre Init - uninstall Hook
 * Remove all data and DB
 */
function sf_simple_gig_listing_uninstall()
{
  global $wpdb;
  global $plugin;

  if ( $plugin != WP_UNINSTALL_PLUGIN )
    return;

  $table_name = get_option("sf_simple_gig_listing_db_name");

  $sql = "DROP TABLE IF EXISTS $table_name;";
  $wpdb->query($sql);

  delete_option("sf_simple_gig_listing_db_version");
  delete_option("sf_simple_gig_listing_options");

}
register_uninstall_hook(__FILE__, 'sf_simple_gig_listing_uninstall');


class sfsglDatabase {

  var $options;

  function __construct()
	{
    /**
     * Global Options
     */
    $this->options = get_option('sf_simple_gig_listing_options');

    /**
     * Ajax delete Gig
     * Used in Adminpanel
     * Called at admin_default.js
     */
    add_action('wp_ajax_sf_delete_gig', array( $this, 'sf_delete_gig' ));
    add_action('wp_ajax_nopriv_sf_delete_gig', array( $this, 'sf_delete_gig' ));


    /**
     * Ajax add new Gig
     * Used in Adminpanel
     * Called at admin_default.js
     */
    add_action('wp_ajax_sf_add_new_gig', array( $this, 'sf_add_new_gig' ));
    add_action('wp_ajax_nopriv_sf_add_new_gig', array( $this, 'sf_add_new_gig' ));

    global $plugin;

    /**
     * Install/Remove SQL Tables
     */
    register_activation_hook($plugin, array( $this, 'sf_simple_gig_listing_install'));
    add_action('plugins_loaded', array($this, 'sf_simple_gig_listing_check_version'));


	}

  public function sf_simple_gig_listing_check_version()
  {
    if (sf_simple_gig_listing_version !== get_option('sf_simple_gig_listing_db_version')) {
      $this->sf_simple_gig_listing_install();
    }

  }

  /**
   * Get Gigs out of table.
   * Used and Called in Adminpanel and Frontend
   */
  public function sf_sgl_get_gigs()
  {
    global $wpdb;
    $table_name = get_option("sf_simple_gig_listing_db_name");
    $WHERE = '';
    $sorting = 'DESC';
    $limit = '';

    // Restrictions only in Frontend
    if(! is_admin()) {
      if($this->options['display_past_gigs'] == 'disable_past') {
        $tstamp = time();
        $WHERE = " WHERE datum > " . $tstamp;
      }

      if($this->options['sorting'] == 'ascending') {
        $sorting = 'ASC';
      }

      if(!empty($this->options['show_amount_gigs'])) {
        $amount = intval($this->options['show_amount_gigs']);
        if($amount != 0) {
            $limit = ' LIMIT ' . $amount;
        }
      }
    }

    $rows = $wpdb->get_results( "SELECT * FROM $table_name " . $WHERE . " ORDER BY datum ". $sorting . $limit );

    return $rows;
  }

  /**
   * Remove Gigs out of table.
   * Used in Adminpanel main.php
   * Called at admin_default.js
   */
  public function sf_delete_gig()
  {
    if ( !wp_verify_nonce( $_REQUEST['nonce'], "sf_dashboard_actions")) {
      exit("No naughty business please");
    }

    global $wpdb;

    $params = $_REQUEST['params'];
    $id = $params['id'];
    $table_name = get_option("sf_simple_gig_listing_db_name");

    $db_call = $wpdb->delete($table_name,array('id' => $id));


    if($db_call === false) {
      $str   = 'Es ist ein Datenbankfehler aufgetreten.';

      $response['error'] = $str;
    } else {
      $response['success'] = $id;
    }

    echo json_encode($response);

    die();
  }

  /**
   * Add new Gig
   * Used in Adminpanel new.php
   * Called at admin_default.js
   */
  public function sf_add_new_gig()
  {
    global $wpdb;

    $table_name = get_option("sf_simple_gig_listing_db_name");
    $params = $_REQUEST['params'];
    $datestmp = strtotime($params['datum']);



		$db_call = $wpdb->insert(
			$table_name,
			array(
				'name' => sanitize_text_field($params['name']),
				'venue' => sanitize_text_field($params['club']),
        'location' => sanitize_text_field($params['ort']),
        'datum' => sanitize_text_field($datestmp)
			)
		);
    if($db_call === false) {
      $str   = 'Es ist ein Datenbankfehler aufgetreten.';
      $response['error'] = $str;
    } else {
      $response['success'] = $db_call;
      $response['success'] = $datestmp;
    }


    echo json_encode($response);

    die();

  }

  /**
   * Pre Init - activation Hook
   */
  public function sf_simple_gig_listing_install()
  {
    global $wpdb;

    $version = get_option( 'sf_simple_gig_listing_db_version');

    $table_name = $wpdb->prefix . "sf_simple_gigs";
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
        id int(11) NOT NULL AUTO_INCREMENT,
        name varchar(255) DEFAULT NULL,
        location varchar(255) DEFAULT NULL,
        venue varchar(255) DEFAULT NULL,
        datum int(15) NOT NULL,
        UNIQUE KEY id (id)
      ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);

    // To update DB just compare plugins version and db version
    // @see https://premium.wpmudev.org/blog/creating-database-tables-for-plugins/




    update_option("sf_simple_gig_listing_db_version", sf_simple_gig_listing_version);
    update_option("sf_simple_gig_listing_db_name", $table_name);

  }


}

$key = "database";
$this->{$key} = new sfsglDatabase();

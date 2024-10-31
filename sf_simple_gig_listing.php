<?php/*Plugin Name: SF Simple Gig ListingDescription: A simple listing for Gigs.Version: 1.0.0Author: Simplefox - Kjell WeibrechtAuthor URI: http://simplefox.de*/defined( 'ABSPATH' ) OR exit;

define('sf_simple_gig_listing_url',plugin_dir_url(__FILE__ ));define('sf_simple_gig_listing_path',plugin_dir_path(__FILE__ ));define('sf_simple_gig_listing_template','basic');define('sf_simple_gig_listing_version', sf_simple_gig_listing_get_plugin_version());


/** * Plugin Version */function sf_simple_gig_listing_get_plugin_version(){  $default_headers = array( 'Version' => 'Version' );  $plugin_data = get_file_data( __FILE__, $default_headers, 'plugin' );  return $plugin_data['Version'];}
$plugin = plugin_basename(__FILE__);/** * Textdomain (localization) */function sf_simple_gig_listing_load_textdomain() {  $locale = apply_filters( 'plugin_locale', get_locale(), 'sf-simple-gig-listing' );  $mofile = sf_simple_gig_listing_path . "languages/$locale.mo";  load_textdomain( 'sf_simple_gig_listing', $mofile );  load_plugin_textdomain( 'sf_simple_gig_listing', false, dirname(plugin_basename(__FILE__)).'/languages/' );}add_action('init', 'sf_simple_gig_listing_load_textdomain');

/** * Master Class Insert */require_once (sf_simple_gig_listing_path . 'sfclasses/sfsgl.sf_simple_gig_listing.class.php');$sf_simple_gig_listing = new SFSimpleGigListing();$sf_simple_gig_listing->plugin_init();
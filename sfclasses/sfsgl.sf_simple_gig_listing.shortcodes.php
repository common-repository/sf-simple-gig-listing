<?php
class sfsglShortCode {

  var $options;

  function __construct()
	{
    /**
     * Add Shortcodes
     */
		add_action( 'init',   array(&$this,'sf_simple_gig_listing_shortcodes'));

    /**
     * Global Options
     */
    $this->options = get_option('sf_simple_gig_listing_options');

	}

  /**
	 * Add the shortcodes
	 */
	function sf_simple_gig_listing_shortcodes()
	{

    /**
     * Shortcode Example
     */
    add_shortcode( 'sfsgl_show', array(&$this,'sf_simple_gig_listing_show_function') );

	}

  /**
   * Example shortcodes
   * @params $atts
   */
  public function sf_simple_gig_listing_show_function($atts)
  {
    ob_start();

    $this->get_show_all_gigs_content();
    /* assign the file output to $content variable and clean buffer */
		$content = ob_get_clean();
		return  $content;
  }

  public function get_show_all_gigs_content()
  {
    global $sf_simple_gig_listing;
    $gigs = $sf_simple_gig_listing->database->sf_sgl_get_gigs();
    $style = $this->options['css_style'];



    switch ($style) {
      case 'simple':
      default:
        ?>
        <div class="sf_sgl_show_gigs_widget sf_simple">
          <ul>
            <?php
            foreach($gigs as $gig) {
              /* Date aufbereiten */
              $date = gmdate("d.m.Y", $gig->datum);
              ?>
              <li>
                <div class="sf_name"><?php echo $gig->name; ?></div>
                <span><?php echo $date; ?></span> | <span><?php echo $gig->venue; ?></span> | <span><?php echo $gig->location; ?></span>
              </li>
              <?php
            }
            ?>
          </ul>
        </div>
        <?php
        break;
      case 'icon_wide':
        ?>
        <div class="sf_sgl_show_gigs_widget sf_wide marginTopMedium">
          <ul>
            <?php
            foreach($gigs as $gig) {
              /* Date aufbereiten */              
              $date = gmdate("d.m.Y", $gig->datum);
              ?>
              <li class="sf_name">
                <b><?php echo $gig->name; ?></b>
              </li>
              <li class="sf_date">
                <i class="fa fa-calendar" aria-hidden="true"></i> <span><?php echo $date; ?></span>
              </li>
              <li class="sf_venue">
                <i class="fa fa-compress" aria-hidden="true"></i> <span><?php echo $gig->venue; ?></span>
              </li>
              <li class="sf_location">
                <i class="fa fa-map-marker" aria-hidden="true"></i> <span><?php echo $gig->location; ?></span>
              </li>
              <hr />
              <?php
            }
            ?>
          </ul>
        </div>
        <?php
        break;
    }
  }

}

$key = "shortcode";
$this->{$key} = new sfsglShortCode();

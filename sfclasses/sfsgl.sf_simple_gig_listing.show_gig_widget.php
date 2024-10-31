<?php
class sfsgl_show_gig_widget extends WP_Widget {

  function __construct() {
    parent::__construct(
    // Base ID of your widget
    'wpb_widget',
    // Widget name will appear in UI
    __('Show All Gigs', 'sf_simple_gig_listing'),
    // Widget description
    array( 'description' => __( 'Zeige alle Auftritte', 'sf_simple_gig_listing' ), )
    );
  }

  public function widget( $args, $instance )
  {
    global $sf_simple_gig_listing;

    $title = apply_filters( 'widget_title', $instance['title'] );
    // before and after widget arguments are defined by themes

    echo $args['before_widget'];
    if ( ! empty( $title ) )
      echo $args['before_title'] . $title . $args['after_title'];





    $sf_simple_gig_listing->shortcode->get_show_all_gigs_content();

    echo $args['after_widget'];
  }


  // Widget Backend
  public function form( $instance )
  {
    if ( isset( $instance[ 'title' ] ) ) {
      $title = $instance[ 'title' ];
    } else {
      $title = __( 'New title', 'wpb_widget_domain' );
    }

    // Widget admin form
    ?>
    <p>
      <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
      <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
    </p>
    <?php
  }


}


function sfsgl_load_show_gig_widget()
{
  register_widget( 'sfsgl_show_gig_widget' );
}
add_action( 'widgets_init', 'sfsgl_load_show_gig_widget' );

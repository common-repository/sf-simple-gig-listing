<?phpglobal $sf_simple_gig_listing;$gigs                       = $sf_simple_gig_listing->database->sf_sgl_get_gigs();$page                       = (isset($_GET['paginierung'])) ? $_GET['paginierung'] : 1;if(empty($page)) {$page = 1;}$amountAuftritte            = count($gigs);$anzahlZuZeigenderAuftritte = 9;$allPages                   = ceil($amountAuftritte / $anzahlZuZeigenderAuftritte); if($allPages == 0){$allPages = 1;};$gigsArray                  = array_chunk($gigs, $anzahlZuZeigenderAuftritte);$uri_parts                  = explode('?', $_SERVER['REQUEST_URI'], 2);$path = $uri_parts[0];$params                     = '';?><h3 class="marginTopMedium"><?php _e('Übersicht aller Auftritte','sf_simple_gig_listing'); ?></h3>
<?php $nonce = wp_create_nonce('sf_dashboard_actions'); ?>
<input type="hidden" id="sf_dashboard_action" value="<?php echo $nonce;?>">


<?php sf_navigation($page, $params, $allPages, $path); ?>
<table class="widefat">
  <?php sf_thead(); ?>
  <tbody>
    <?php
    if($amountAuftritte != 0) {
      foreach ($gigsArray[$page-1] as $gig) {

        /* Date aufbereiten */
        $date = gmdate("d.m.Y", $gig->datum);
        if($gig->datum < time()) {
          $mark = 'sf_vergangen';
        } else {
          $mark = 'sf_aktuell';
        }


        ?>
        <tr class="<?php echo $mark; ?>">
          <td><?php echo $gig->name;      ?></td>
          <td><?php echo $gig->venue;     ?></td>
          <td><?php echo $gig->location;  ?></td>
          <td><?php echo $date;           ?></td>
          <td class="sf_head_buttons">
            <a href="#" data-id="<?php echo $gig->id; ?>" data-action="delete" class="sf_action_button button-secondary" title="Delete this Gig">
              <?php _e('Löschen','sf_simple_gig_listing'); ?>
            </a>
            <span class="sf_loading hidden"><i class="fa fa-spinner fa-pulse fa-1x fa-fw"></i> <?php _e('Anfrage wird bearbeitet','sf_simple_gig_listing'); ?></span>
            <span class="sf_finished hidden"><i class="fa fa-check" aria-hidden="true"></i> <?php _e('Erfolgreich gelöscht','sf_simple_gig_listing'); ?></span>
          </td>
        </tr>
        <?php
      }
    }
    ?>
  </tbody>
</table>
<?php sf_navigation($page, $params, $allPages, $path); ?>







<?php
/* Gig Navigation */
function sf_navigation($page, $params, $allPages, $path)
{
  ?>
  <div class="tablenav">
    <div class="tablenav-pages">
      <span class="pagination-links">
        <?php
        if($page == "1") {
          ?>
          <span class="tablenav-pages-navspan" aria-hidden="true">«</span>
          <span class="tablenav-pages-navspan" aria-hidden="true">‹</span>
          <?php
        } else {
          $prevPage = $page -1;
          if($page != "2") {
            ?>
            <a class="first-page" href="<?php echo $path . '?page=sf-simple-gig-listing&tab=main&paginierung=1'. $params?>"><span class="screen-reader-text"><?php _e('Erste Seite','sf_simple_gig_listing'); ?></span><span aria-hidden="true">«</span></a>
            <?php
          } else {
            ?>
            <span class="tablenav-pages-navspan" aria-hidden="true">«</span>
            <?php
          }
          ?>
          <a class="prev-page" href="<?php echo $path . '?page=sf-simple-gig-listing&tab=main&paginierung='.$prevPage . $params?>"><span class="screen-reader-text"><?php _e('Vorherige Seite','sf_simple_gig_listing'); ?></span><span aria-hidden="true">‹</span></a>
          <?php
        }

        $nextPage = $page+1;
        ?>
        <span><?php echo $page;?> <?php _e('von','sf_simple_gig_listing'); ?> <?php echo $allPages;?></span>
        <?php
        if($page == $allPages) {
          ?>
          <span class="tablenav-pages-navspan" aria-hidden="true">›</span>
          <span class="tablenav-pages-navspan" aria-hidden="true">»</span>
          <?php
        } else {
          ?>
          <a class="next-page" href="<?php echo $path . '?page=sf-simple-gig-listing&tab=main&paginierung='.$nextPage . $params?>"><span class="screen-reader-text"><?php _e('Nächste Seite','sf_simple_gig_listing'); ?></span><span aria-hidden="true">›</span></a>
          <?php
          if($page == $allPages-1) {
            ?>
            <span class="tablenav-pages-navspan" aria-hidden="true">»</span>
            <?php
          } else {
            ?>
            <a class="last-page" href="<?php echo $path . '?page=sf-simple-gig-listing&tab=main&paginierung='.$allPages . $params?>"><span class="screen-reader-text"><?php _e('Letzte Seite','sf_simple_gig_listing'); ?></span><span aria-hidden="true">»</span></a>
            <?php
          }
        }
        ?>
      </span>
    </div>
  </div>
  <?php
}

/* Table Heading */
function sf_thead()
{
  ?>
  <thead>
    <tr>
      <th class="sf_head_name"><?php _e('Name des Events','sf_simple_gig_listing'); ?></th>
      <th class="sf_head_club"><?php _e('Venue','sf_simple_gig_listing'); ?></th>
      <th class="sf_head_ort"><?php _e('Location','sf_simple_gig_listing'); ?></th>
      <th class="sf_head_datum"><?php _e('Datum','sf_simple_gig_listing'); ?></th>
      <th class="sf_head_buttons"></th>
    </tr>
  </thead>
  <?php
}
?>

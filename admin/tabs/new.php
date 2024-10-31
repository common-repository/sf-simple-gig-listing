<form method="post" action="">

  <div class="marginTopMedium sfGigAddBox sfStart postbox wrap">

    <h3><?php _e('Neuen Auftritt hinzufügen','sf_simple_gig_listing'); ?> </h3>

    <div class="marginTopMedium field nameField">
      <label for="name" ><?php _e('Name des Events','sf_simple_gig_listing'); ?></label>
      <input name="name" id="name" type="text" />
      <div class="error-message club"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> <?php _e('Bitte geben Sie etwas ein','sf_simple_gig_listing'); ?></div>
    </div>
    <div class="field clubField">
      <label for="club" ><?php _e('Venue','sf_simple_gig_listing'); ?></label>
      <input name="club" id="club" type="text" />
      <div class="error-message club"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> <?php _e('Bitte geben Sie etwas ein','sf_simple_gig_listing'); ?></div>
    </div>
    <div class="field ortField">
      <label for="ort" ><?php _e('Location','sf_simple_gig_listing'); ?></label>
      <input name="ort" id="ort" type="text" />
      <div class="error-message club"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> <?php _e('Bitte geben Sie etwas ein','sf_simple_gig_listing'); ?></div>
    </div>
    <div class="field datumField">
      <label for="datum" ><?php _e('Datum','sf_simple_gig_listing'); ?></label>
      <input type="date" id="datum" value="" />
      <div class="error-message club"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> <?php _e('Bitte geben Sie etwas ein','sf_simple_gig_listing'); ?></div>
    </div>
    <p class="submit">
    	<input type="submit" name="submit" id="submit" class="add_new_gig button button-primary" value="<?php _e('Auftritt hinzufügen','sf_simple_gig_listing'); ?>"  />
    </p>
  </div>
</form>
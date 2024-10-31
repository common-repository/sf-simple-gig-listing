(function ($) {


  class SimpleGigJS {
    constructor() {
      /* Alle wichtigen Funktionen aufrufen */
      this.handleDashboardButtons();
      this.handleNewGig();
    }


    /**
     * Handle Buttons in Dashboard
     */
    handleDashboardButtons() {

      var action_name;
      var them = this;
      /**
       * Performance boosted and reusable
       */
      $(document).on('click','.sf_action_button', function() {
        var perform = $(this).attr('data-action'),
            nonce = $('#sf_dashboard_action').val(),
            params;

        params = {id : $(this).attr('data-id')};




        switch (perform) {
          case 'delete':
            action_name = "sf_delete_gig";
            console.log('delete');
            break;
          case 'edit':
            action_name = "sf_edit_gig";
            console.log('edit');
            break;
        }



        /*
        * Da es keine beforeSend gibt
        */
        var ac_element = $(this);
        ac_element.parent().find('.sf_loading').show();
        ac_element.parent().find('.sf_action_button').hide();

        var ajax_action = them.ajaxHolder(action_name, nonce, params);

        ajax_action.done(function(response) {
          var response = JSON.parse(response);
          var id = response.success;

          ac_element.parent().find('.sf_loading').hide();
          ac_element.parent().find('.sf_finished').show();

          switch (perform) {
            case 'delete':

              $('.sf_action_button[data-id="'+id+'"]').parent().parent().hide(1000);

              break;
          }

        })


      });
    }

    /* Tab: "NEW" add new gig */
    handleNewGig() {

      

      $('#club').keyup(function() {
        console.log('yo');
  			if($(this).val() != '') {
  				$('.nameField').removeClass('sf_error');
  			} else {
  				$('.nameField').addClass('sf_error');
  			}
  		})

      jQuery('input').on("keyup change", function() {
        console.log('yoyo');
      })



      var them = this;
      $(document).on('click','.add_new_gig', function(evt) {
        evt.preventDefault();

        var name = $('#name').val(),
            club = $('#club').val(),
            ort = $('#ort').val(),
            datum = $('#datum').val(),
            nonce = $('#sfsgl_nonce_check').val(),
            action_name = "sf_add_new_gig",
            params;

        $('.sfGigAddBox .field').removeClass('sf_error');
        if(name == '') {
          $('.nameField').addClass('sf_error');
          return false;
        }
        if(club == '') {
          $('.clubField').addClass('sf_error');
          return false;
        }
        if(ort == '') {
          $('.ortField').addClass('sf_error');
          return false;
        }
        if(datum == '') {
          $('.datumField').addClass('sf_error');
          return false;
        }


        params = {name : name, club: club, ort: ort, datum: datum};
        var ajax_action = them.ajaxHolder(action_name, nonce, params);

        ajax_action.done(function(response) {
          var response = JSON.parse(response);
          console.log(response);
          if(response.error === undefined) {
            $('.sfGigAddBox.sfDone').show();
            $('.sfGigAddBox.sfStart').hide();
          } else {

          }

        })


      })


    }

    /* For All POST Ajax Calls*/
    ajaxHolder(action_name, nonce, params) {

      var ajax = jQuery.ajax({
          url : Custom.ajaxurl,
          type : 'post',
          data : {
             action: action_name,
             nonce: nonce,
             params: params
          },
          beforeSend: function( xhr ) {

          },
          error : function(error) {
            console.log(error)
            alert('Keine Berechtigung')
          }
      })

      return ajax;
    }

  }


  /* Init */
  new SimpleGigJS;
})(jQuery);

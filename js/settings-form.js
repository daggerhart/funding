(function ($, Drupal, drupalSettings) {

  Drupal.behaviors.fundingSettingsForm = {
    attach: function (context, settings) {
      let $enabledCheckboxes = $(context).find('.finding-provider-enabled-checkbox').once('funding_settings_form');
      if (!$enabledCheckboxes.length) {
        return;
      }

      $enabledCheckboxes.each(function() {
        $(this).on('change', function() {
          const $checkbox = $(this);

          if ($checkbox.is(':checked')) {
            $checkbox
              .closest('tr')
                .removeClass('disabled')
                .addClass('enabled');
          }
          else {
            $checkbox
              .closest('tr')
              .removeClass('enabled')
              .addClass('disabled');
          }

          console.log($(this));
          $(this).closest('tr.funding-provider-configuration-row')
        });
      });
      console.log($enabledCheckboxes);
    },
  }

})(jQuery, Drupal, drupalSettings)

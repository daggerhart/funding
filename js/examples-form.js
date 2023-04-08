(function($, Drupal) {

  function showContainer() {
    $('.funding-examples-container').show();
  }

  function hideContainer() {
    $('.funding-examples-container').hide();
  }

  function showAll() {
    showContainer();
    $('.funding-example-container').show();
  }

  function hideAll() {
    hideContainer();
    $('.funding-example-container').hide();
  }

  function showProviderExamples(providerId) {
    hideAll();
    showContainer();
    $('.funding-example-container--' + providerId).show();
  }

  Drupal.behaviors.fundingexamplesForm = {
    attach: function (context, settings) {
      let $examplesSelect = $(context).find('.funding-examples-select').once('funding_examples_form');
      if (!$examplesSelect.length) {
        return;
      }

      showProviderExamples($examplesSelect.val());

      $examplesSelect.on('change', function (event) {
        const providerId = $(this).val();
        if (providerId === '0') {
          hideAll();
          return;
        }

        showProviderExamples(providerId);
      });
    }
  }

})(jQuery, Drupal)

(function($, Drupal) {

  function showAll() {
    $('.funding-example-container').show();
  }

  function hideAll() {
    $('.funding-example-container').hide();
  }

  function showProviderExamples(providerId) {
    hideAll();
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
        showProviderExamples($(this).val());
      });
    }
  }

})(jQuery, Drupal)

(function($, Drupal) {

  function showContainer() {
    $('.funding-examples-all-container').show();
  }

  function hideContainer() {
    $('.funding-examples-all-container').hide();
  }

  function showAll() {
    showContainer();
    $('.funding-example').show();
  }

  function hideAll() {
    hideContainer();
    $('.funding-example').hide();
  }

  function showProviderExamples(providerId) {
    hideAll();
    showContainer();
    $('.funding-example--' + providerId).show();
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
        if (providerId === 'all') {
          showAll();
          return;
        }

        showProviderExamples(providerId);
      });
    }
  }

})(jQuery, Drupal)

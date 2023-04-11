<?php

namespace Drupal\funding\Form;

use Drupal\Core\Form\ConfirmFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a confirmation form before clearing out the examples.
 */
class ProviderConfigurationsResetConfirm extends ConfirmFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'funding_provider_configurations_reset_confirm';
  }

  /**
   * {@inheritdoc}
   */
  public function getQuestion() {
    return $this->t('Are you sure you want to reset funding provider configurations?');
  }

  /**
   * {@inheritdoc}
   */
  public function getDescription() {
    return $this->t('This will enable all funding providers.') . ' ' . parent::getDescription();
  }

  /**
   * {@inheritdoc}
   */
  public function getCancelUrl() {
    return new Url('funding.settings');
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->configFactory()->getEditable('funding.settings')
      ->set('providers_configurations', [])
      ->save();

    $this->messenger()->addStatus($this->t('Done!'));
    $form_state->setRedirectUrl(new Url('funding.settings'));
  }

}

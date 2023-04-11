<?php

namespace Drupal\funding\Form;

use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;
use Drupal\funding\Service\FundingProviderPluginManager;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Configure Funding settings for this site.
 */
class SettingsForm extends ConfigFormBase {

  /**
   * @var \Drupal\funding\Service\FundingProviderPluginManager
   */
  private FundingProviderPluginManager $pluginManager;

  /**
   * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
   * @param \Drupal\funding\Service\FundingProviderPluginManager $pluginManager
   */
  public function __construct(ConfigFactoryInterface $config_factory, FundingProviderPluginManager $pluginManager) {
    parent::__construct($config_factory);
    $this->pluginManager = $pluginManager;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('config.factory'),
      $container->get('plugin.manager.funding_provider')
    );
  }


  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'funding_settings';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return ['funding.settings'];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['providers'] = [
      '#type' => 'fieldset',
      '#title' => $this->t('Providers Configuration'),
      '#description' => $this->t('Change the order the providers are rendered, or disable unwanted providers.'),
      '#description_display' => 'before',
      '#attributes' => [
        'class' => ['funding-settings-form'],
      ],
      '#attached' => [
        'library' => ['funding/settings-form']
      ],
      // Sortable config table.
      'providers_configurations' => [
        '#type' => 'table',
        '#header' => [
          $this->t('Provider'),
          $this->t('Description'),
          $this->t('Enabled'),
          $this->t('Weight'),
        ],
        '#empty' => $this->t('Sorry, There are no items!'),
        '#tabledrag' => [
          [
            'action' => 'order',
            'relationship' => 'sibling',
            'group' => 'table-sort-weight',
          ],
        ],
      ]
    ];

    foreach ($this->pluginManager->getFundingProviders() as $provider) {
      $row = [
        '#attributes' => [
          'class' => [
            'draggable',
            ($provider->enabled() ? 'enabled' : 'disabled')
          ],
        ],
        '#weight' => $provider->weight(),
        'name' => [
          '#markup' => "<strong>" . $provider->label() . "</strong>",
        ],
        'description' => [
          '#markup' => str_replace($provider->id(), "<code>{$provider->id()}</code>", $provider->description()),
        ],
        'enabled' => [
          '#type' => 'checkbox',
          '#default_value' => $provider->enabled(),
          '#attributes' => [
            'class' => ['finding-provider-enabled-checkbox'],
          ],
        ],
        'weight' => [
          '#type' => 'weight',
          '#title' => $this->t('Weight for @title', ['@title' => $provider->label()]),
          '#title_display' => 'invisible',
          '#default_value' => $provider->weight(),
          '#attributes' => ['class' => ['table-sort-weight']],
        ]
      ];
      $form['providers']['providers_configurations'][$provider->id()] = $row;
    }

    $form['actions'] = [
      '#type' => 'actions',
      'submit' => [
        '#type' => 'submit',
        '#value' => $this->t('Save All Changes'),
      ],
      'reset' => [
        '#type' => 'submit',
        '#value'  => $this->t('Reset'),
        '#attributes' => [
          'title' => $this->t('Reset Provider Configurations to defaults'),
        ],
        '#submit' => ['::submitReset'],
        '#limit_validation_errors' => [],
      ],
      'cancel' => [
        '#type' => 'submit',
        '#value'  => $this->t('Cancel'),
        '#attributes' => [
          'title' => $this->t('Refresh the page without saving.'),
        ],
        '#submit' => ['::submitCancel'],
        '#limit_validation_errors' => [],
      ],
    ];

    return parent::buildForm($form, $form_state);
  }

  /**
   * Form submission handler for the 'Reset' action.
   *
   * @param array $form
   *   An associative array containing the structure of the form.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   The current state of the form.
   */
  public function submitReset(array &$form, FormStateInterface $form_state) {
    $form_state->setRedirect('funding.provider_configurations_reset_confirm');
  }

  /**
   * Form submission handler for the 'Cancel' action.
   *
   * @param array $form
   *   An associative array containing the structure of the form.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   The current state of the form.
   */
  public function submitCancel(array &$form, FormStateInterface $form_state) {
    $this->messenger()->addStatus($this->t('Changes discarded.'));
    $form_state->setRedirect('funding.settings');
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {}

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->config('funding.settings')
      ->set('providers_configurations', $form_state->getValue('providers_configurations'))
      ->save();

    parent::submitForm($form, $form_state);
  }

}

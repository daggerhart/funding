<?php

namespace Drupal\funding\Form;

use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
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
          'class' => ['draggable'],
        ],
        '#weight' => $provider->weight(),
        'name' => [
          '#markup' => $provider->label(),
        ],
        'description' => [
          '#markup' => $provider->description(),
        ],
        'enabled' => [
          '#type' => 'checkbox',
          '#default_value' => $provider->enabled(),
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
    ];

    return parent::buildForm($form, $form_state);
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

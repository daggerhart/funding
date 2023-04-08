<?php

namespace Drupal\funding\Plugin\Field\FieldWidget;

use Drupal\Core\Render\Markup;
use Drupal\Core\Serialization\Yaml;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\funding\Service\FundingProviderPluginManager;
use Drupal\funding\Service\FundingProviderProcessorInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Plugin implementation of the 'funding' widget.
 *
 * @FieldWidget(
 *   id = "funding",
 *   label = @Translation("Funding YAML"),
 *   field_types = {
 *     "funding"
 *   }
 * )
 */
class FundingWidget extends WidgetBase {

  /**
   * @var \Drupal\funding\Service\FundingProviderProcessorInterface
   */
  private FundingProviderProcessorInterface $providerProcessor;

  /**
   * @var \Drupal\funding\Service\FundingProviderPluginManager
   */
  private FundingProviderPluginManager $manager;


  public function __construct(
    $plugin_id,
    $plugin_definition,
    array $configuration,
    FundingProviderProcessorInterface $providerProcessor,
    FundingProviderPluginManager $manager
  ) {
    $this->providerProcessor = $providerProcessor;
    $this->manager = $manager;

    parent::__construct(
      $plugin_id,
      $plugin_definition,
      $configuration['field_definition'],
      $configuration['settings'],
      $configuration['third_party_settings']
    );
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $plugin_id,
      $plugin_definition,
      $configuration,
      $container->get('funding.provider_processor'),
      $container->get('plugin.manager.funding_provider')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state) {
    $value = isset($items[$delta]->value) ? $items[$delta]->value : '';
    $element += [
      '#type' => 'textarea',
      '#default_value' => $value,
      '#element_validate' => [
        [$this, 'validateFunding'],
      ],
      '#rows' => 8,
      '#attributes' => [
        'class' => [
          'funding-yaml-container',
        ],
      ],
    ];

    $example_options = [
      'all' => $this->t('All'),
    ];
    $examples_render = [
      '#type' => 'container',
      '#attributes' => [
        'class' => [
          'funding-examples-all-container',
        ],
      ],
    ];
    foreach ($this->manager->getProviders() as $provider_id => $provider) {
      $example_options[$provider_id] = $provider->label();
      $provider_examples_render = [
        '#type' => 'container',
        '#attributes' => [
          'class' => [
            'funding-example-single-container',
            'funding-example-single-container--all',
            'funding-example-single-container--' . $provider_id,
          ],
        ],
      ];
      foreach ($provider->examples() as $i => $example_content) {
        if (str_contains($example_content, "\n")) {
          $example_content = Yaml::encode(Yaml::decode(trim($example_content)));
        }

        $example_content_render = [
          '#type' => 'html_tag',
          '#tag' => 'span',
          '#value' => Markup::create("<span>{$example_content}</span>"),
          '#attributes' => [
            'class' => [
              'funding-example',
              'funding-example--' . $provider_id,
              'funding-example--' . $provider_id . '--' . $i,
            ],
          ],
        ];

        $provider_examples_render[$provider_id . '_' . $i] = $example_content_render;
      }

      $examples_render[$provider_id] = $provider_examples_render;
    }

    ksort($example_options);
    return [
      'value' => $element,
      'examples_select' => [
        '#type' => 'select',
        '#title' => $this->t('Funding Examples'),
        '#attributes' => [
          'class' => ['funding-examples-select'],
        ],
        '#options' => $example_options,
        '#empty_value' => 0,
        '#attached' => [
          'library' => [
            'funding/examples-form'
          ],
        ],
      ],
      'examples' => $examples_render,
    ];
  }

  /**
   * Validate the funding yaml field.
   */
  public function validateFunding(&$element, FormStateInterface $form_state, $form) {
    $value = $element['#value'];
    if (strlen($value) === 0) {
      $form_state->setValueForElement($element, '');
      return;
    }

    $valid = FALSE;
    $rows = [];
    try {
      $rows = Yaml::decode($value);
      $valid = $this->providerProcessor->rowsAreValid($rows);
    }
    catch (\Exception $exception) {
      $form_state->setError($element, $this->t('Unable to parse the YAML string: %message', [
        '%message', $exception->getMessage(),
      ]));
    }

    if ($rows) {
      $results = $this->providerProcessor->validateRows($rows);
      foreach ($results as $key => $result) {
        if ($result !== TRUE) {
          /** @var \Exception $result */
          $this->messenger()->addError($this->t('Provider @provider: @message', [
            '@provider' => $key,
            '@message' => $result->getMessage()
          ]));
        }
      }
    }

    if (!$valid) {
      $form_state->setError($element, 'Invalid data found.');
    }
  }

}

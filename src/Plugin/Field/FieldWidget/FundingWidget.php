<?php

namespace Drupal\funding\Plugin\Field\FieldWidget;

use Drupal\Core\Field\FieldDefinitionInterface;
use Drupal\Core\Serialization\Yaml;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Component\Serialization\Exception\InvalidDataTypeException;
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
   * {@inheritdoc}
   */
  public function __construct($plugin_id, $plugin_definition, array $configuration, FundingProviderProcessorInterface $providerProcessor) {
    $this->providerProcessor = $providerProcessor;

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
      $container->get('funding.provider_processor')
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
      '#description' => $this->t(<<<YAML
        open_collective-embed:
            type: button
            slug: funding-tools
            verb: donate
            color: blue
        open_collective-embed:
            type: image
            slug: funding-tools
            verb: contribute
            color: white
        YAML),
    ];
    return ['value' => $element];
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
    try {
      $rows = Yaml::decode($value);
      $valid = $this->providerProcessor->rowsAreValid($rows);
    }
    catch (\Exception $exception) {
      $form_state->setError($element, $this->t('Unable to parse the YAML string: %message', [
        '%message', $exception->getMessage(),
      ]));
    }

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

    if (!$valid) {
      $form_state->setError($element, 'Invalid data found.');
    }
  }

}

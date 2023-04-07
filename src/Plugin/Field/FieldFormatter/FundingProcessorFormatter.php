<?php

namespace Drupal\funding\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;
use Drupal\funding\Service\FundingProviderProcessorInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Plugin implementation of the 'Funding Processor' formatter.
 *
 * @FieldFormatter(
 *   id = "funding_funding_processor",
 *   label = @Translation("Funding Processor"),
 *   field_types = {
 *     "funding"
 *   }
 * )
 */
class FundingProcessorFormatter extends FormatterBase {

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
      $configuration['label'],
      $configuration['view_mode'],
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
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $element = [];

    foreach ($items as $delta => $item) {
      $element[$delta] = $this->providerProcessor->processYaml($item->value);
    }

    return $element;
  }

}

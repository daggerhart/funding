<?php

namespace Drupal\funding\Plugin\Field\FieldFormatter;

use Drupal\Component\Serialization\YamlSymfony;
use Drupal\Component\Utility\Html;
use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Field\FieldItemListInterface;

/**
 * Plugin implementation of the 'funding_yaml' formatter.
 *
 * @FieldFormatter(
 *   id = "funding_yaml",
 *   label = @Translation("Funding YAML (debug)"),
 *   field_types = {
 *     "funding"
 *   }
 * )
 */
class FundingYamlFormatter extends FormatterBase {

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $elements = [];

    foreach ($items as $delta => $item) {
      $elements[$delta] = [
        '#type' => 'container',
        '#attributes' => [
          'class' => ['funding-examples-all-container'],
        ],
        'example' => [
          '#theme' => 'funding_example',
          '#content' => Html::escape(YamlSymfony::encode(YamlSymfony::decode($item->value))),
          '#provider' => 0,
          '#index' => 0,
        ],
      ];
    }

    return $elements;
  }

}

<?php

namespace Drupal\funding\Plugin\Field\FieldFormatter;

use Drupal\Core\Serialization\Yaml;
use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Field\FieldItemListInterface;

/**
 * Plugin implementation of the 'funding_button' formatter.
 *
 * @FieldFormatter(
 *   id = "funding_button",
 *   label = @Translation("Funding buttons"),
 *   field_types = {
 *     "funding"
 *   }
 * )
 */
class FundingButtonFormatter extends FormatterBase {

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $elements = [];

    foreach ($items as $delta => $item) {
      $elements[$delta] = [
        '#type' => 'html_tag',
        '#tag' => 'p',
        '#value' => Yaml::encode(Yaml::decode($item->value)),
      ];
    }

    return $elements;
  }

}

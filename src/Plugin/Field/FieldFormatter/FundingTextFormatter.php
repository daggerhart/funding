<?php

namespace Drupal\funding\Plugin\Field\FieldFormatter;

use Drupal\Core\Serialization\Yaml;
use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Field\FieldItemListInterface;

/**
 * Plugin implementation of the 'funding_text' formatter.
 *
 * @FieldFormatter(
 *   id = "funding_text",
 *   label = @Translation("Funding text box"),
 *   field_types = {
 *     "funding"
 *   }
 * )
 */
class FundingTextFormatter extends FormatterBase {

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

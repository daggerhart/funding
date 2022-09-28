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
 *   module = "funding",
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
        '#value' => Yaml::dump(Yaml::parse($item['value'], Yaml::PARSE_EXCEPTION_ON_INVALID_TYPE), 2, 4, Yaml::DUMP_EXCEPTION_ON_INVALID_TYPE),
      ];
    }

    return $elements;
  }

}

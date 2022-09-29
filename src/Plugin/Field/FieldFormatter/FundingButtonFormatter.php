<?php

namespace Drupal\funding\Plugin\Field\FieldFormatter;

use Drupal\Component\Utility\Html;
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
      // @todo copy logic from Drupal 7 module, to allow other modules to display based on provider names
      // @todo we should not need Html::escape here in the future
      $elements[$delta] = [
        '#type' => 'html_tag',
        '#tag' => 'pre',
        '#value' => Html::escape(Yaml::encode(Yaml::decode($item->value))),
      ];
    }

    return $elements;
  }

}

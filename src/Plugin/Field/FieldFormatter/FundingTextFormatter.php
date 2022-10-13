<?php

namespace Drupal\funding\Plugin\Field\FieldFormatter;

use Drupal\Component\Utility\Html;
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

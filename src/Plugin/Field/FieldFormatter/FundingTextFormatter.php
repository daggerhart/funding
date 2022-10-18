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
      // @todo copy logic from Drupal 7 module, to allow other modules to display based on provider names
      $yaml_items = Yaml::decode($item->value);
      foreach ($yaml_items as $yaml_item_key => $yaml_item) {
        if ($yaml_item_key == 'open_collective-button') {
          $elements[$delta] = [
            '#theme' => 'funding_text_open_collective',
            '#slug' => $yaml_item['slug'],
            '#verb' => $yaml_item['verb'],
          ];
        }
      }
    }

    return $elements;
  }

}

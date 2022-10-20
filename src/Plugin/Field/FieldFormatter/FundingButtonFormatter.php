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
      $yaml_items = Yaml::decode($item->value);
      foreach ($yaml_items as $yaml_item_key => $yaml_item) {
        if ($yaml_item_key == 'open_collective-button') {
          $elements[$delta] = [
            '#theme' => 'funding_text_open_collective_button',
            '#slug' => $yaml_item['slug'],
            '#verb' => $yaml_item['verb'],
            '#color' => $yaml_item['color'],
          ];
        }
        elseif ($yaml_item_key == 'open_collective' && is_string($yaml_item)) {
          $elements[$delta] = [
            '#theme' => 'funding_text_open_collective',
            '#slug' => $yaml_item,
            '#verb' => 'donate',
          ];
        }
      }
    }

    return $elements;
  }

}

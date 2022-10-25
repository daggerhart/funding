<?php

namespace Drupal\funding\Plugin\Field\FieldFormatter;

use Drupal\Core\Serialization\Yaml;
use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Field\FieldItemListInterface;

/**
 * Plugin implementation of the 'funding_embed' formatter.
 *
 * @FieldFormatter(
 *   id = "funding_embed",
 *   label = @Translation("Funding embed"),
 *   field_types = {
 *     "funding"
 *   }
 * )
 */
class FundingEmbedFormatter extends FormatterBase {

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $elements = [];

    foreach ($items as $delta => $item) {
      $yaml_items = Yaml::decode($item->value);
      foreach ($yaml_items as $yaml_item_key => $yaml_item) {
        if ($yaml_item_key == 'open_collective-embed') {
          $elements[$delta] = [
            '#theme' => $this->getOpenCollectiveThemeByType($yaml_item['type']),
            '#slug' => $yaml_item['slug'],
            '#verb' => $yaml_item['verb'],
            '#color' => $yaml_item['color'],
          ];
        }
        elseif ($yaml_item_key == 'open_collective' && is_string($yaml_item)) {
          $elements[$delta] = [
            // @todo make this default configurable in widget form?
            '#theme' => 'funding_button_open_collective',
            '#slug' => $yaml_item,
            // @todo make this default configurable in widget form?
            '#verb' => 'donate',
            // @todo make this default configurable in widget form?
            '#color' => 'blue',
          ];
        }
      }
    }

    return $elements;
  }

  /**
   * Map a theme function to an Open Collective widget type.
   */
  private function getOpenCollectiveThemeByType($type) {
    $types = [
      // @todo add all the Open Collective widget types.
      'image' => 'funding_image_open_collective',
      'js' => 'funding_js_open_collective',
    ];
    return $types[$type];
  }

}

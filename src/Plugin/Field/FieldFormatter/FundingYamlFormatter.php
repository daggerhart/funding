<?php

namespace Drupal\funding\Plugin\Field\FieldFormatter;

use Drupal\Component\Utility\Html;
use Drupal\Core\Serialization\Yaml;
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
        '#type' => 'html_tag',
        '#tag' => 'pre',
        '#value' => Html::escape(Yaml::encode(Yaml::decode($item->value))),
      ];
    }

    return $elements;
  }

}

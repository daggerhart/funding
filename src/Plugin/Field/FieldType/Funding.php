<?php

namespace Drupal\funding\Plugin\Field\FieldType;

use Drupal\Core\Field\FieldItemBase;
use Drupal\Core\Field\FieldStorageDefinitionInterface;
use Drupal\Core\TypedData\DataDefinition;

/**
 * Plugin implementation of the 'funding' field type.
 *
 * @todo determine if other field types would be needed, or just other widgets/formatters
 *
 * @FieldType(
 *   id = "funding",
 *   label = @Translation("Funding YAML"),
 *   description = @Translation("Accepts YAML describing crowdfunding accounts."),
 *   default_widget = "funding",
 *   default_formatter = "funding_processor"
 * )
 */
class Funding extends FieldItemBase {

  /**
   * {@inheritdoc}
   */
  public static function schema(FieldStorageDefinitionInterface $field_definition) {
    return [
      'columns' => [
        'value' => [
          'type' => 'text',
          'size' => 'big',
          'not null' => FALSE,
        ],
      ],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function isEmpty() {
    $value = $this->get('value')->getValue();
    return $value === NULL || $value === '';
  }

  /**
   * {@inheritdoc}
   */
  public static function propertyDefinitions(FieldStorageDefinitionInterface $field_definition) {
    $properties['value'] = DataDefinition::create('string')
      ->setLabel(t('Funding YAML value'));

    return $properties;
  }

}

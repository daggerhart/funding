<?php

namespace Drupal\funding\Plugin\Field\FieldWidget;

use Drupal\Core\Serialization\Yaml;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Component\Serialization\Exception\InvalidDataTypeException;

/**
 * Plugin implementation of the 'funding' widget.
 *
 * @FieldWidget(
 *   id = "funding",
 *   label = @Translation("Funding YAML"),
 *   field_types = {
 *     "funding"
 *   }
 * )
 */
class FundingWidget extends WidgetBase {

  /**
   * {@inheritdoc}
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state) {
    $value = isset($items[$delta]->value) ? $items[$delta]->value : '';
    $element += [
      '#type' => 'textarea',
      '#default_value' => $value,
      '#element_validate' => [
        [
          static::class,
          'validateFunding',
        ],
      ],
      '#description' => $this->t(<<<YAML
        open_collective-embed:
            type: button
            slug: funding-tools
            verb: donate
            color: blue
        open_collective-embed:
            type: image
            slug: funding-tools
            verb: contribute
            color: white
        YAML),
    ];
    return ['value' => $element];
  }

  /**
   * Validate the funding yaml field.
   */
  public static function validateFunding(&$element, FormStateInterface $form_state, $form) {
    $message = '';
    $value = $element['#value'];
    if (strlen($value) === 0) {
      $form_state->setValueForElement($element, '');
      return;
    }
    try {
      $items = Yaml::decode($value);
//      // @todo allow other modules to validate based on provider names, maybe with annotations per provider name
//      if (is_array($items)) {
//        foreach ($items as $provider => $username) {
//          if (is_array($username) && !isset($username['slug'])) {
//            $message = t('No "slug:" provided for array: %provider',
//              ['%provider', $provider]
//            );
//          }
//          elseif (empty($username)) {
//            $message = t('No username provided for provider: %provider',
//              ['%provider', $provider]
//            );
//          }
//        }
//      }
//      else {
//        $message = t('Unable to parse the YAML array. Please check the format and try again.');
//      }
    }
    catch (InvalidDataTypeException $e) {
      $message = $e->getMessage();
    }
    catch (ParseException $e) {
      $message = t('Unable to parse the YAML string: %message',
        ['%message', $e->getMessage()]
      );
    }

    if ($message) {
      $form_state->setError($element, $message);
    }
  }

}

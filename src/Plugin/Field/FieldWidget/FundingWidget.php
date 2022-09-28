<?php

namespace Drupal\funding\Plugin\Field\FieldWidget;

use Drupal\Core\Serialization\Yaml;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Plugin implementation of the 'funding' widget.
 *
 * @FieldWidget(
 *   id = "funding",
 *   module = "funding",
 *   label = @Translation("Funding YAML"),
 *   field_types = {
 *     "funding/"
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
        [$this, 'validate'],
      ],
    ];
    return ['value' => $element];
  }

  /**
   * Validate the color text field.
   */
  public function validate($element, FormStateInterface $form_state) {
    $message = '';
    $value = $element['#value'];
    if (strlen($value) === 0) {
      $form_state->setValueForElement($element, '');
      return;
    }
    try {
      $items = Yaml::parse($item['value']);
      if (is_array($items)) {
        foreach ($items as $provider => $username) {
          if (is_array($username) && !isset($username['slug'])) {
            $message = $this->t('No "slug:" provided for array: %provider',
              ['%provider', $provider]
            );
          }
          elseif (empty($username)) {
            $message = $this->t('No username provided for provider: %provider',
              ['%provider', $provider]
            );
          }
        }
      }
      else {
        $message = $this->t('Unable to parse the YAML array. Please check the format and try again.');
      }
    }
    catch (ParseException $e) {
      $message = $this->t('Unable to parse the YAML string: %message',
        ['%message', $e->getMessage()]
      );
    }

    if ($message) {
      $form_state->setError($element, $message);
    }
  }

}

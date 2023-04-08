<?php

namespace Drupal\funding\Plugin\Funding\Provider;

use Drupal\funding\Exception\InvalidFundingProviderData;
use Drupal\funding\Plugin\Funding\FundingProviderOpenCollectiveBase;

/**
 * Plugin implementation of the funding_provider.
 *
 * @FundingProvider(
 *   id = "open_collective_button",
 *   label = @Translation("Open Collective Button"),
 *   description = @Translation("Handles processing for the open_collective_button funding namespace.")
 * )
 */
class OpenCollectiveEmbedButton extends FundingProviderOpenCollectiveBase {

  /**
   * {@inheritdoc}
   */
  public function examples(): array {
    return [
      'open_collective_button: funding-tools',
      'open_collective_button:
         collective: funding-tools
         color: blue
         verb: contribute',
      'open_collective_button:
         collective: funding-tools
         color: white
         verb: donate',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function validate($data): bool {
    parent::validate($data);

    if (is_array($data)) {
      $this->validateOptionalPropertyIsString($data, 'color');
      $this->validateOptionalPropertyIsString($data, 'verb');

      if (isset($data['color'])) {
        if (!$this->openCollectiveEnums->keyExists($data['color'], $this->openCollectiveEnums->embedButtonColors())) {
          throw new InvalidFundingProviderData("{$data['color']} is not a valid button color. Valid button colors are: " . implode(', ', array_keys($this->openCollectiveEnums->embedButtonColors())));
        }
      }

      if (isset($data['verb'])) {
        if (!$this->openCollectiveEnums->keyExists($data['verb'], $this->openCollectiveEnums->embedButtonVerbs())) {
          throw new InvalidFundingProviderData("{$data['verb']} is not a valid button verb. Valid button verbs are: " . implode(', ', array_keys($this->openCollectiveEnums->embedButtonVerbs())));
        }
      }
    }

    return TRUE;
  }

  /**
   * {@inheritdoc}
   */
  public function build($data): array {
    if (is_string($data)) {
      return [
        '#theme' => 'funding_open_collective_embed_button',
        '#collective' => $data,
      ];
    }

    if (is_array($data)) {
      return [
        '#theme' => 'funding_open_collective_embed_button',
        '#collective' => $data['collective'],
        '#color' => $data['color'] ?? 'blue',
        '#verb' => $data['verb'] ?? 'contribute',
      ];
    }

    return [];
  }

}

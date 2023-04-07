<?php

namespace Drupal\funding\Plugin\Funding\Provider;

use Drupal\funding\FundingProviderBase;

/**
 * Plugin implementation of the funding_provider.
 *
 * @FundingProvider(
 *   id = "patreon",
 *   label = @Translation("Patreon"),
 *   description = @Translation("Handles processing for the patreon funding namespace.")
 * )
 */
class Patreon extends FundingProviderBase {

  /**
   * {@inheritdoc}
   */
  public function build($data): array {
    if (is_string($data)) {
      return [
        '#theme' => 'funding_link',
        '#provider' => $this->id(),
        '#content' => $data,
        '#url' => 'https://www.patreon.com/' . $data,
      ];
    }

    return [];
  }

}

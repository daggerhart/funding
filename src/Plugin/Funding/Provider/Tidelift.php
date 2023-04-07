<?php

namespace Drupal\funding\Plugin\Funding\Provider;

use Drupal\funding\Plugin\Funding\FundingProviderBase;

/**
 * Plugin implementation of the funding_provider.
 *
 * @FundingProvider(
 *   id = "tidelift",
 *   label = @Translation("Tidelift"),
 *   description = @Translation("Handles processing for the tidelift funding namespace.")
 * )
 */
class Tidelift extends FundingProviderBase {

  /**
   * {@inheritdoc}
   */
  public function build($data): array {
    if (is_string($data)) {
      return [
        '#theme' => 'funding_link',
        '#provider' => $this->id(),
        '#content' => $data,
        // @todo - no idea if this is the right url.
        '#url' => 'https://www.tidelift.com/' . $data,
      ];
    }

    return [];
  }

}

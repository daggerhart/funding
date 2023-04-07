<?php

namespace Drupal\funding\Plugin\Funding\Provider;

use Drupal\funding\FundingProviderBase;

/**
 * Plugin implementation of the funding_provider.
 *
 * @FundingProvider(
 *   id = "open_collective",
 *   label = @Translation("Open Collective"),
 *   description = @Translation("Handles processing for the open_collective funding namespace.")
 * )
 */
class OpenCollective extends FundingProviderBase {

  /**
   * {@inheritdoc}
   */
  public function build($data): array {
    if (is_string($data)) {
      return [
        '#theme' => 'funding_link',
        '#provider' => $this->id(),
        '#content' => $data,
        '#url' => 'https://opencollective.com/' . $data,
      ];
    }

    return [];
  }

}

<?php

namespace Drupal\funding\Plugin\Funding\Provider;

use Drupal\funding\Plugin\Funding\FundingProviderBase;

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

  public function examples(): array {
    return [
      'open_collective: funding-tools',
    ];
  }

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

<?php

namespace Drupal\funding\Plugin\Funding\Provider;

use Drupal\funding\FundingProviderPluginBase;

/**
 * Plugin implementation of the funding_provider.
 *
 * @FundingProvider(
 *   id = "hirepage",
 *   label = @Translation("Hirepage (formerly Otechie)"),
 *   description = @Translation("Handles processing for the hirepage funding namespace.")
 * )
 */
class Hirepage extends FundingProviderPluginBase {

  /**
   * {@inheritdoc}
   */
  public function build($data): array {
    if (is_string($data)) {
      return [
        '#theme' => 'funding_link',
        '#provider' => $this->id(),
        '#content' => $data,
        '#url' => 'https://hire.page/' . $data,
      ];
    }

    return [];
  }

}

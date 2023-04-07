<?php

namespace Drupal\funding\Plugin\Funding\Provider;

use Drupal\funding\FundingProviderBase;

/**
 * Plugin implementation of the funding_provider.
 *
 * @FundingProvider(
 *   id = "ko_fi",
 *   label = @Translation("Ko-Fi"),
 *   description = @Translation("Handles processing for the ko_fi funding namespace.")
 * )
 */
class KoFi extends FundingProviderBase {

  /**
   * {@inheritdoc}
   */
  public function build($data): array {
    if (is_string($data)) {
      return [
        '#theme' => 'funding_link',
        '#provider' => $this->id(),
        '#content' => $data,
        '#url' => 'https://ko-fi.com/' . $data,
      ];
    }

    return [];
  }

}

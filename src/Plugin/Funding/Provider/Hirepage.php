<?php

namespace Drupal\funding\Plugin\Funding\Provider;

use Drupal\Core\Url;
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
        '#type' => 'link',
        '#title' => $data,
        '#url' => Url::fromUri('https://hire.page/' . $data),
      ];
    }

    return [];
  }

}

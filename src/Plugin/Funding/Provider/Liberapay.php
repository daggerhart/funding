<?php

namespace Drupal\funding\Plugin\Funding\Provider;

use Drupal\Core\Url;
use Drupal\funding\FundingProviderPluginBase;

/**
 * Plugin implementation of the funding_provider.
 *
 * @FundingProvider(
 *   id = "liberapay",
 *   label = @Translation("Liberapay"),
 *   description = @Translation("Handles processing for the liberapay funding namespace.")
 * )
 */
class Liberapay extends FundingProviderPluginBase {

  /**
   * {@inheritdoc}
   */
  public function build($data): array {
    if (is_string($data)) {
      return [
        '#type' => 'link',
        '#title' => $data,
        '#url' => Url::fromUri('https://liberapay.com/' . $data),
      ];
    }

    return [];
  }

}

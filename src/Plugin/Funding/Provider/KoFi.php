<?php

namespace Drupal\funding\Plugin\Funding\Provider;

use Drupal\Core\Url;
use Drupal\funding\FundingProviderPluginBase;

/**
 * Plugin implementation of the funding_provider.
 *
 * @FundingProvider(
 *   id = "ko_fi",
 *   label = @Translation("Ko-Fi"),
 *   description = @Translation("Handles processing for the ko_fi funding namespace.")
 * )
 */
class KoFi extends FundingProviderPluginBase {

  /**
   * {@inheritdoc}
   */
  public function build($data): array {
    if (is_string($data)) {
      return [
        '#type' => 'link',
        '#title' => $data,
        '#url' => Url::fromUri('https://ko-fi.com/' . $data),
      ];
    }

    return [];
  }

}

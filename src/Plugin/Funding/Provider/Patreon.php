<?php

namespace Drupal\funding\Plugin\Funding\Provider;

use Drupal\Core\Url;
use Drupal\funding\FundingProviderPluginBase;

/**
 * Plugin implementation of the funding_provider.
 *
 * @FundingProvider(
 *   id = "patreon",
 *   label = @Translation("Patreon"),
 *   description = @Translation("Handles processing for the patreon funding namespace.")
 * )
 */
class Patreon extends FundingProviderPluginBase {

  /**
   * {@inheritdoc}
   */
  public function build($data): array {
    if (is_string($data)) {
      return [
        '#type' => 'link',
        '#title' => $data,
        '#url' => Url::fromUri('https://www.patreon.com/' . $data),
      ];
    }

    return [];
  }

}

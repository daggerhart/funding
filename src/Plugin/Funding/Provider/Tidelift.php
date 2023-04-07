<?php

namespace Drupal\funding\Plugin\Funding\Provider;

use Drupal\Core\Url;
use Drupal\funding\FundingProviderPluginBase;

/**
 * Plugin implementation of the funding_provider.
 *
 * @FundingProvider(
 *   id = "tidelift",
 *   label = @Translation("Tidelift"),
 *   description = @Translation("Handles processing for the tidelift funding namespace.")
 * )
 */
class Tidelift extends FundingProviderPluginBase {

  /**
   * {@inheritdoc}
   */
  public function build($data): array {
    if (is_string($data)) {
      return [
        '#type' => 'link',
        '#title' => $data,
        // @todo - no idea if this is the right url.
        '#url' => Url::fromUri('https://www.tidelift.com/' . $data),
      ];
    }

    return [];
  }

}

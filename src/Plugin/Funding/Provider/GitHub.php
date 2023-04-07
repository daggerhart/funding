<?php

namespace Drupal\funding\Plugin\Funding\Provider;

use Drupal\Core\Url;
use Drupal\funding\FundingProviderPluginBase;

/**
 * Plugin implementation of the funding_provider.
 *
 * @FundingProvider(
 *   id = "github",
 *   label = @Translation("GitHub"),
 *   description = @Translation("Handles processing for the github funding namespace.")
 * )
 */
class GitHub extends FundingProviderPluginBase {

  /**
   * {@inheritdoc}
   */
  public function build($data): array {
    if (is_string($data)) {
      $data = [$data];
    }

    $build = [];
    foreach ($data as $item) {
      $build[] = [
        '#type' => 'link',
        '#title' => $item,
        '#url' => Url::fromUri('https://github.com/' . $item),
      ];
    }

    return $build;
  }

}

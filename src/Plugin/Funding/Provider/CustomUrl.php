<?php

namespace Drupal\funding\Plugin\Funding\Provider;

use Drupal\Core\Url;
use Drupal\funding\FundingProviderPluginBase;

/**
 * Plugin implementation of the funding_provider.
 *
 * @FundingProvider(
 *   id = "custom",
 *   label = @Translation("Custom Url"),
 *   description = @Translation("Handles processing for the custom funding namespace.")
 * )
 */
class CustomUrl extends FundingProviderPluginBase {

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
        '#url' => Url::fromUri($item),
      ];
    }

    return $build;
  }

}

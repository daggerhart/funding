<?php

namespace Drupal\funding\Plugin\Funding\Provider;

use Drupal\funding\Plugin\Funding\FundingProviderBase;

/**
 * Plugin implementation of the funding_provider.
 *
 * @FundingProvider(
 *   id = "custom",
 *   label = @Translation("Custom Url"),
 *   description = @Translation("Handles processing for the custom funding namespace.")
 * )
 */
class CustomUrl extends FundingProviderBase {

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
        '#theme' => 'funding_link',
        '#provider' => $this->id(),
        '#content' => $item,
        '#url' => $item,
      ];
    }

    return $build;
  }

}

<?php

namespace Drupal\funding\Plugin\Funding\Provider;

use Drupal\Core\Url;
use Drupal\funding\Exception\InvalidFundingProviderData;
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
  public function validate($data): bool {
    if (!is_array($data)) {
      $data = [$data];
    }

    foreach ($data as $i => $item) {
      try {
        Url::fromUri($item);
      }
      catch (\Exception $exception) {
        throw new InvalidFundingProviderData(
          strtr('Custom Url #@i provided is invalid.', [
            '@i' => ($i + 1),
          ]),
          0,
          $exception
        );
      }
    }

    return TRUE;
  }

  /**
   * {@inheritdoc}
   */
  public function build($data): array {
    if (!is_array($data)) {
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

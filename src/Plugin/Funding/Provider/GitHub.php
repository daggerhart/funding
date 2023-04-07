<?php

namespace Drupal\funding\Plugin\Funding\Provider;

use Drupal\funding\Exception\InvalidFundingProviderData;
use Drupal\funding\Plugin\Funding\FundingProviderBase;

/**
 * Plugin implementation of the funding_provider.
 *
 * @FundingProvider(
 *   id = "github",
 *   label = @Translation("GitHub"),
 *   description = @Translation("Handles processing for the github funding namespace.")
 * )
 */
class GitHub extends FundingProviderBase {

  /**
   * {@inheritdoc}
   */
  public function validate($data): bool {
    if (!is_array($data)) {
      $data = [$data];
    }

    foreach ($data as $i => $item) {
      if (!is_string($item)) {
        throw new InvalidFundingProviderData(
         strtr('Github ID #@i provided does not appear validate.', [
            '@i' => ($i + 1),
          ])
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
        '#url' => 'https://github.com/' . $item,
      ];
    }

    return $build;
  }

}

<?php

namespace Drupal\funding\Plugin\Funding\Provider;

use Drupal\Core\Url;
use Drupal\funding\FundingProviderPluginBase;

/**
 * Plugin implementation of the funding_provider.
 *
 * @FundingProvider(
 *   id = "open_collective",
 *   label = @Translation("Open Collective"),
 *   description = @Translation("Handles processing for the open_collective funding namespace.")
 * )
 */
class OpenCollective extends FundingProviderPluginBase {

  /**
   * {@inheritdoc}
   */
  public function build($data): array {
    if (is_string($data)) {
      return [
        '#type' => 'link',
        '#title' => $data,
        '#url' => Url::fromUri('https://opencollective.com/' . $data),
      ];
    }

    return [];
  }

}

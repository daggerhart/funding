<?php

namespace Drupal\funding\Plugin\Funding\Provider;

use Drupal\Core\Url;
use Drupal\funding\FundingProviderPluginBase;

/**
 * Plugin implementation of the funding_provider.
 *
 * @FundingProvider(
 *   id = "community_bridge",
 *   label = @Translation("LFX Mentorship (previously Community Bridge)"),
 *   description = @Translation("Handles processing for the community_bridge funding namespace.")
 * )
 */
class LfxMentorship extends FundingProviderPluginBase {

  /**
   * {@inheritdoc}
   */
  public function build($data): array {
    if (is_string($data)) {
      return [
        '#type' => 'link',
        '#title' => $data,
        // @todo - no idea what the url should be.
        '#url' => Url::fromUri('https://lfx.linuxfoundation.org/' . $data),
      ];
    }

    return [];
  }

}

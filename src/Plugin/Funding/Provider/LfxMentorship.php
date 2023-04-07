<?php

namespace Drupal\funding\Plugin\Funding\Provider;

use Drupal\funding\FundingProviderBase;

/**
 * Plugin implementation of the funding_provider.
 *
 * @FundingProvider(
 *   id = "community_bridge",
 *   label = @Translation("LFX Mentorship (previously Community Bridge)"),
 *   description = @Translation("Handles processing for the community_bridge funding namespace.")
 * )
 */
class LfxMentorship extends FundingProviderBase {

  /**
   * {@inheritdoc}
   */
  public function build($data): array {
    if (is_string($data)) {
      return [
        '#theme' => 'funding_link',
        '#provider' => $this->id(),
        '#content' => $data,
        // @todo - no idea what the url should be.
        '#url' => 'https://lfx.linuxfoundation.org/' . $data,
      ];
    }

    return [];
  }

}

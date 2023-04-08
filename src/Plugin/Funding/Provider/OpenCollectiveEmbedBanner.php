<?php

namespace Drupal\funding\Plugin\Funding\Provider;

use Drupal\funding\Exception\InvalidFundingProviderData;
use Drupal\funding\Plugin\Funding\FundingProviderBase;

/**
 * Plugin implementation of the funding_provider.
 *
 * @FundingProvider(
 *   id = "open_collective_banner",
 *   label = @Translation("Open Collective Banner"),
 *   description = @Translation("Handles processing for the open_collective_banner funding namespace.")
 * )
 */
class OpenCollectiveEmbedBanner extends FundingProviderBase {

  /**
   * {@inheritdoc}
   */
  public function examples(): array {
    return [
      'open_collective_banner: COLLECTIVE_SLUG',

      'open_collective_banner:
        collective: COLLECTIVE_SLUG
        style:
          a:
            color: red
            backgroundColor: blue
          h2:
            fontFamily: "Courier New"
            fontWeight: bold',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function validate($data): bool {
    if (!is_string($data) && !is_array($data)) {
      throw new InvalidFundingProviderData('Expected string or array, got ' . gettype($data) . ' instead');
    }

    if (is_array($data)) {
      if (!isset($data['collective']) || !is_string($data['collective'])) {
        throw new InvalidFundingProviderData('Expected string for collective property, got '. gettype($data['collective']) . 'instead.');
      }
    }

    return TRUE;
  }

  /**
   * {@inheritdoc}
   */
  public function build($data): array {
    if (is_string($data)) {
      return [
        '#theme' => 'funding_open_collective_embed_banner',
        '#collective' => $data,
        '#style' => [],
      ];
    }

    if (is_array($data)) {
      return [
        '#theme' => 'funding_open_collective_embed_banner',
        '#collective' => $data['collective'],
        '#style' => $data['styles'] ?? [],
      ];
    }

    return [];
  }

}

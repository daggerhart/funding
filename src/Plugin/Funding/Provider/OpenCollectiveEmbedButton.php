<?php

namespace Drupal\funding\Plugin\Funding\Provider;

use Drupal\funding\Exception\InvalidFundingProviderData;
use Drupal\funding\Plugin\Funding\FundingProviderBase;

/**
 * Plugin implementation of the funding_provider.
 *
 * @FundingProvider(
 *   id = "open_collective_button",
 *   label = @Translation("Open Collective Button"),
 *   description = @Translation("Handles processing for the open_collective_button funding namespace.")
 * )
 */
class OpenCollectiveEmbedButton extends FundingProviderBase {

  /**
   * {@inheritdoc}
   */
  public function examples(): array {
    return [
      'open_collective_button: funding-tools',
      'open_collective_button:
         collective: funding-tools
         color: blue
         verb: contribute',
      'open_collective_button:
         collective: funding-tools
         color: white
         verb: donate',
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
        '#theme' => 'funding_open_collective_embed_button',
        '#collective' => $data,
      ];
    }

    if (is_array($data)) {
      return [
        '#theme' => 'funding_open_collective_embed_button',
        '#collective' => $data['collective'],
        '#color' => $data['color'] ?? 'blue',
        '#verb' => $data['verb'] ?? 'contribute',
      ];
    }

    return [];
  }

}

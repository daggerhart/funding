<?php

namespace Drupal\funding\Plugin\Funding\Provider;

use Drupal\funding\Plugin\Funding\FundingProviderOpenCollectiveBase;

/**
 * Plugin implementation of the funding_provider.
 *
 * @FundingProvider(
 *   id = "open_collective_banner",
 *   label = @Translation("Open Collective Banner"),
 *   description = @Translation("Handles processing for the open_collective_banner funding namespace.")
 * )
 */
class OpenCollectiveEmbedBanner extends FundingProviderOpenCollectiveBase {

  /**
   * {@inheritdoc}
   */
  public function examples(): array {
    return [
      'open_collective_banner: funding-tools',

      'open_collective_banner:
        collective: funding-tools
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
    parent::validate($data);

    if (is_array($data)) {
      $this->validateOptionalPropertyIsArray($data, 'style');
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

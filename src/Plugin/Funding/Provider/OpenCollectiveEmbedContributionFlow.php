<?php

namespace Drupal\funding\Plugin\Funding\Provider;

use Drupal\funding\Plugin\Funding\FundingProviderOpenCollectiveBase;

/**
 * Plugin implementation of the funding_provider.
 *
 * @FundingProvider(
 *   id = "open_collective_contribution_flow",
 *   label = @Translation("Open Collective Contribution FLow"),
 *   description = @Translation("Handles processing for the open_collective_contribution_flow funding namespace.")
 * )
 */
class OpenCollectiveEmbedContributionFlow extends FundingProviderOpenCollectiveBase {

  /**
   * {@inheritdoc}
   */
  public function examples(): array {
    return [
      'open_collective_contribution_flow: funding-tools',
      'open_collective_contribution_flow:
         collective: funding-tools
         tier: backer-14068',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function validate($data): bool {
    parent::validate($data);

    if (is_array($data)) {
      $this->validateOptionalPropertyIsString($data, 'tier');
    }

    return TRUE;
  }

  /**
   * {@inheritdoc}
   */
  public function build($data): array {
    if (is_string($data)) {
      return [
        '#theme' => 'funding_open_collective_embed_contribution_flow',
        '#collective' => $data,
      ];
    }

    if (is_array($data)) {
      return [
        '#theme' => 'funding_open_collective_embed_contribution_flow',
        '#collective' => $data['collective'],
        '#tier' => $data['tier'] ?? NULL,
      ];
    }

    return [];
  }

}

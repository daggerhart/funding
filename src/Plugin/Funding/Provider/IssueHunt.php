<?php

namespace Drupal\funding\Plugin\Funding\Provider;

use Drupal\funding\FundingProviderBase;

/**
 * Plugin implementation of the funding_provider.
 *
 * @FundingProvider(
 *   id = "issuehunt",
 *   label = @Translation("IssueHunt"),
 *   description = @Translation("Handles processing for the issuehunt funding namespace.")
 * )
 */
class IssueHunt extends FundingProviderBase {

  /**
   * {@inheritdoc}
   */
  public function build($data): array {
    if (is_string($data)) {
      return [
        '#theme' => 'funding_link',
        '#provider' => $this->id(),
        '#content' => $data,
        '#url' => 'https://issuehunt.io/u/' . $data,
      ];
    }

    return [];
  }

}

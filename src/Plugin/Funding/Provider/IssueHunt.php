<?php

namespace Drupal\funding\Plugin\Funding\Provider;

use Drupal\Core\Url;
use Drupal\funding\FundingProviderPluginBase;

/**
 * Plugin implementation of the funding_provider.
 *
 * @FundingProvider(
 *   id = "issuehunt",
 *   label = @Translation("IssueHunt"),
 *   description = @Translation("Handles processing for the issuehunt funding namespace.")
 * )
 */
class IssueHunt extends FundingProviderPluginBase {

  /**
   * {@inheritdoc}
   */
  public function build($data): array {
    if (is_string($data)) {
      return [
        '#type' => 'link',
        '#title' => $data,
        '#url' => Url::fromUri('https://issuehunt.io/u/' . $data),
      ];
    }

    return [];
  }

}

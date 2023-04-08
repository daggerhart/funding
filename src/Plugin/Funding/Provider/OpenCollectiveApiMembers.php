<?php

namespace Drupal\funding\Plugin\Funding\Provider;

use Drupal\funding\Exception\InvalidFundingProviderData;
use Drupal\funding\Plugin\Funding\FundingProviderBase;

/**
 * Plugin implementation of the funding_provider.
 *
 * @FundingProvider(
 *   id = "open_collective_members",
 *   label = @Translation("Open Collective Members"),
 *   description = @Translation("Handles processing for the open_collective_members funding namespace.")
 * )
 */
class OpenCollectiveApiMembers extends FundingProviderBase {

  /**
   * {@inheritdoc}
   */
  public function examples(): array {
    return [
      'open_collective_members: funding-tools',
      'open_collective_members:
         collective: funding-tools
         members_role: contributor
         members_limit: 20',
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
      ];
    }

    if (is_array($data)) {
      return [
        '#theme' => 'funding_open_collective_api_members',
        '#collective' => $data['collective'],
        '#members_role' => $data['members_role'] ?? NULL,
        '#members_limit' => isset($data['members_limit']) ? (int) $data['members_limit'] : NULL,
        // Customizing properties per-instance is disabled for now.
        //'#member_properties' => $data['member_properties'],
      ];
    }

    return [];
  }

}

<?php

namespace Drupal\funding\Plugin\Funding;

/**
 * Interface for funding_provider plugins.
 */
interface FundingProviderInterface {

  /**
   * Returns the plugin ID.
   *
   * @return string
   *   The plugin ID.
   */
  public function id(): string;

  /**
   * Returns the translated plugin label.
   *
   * @return string
   *   The translated title.
   */
  public function label(): string;

  /**
   * Returns the translated plugin description.
   *
   * @return string
   *   The translated description.
   */
  public function description(): string;

  /**
   * @param string|array $data
   *
   * @return array
   */
  public function build($data): array;

}

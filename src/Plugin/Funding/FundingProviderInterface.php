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
   * Get an array of example Yaml implementations.
   *
   * @return string[]
   *   Array of example Yaml implementations of the provider.
   */
  public function examples(): array;

  /**
   * Validate the given data.
   *
   * @param string|array $data
   *   Provider specific yaml content as data.
   *
   * @return bool
   *   True if valid.
   *
   * @throws \Drupal\funding\Exception\InvalidFundingProviderData
   */
  public function validate($data): bool;

  /**
   * Whether the funding provider plugin has everything it needs to work
   * correctly. For example, if a provider requires an API key, then the
   * provider should ensure that key exists before returning TRUE.
   *
   * @return bool
   *   True if provider is ready to work.
   */
  public function isReady(): bool;

  /**
   * @param string|array $data
   *
   * @return array
   */
  public function build($data): array;

}

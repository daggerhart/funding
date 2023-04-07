<?php

namespace Drupal\funding\Service;

interface FundingProviderProcessorInterface {

  /**
   * Decode the yaml string and process the results.
   *
   * @param string $yaml
   *   String of yaml.
   *
   * @return array
   *   Render array of processed providers.
   */
  public function processYaml(string $yaml): array;

  /**
   * Determines if a yaml string validates with funding providers.
   *
   * @param string $yaml
   *   Yaml string.
   *
   * @return bool
   *   True if yaml is valid according to funding providers.
   */
  public function yamlIsValid(string $yaml): bool;

  /**
   * Determines if the rows produced for rendering validates with providers.
   *
   * @param array $rows
   *   Associative array where the keys are the Funding Provider plugin ID, and
   *   the values are the data for the namespace should process.
   *
   * @return bool
   *   True if each row validates with its funding provider.
   */
  public function rowsAreValid(array $rows): bool;

  /**
   * Perform the funding provider validation loop, tracking the results of each
   * provider's validate() attempt.
   *
   * @param array $rows
   *   Associative array where the keys are the Funding Provider plugin ID, and
   *   the values are the data for the namespace should process.
   *
   * @return array
   *   Associative array where the keys are the Funding Provider plugin ID, and
   *   the values the results of validating that row.
   */
  public function validateRows(array $rows): array;

  /**
   * Convert the given array of funding provider data into a render array.
   *
   * @param array $rows
   *   Associative array where the keys are the Funding Provider plugin ID, and
   *   the values are the data for the namespace should process.
   *
   * @return array
   *   Render array of processed providers.
   */
  public function process(array $rows): array;

}

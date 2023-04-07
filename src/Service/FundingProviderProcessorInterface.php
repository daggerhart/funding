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
   * Convert the given array of funding provider data into a render array.
   *
   * @param array $rows
   *   Associative array where the keys are the "Funding namespaces", and the
   *   values are the data for the namespace should process.
   *
   * @return array
   *   Render array of processed providers.
   */
  public function process(array $rows): array;

}

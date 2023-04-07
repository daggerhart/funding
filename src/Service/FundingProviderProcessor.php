<?php

namespace Drupal\funding\Service;

use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Config\ImmutableConfig;
use Drupal\Core\Serialization\Yaml;
use Drupal\funding\Exception\InvalidFundingProviderData;

class FundingProviderProcessor implements FundingProviderProcessorInterface {

  /**
   * @var \Drupal\Core\Config\ImmutableConfig
   */
  private ImmutableConfig $config;

  /**
   * @var \Drupal\funding\Service\FundingProviderPluginManager
   */
  private FundingProviderPluginManager $manager;

  /**
   * @param \Drupal\Core\Config\ConfigFactoryInterface $configFactory
   * @param \Drupal\funding\Service\FundingProviderPluginManager $manager
   */
  public function __construct(ConfigFactoryInterface $configFactory, FundingProviderPluginManager $manager) {
    $this->config = $configFactory->get('');
    $this->manager = $manager;
  }

  /**
   * {@inheritdoc}
   */
  public function processYaml(string $yaml): array {
    $rows = Yaml::decode($yaml);
    return $this->process($rows);
  }

  /**
   * {@inheritdoc}
   */
  public function yamlIsValid(string $yaml): bool {
    $rows = Yaml::decode($yaml);
    return $this->rowsAreValid($rows);
  }

  /**
   * {@inheritdoc}
   */
  public function rowsAreValid(array $rows): bool {
    $results = $this->validateRows($rows);
    // Make a copy of the array where all values are TRUE.
    $test = array_combine(array_keys($results), array_fill(0, count($results), TRUE));
    return $test === $rows;
  }

  /**
   * {@inheritdoc}
   */
  public function validateRows(array $rows): array {
    $validations = [];
    foreach ($rows as $key => $row) {
      try {
        // The key for the row is the FundingProvider plugin id.
        if (!$this->manager->hasDefinition($key)) {
          $validations[$key] = new InvalidFundingProviderData('Provider plugin not found: '. $key);
        }

        $provider = $this->manager->createInstance($key);
        $validations[$key] = $provider->validate($row);
      }
      catch (InvalidFundingProviderData $exception) {
        $validations[$key] = $exception;
      }
    }

    return $validations;
  }

  /**
   * {@inheritdoc}
   */
  public function process(array $rows): array {
    $build = [
      '#type' => 'container',
    ];

    foreach ($rows as $key => $row) {
      // The key for the row is the FundingProvider plugin id.
      if (!$this->manager->hasDefinition($key)) {
        continue;
      }

      try {
        $provider = $this->manager->createInstance($key);
        if ($provider->validate($row)) {
          $build[$key] = $provider->build($row);
        }
      }
      catch (InvalidFundingProviderData $exception) {}
    }

    return array_filter($build);
  }

}

<?php

namespace Drupal\funding\Service;

use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Config\ImmutableConfig;
use Drupal\Core\Serialization\Yaml;
use Drupal\funding\Exception\InvalidFundingProviderData;
use Psr\Log\LoggerInterface;

/**
 * Default implementation of funding processor.
 */
class FundingProviderProcessor implements FundingProviderProcessorInterface {

  /**
   * Funding settings.
   *
   * @var \Drupal\Core\Config\ImmutableConfig
   */
  private ImmutableConfig $config;

  /**
   * Funding providers plugin manager.
   *
   * @var \Drupal\funding\Service\FundingProviderPluginManager
   */
  private FundingProviderPluginManager $pluginManager;

  /**
   * Logger.
   *
   * @var \Psr\Log\LoggerInterface
   */
  private LoggerInterface $logger;

  /**
   * Constructor().
   *
   * @param \Drupal\Core\Config\ConfigFactoryInterface $configFactory
   *   Config factory.
   * @param \Drupal\funding\Service\FundingProviderPluginManager $pluginManager
   *   Funding providers plugin manager.
   * @param \Psr\Log\LoggerInterface $logger
   *   Logger.
   */
  public function __construct(ConfigFactoryInterface $configFactory, FundingProviderPluginManager $pluginManager, LoggerInterface $logger) {
    $this->config = $configFactory->get('funding.settings');
    $this->pluginManager = $pluginManager;
    $this->logger = $logger;
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
    return $test === $results;
  }

  /**
   * {@inheritdoc}
   */
  public function validateRows(array $rows): array {
    $validations = [];
    foreach ($rows as $provider_id => $row) {
      try {
        // The key for the row is the FundingProvider plugin id.
        if (!$this->pluginManager->hasDefinition($provider_id)) {
          $validations[$provider_id] = new InvalidFundingProviderData('Provider plugin not found: '. $provider_id);
        }

        $provider = $this->pluginManager->getFundingProvider($provider_id);
        $validations[$provider_id] = $provider->validate($row);
      }
      catch (InvalidFundingProviderData $exception) {
        $validations[$provider_id] = $exception;
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

    // Loop through plugin instances so that rendered happens in order
    // of the configurable #weight of the plugin.
    foreach ($this->pluginManager->getFundingProviders() as $provider) {
      if (!$provider->enabled()) {
        continue;
      }
      if (!$provider->isReady()) {
        continue;
      }
      if (!isset($rows[$provider->id()])) {
        continue;
      }

      $row = $rows[$provider->id()];
      try {
        if ($provider->validate($row)) {
          $build[$provider->id()] = $provider->build($row);
        }
      }
      catch (InvalidFundingProviderData $exception) {
        $this->logger->notice($exception->getMessage());
      }
    }

    return array_filter($build);
  }

}

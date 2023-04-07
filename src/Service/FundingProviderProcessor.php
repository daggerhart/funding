<?php

namespace Drupal\funding\Service;

use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Config\ImmutableConfig;
use Drupal\Core\Serialization\Yaml;

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
  public function process(array $rows): array {
    $build = [
      '#type' => 'container',
    ];

    foreach ($rows as $key => $row) {
      // The key for the row is the FundingProvider plugin id.
      if (!$this->manager->hasDefinition($key)) {
        continue;
      }

      $provider = $this->manager->createInstance($key);
      $build[$key] = $provider->build($row);
    }

    return array_filter($build);
  }

}

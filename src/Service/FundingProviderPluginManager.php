<?php

namespace Drupal\funding\Service;

use Drupal\Core\Cache\CacheBackendInterface;
use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Config\ImmutableConfig;
use Drupal\Core\Extension\ModuleHandlerInterface;
use Drupal\Core\Plugin\DefaultPluginManager;
use Drupal\funding\Plugin\Funding\FundingProviderInterface;

/**
 * FundingProvider plugin manager.
 */
class FundingProviderPluginManager extends DefaultPluginManager {

  /**
   * Runtime cache of plugins.
   *
   * @var array
   */
  private array $cache = [];

  /**
   * Module settings.
   *
   * @var \Drupal\Core\Config\ImmutableConfig
   */
  private ImmutableConfig $config;

  /**
   * Constructs FundingProviderPluginManager object.
   *
   * @param \Traversable $namespaces
   *   An object that implements \Traversable which contains the root paths
   *   keyed by the corresponding namespace to look for plugin implementations.
   * @param \Drupal\Core\Cache\CacheBackendInterface $cache_backend
   *   Cache backend instance to use.
   * @param \Drupal\Core\Extension\ModuleHandlerInterface $module_handler
   *   The module handler to invoke the alter hook with.
   */
  public function __construct(\Traversable $namespaces, CacheBackendInterface $cache_backend, ModuleHandlerInterface $module_handler, ConfigFactoryInterface $configFactory) {
    parent::__construct(
      'Plugin/Funding/Provider',
      $namespaces,
      $module_handler,
      'Drupal\funding\Plugin\Funding\FundingProviderInterface',
      'Drupal\funding\Annotation\FundingProvider'
    );
    $this->alterInfo('funding_provider_info');
    $this->setCacheBackend($cache_backend, 'funding_provider_plugins');
    $this->config = $configFactory->get('funding.settings');
  }

  /**
   * Create an instance of a plugin.
   *
   * @param string $plugin_id
   *   The id of the setup plugin.
   * @param array $configuration
   *   Configuration data for the setup plugin.
   *
   * @return object|\Drupal\funding\Plugin\Funding\FundingProviderInterface
   *   Instance of the plugin.
   *
   * @throws \Drupal\Component\Plugin\Exception\PluginException
   */
  public function createInstance($plugin_id, array $configuration = []): FundingProviderInterface {
    return parent::createInstance($plugin_id, $configuration);
  }

  /**
   * @return \Drupal\funding\Plugin\Funding\FundingProviderInterface[]
   * @throws \Drupal\Component\Plugin\Exception\PluginException
   */
  public function getProviders(): array {
    $instances = [];
    foreach ($this->getDefinitions() as $plugin_id => $definition) {
      $instances[$plugin_id] = $this->getProvider($plugin_id);
    }

    $providers_settings = $this->config->get('providers_settings') ?? [];
    usort($instances, function($a, $b) use ($providers_settings) {
      $a_weight = $providers_settings[$a->id()]['weight'] ?? 0;
      $b_weight = $providers_settings[$b->id()]['weight'] ?? 0;
      return $a_weight <=> $b_weight;
    });

    return $instances;
  }

  /**
   * @param string $plugin_id
   * @param array $configuration
   *
   * @return \Drupal\funding\Plugin\Funding\FundingProviderInterface
   * @throws \Drupal\Component\Plugin\Exception\PluginException
   */
  public function getProvider(string $plugin_id, array $configuration = []): FundingProviderInterface {
    $cid = md5(serialize([$plugin_id, $configuration]));
    if (array_key_exists($cid, $this->cache)) {
      return $this->cache[$cid];
    }

    return $this->cache[$cid] = $this->createInstance($plugin_id, $configuration);
  }

}

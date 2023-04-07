<?php

namespace Drupal\funding\Service;

use Drupal\Core\Cache\CacheBackendInterface;
use Drupal\Core\Extension\ModuleHandlerInterface;
use Drupal\Core\Plugin\DefaultPluginManager;
use Drupal\funding\FundingProviderInterface;

/**
 * FundingProvider plugin manager.
 */
class FundingProviderPluginManager extends DefaultPluginManager {

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
  public function __construct(\Traversable $namespaces, CacheBackendInterface $cache_backend, ModuleHandlerInterface $module_handler) {
    parent::__construct(
      'Plugin/Funding/Provider',
      $namespaces,
      $module_handler,
      'Drupal\funding\FundingProviderInterface',
      'Drupal\funding\Annotation\FundingProvider'
    );
    $this->alterInfo('funding_provider_info');
    $this->setCacheBackend($cache_backend, 'funding_provider_plugins');
  }

  /**
   * Create an instance of a plugin.
   *
   * @param string $plugin_id
   *   The id of the setup plugin.
   * @param array $configuration
   *   Configuration data for the setup plugin.
   *
   * @return object|\Drupal\funding\FundingProviderInterface
   *   Instance of the plugin.
   *
   * @throws \Drupal\Component\Plugin\Exception\PluginException
   */
  public function createInstance($plugin_id, array $configuration = []): FundingProviderInterface {
    return parent::createInstance($plugin_id, $configuration);
  }

}

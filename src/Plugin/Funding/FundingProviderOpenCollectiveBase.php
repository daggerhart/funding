<?php

namespace Drupal\funding\Plugin\Funding;

use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\oc_graphql_client\Service\OpenCollectiveClient;
use Drupal\oc_graphql_client\Service\OpenCollectiveEnums;
use Symfony\Component\DependencyInjection\ContainerInterface;

abstract class FundingProviderOpenCollectiveBase extends FundingProviderBase implements ContainerFactoryPluginInterface {

  /**
   * Client.
   *
   * @var \Drupal\oc_graphql_client\Service\OpenCollectiveClient
   */
  protected OpenCollectiveClient $openCollectiveClient;

  /**
   * Enums helper.
   *
   * @var \Drupal\oc_graphql_client\Service\OpenCollectiveEnums
   */
  protected OpenCollectiveEnums $openCollectiveEnums;

  /**
   * BlockWithDependencyInjection constructor.
   *
   * @param array $configuration
   *   Plugin configuration.
   * @param $plugin_id
   *   Plugin ID.
   * @param $plugin_definition
   *   Plugin definition.
   * @param \Drupal\oc_graphql_client\Service\OpenCollectiveClient $openCollectiveClient
   *   Client.
   * @param \Drupal\oc_graphql_client\Service\OpenCollectiveEnums $openCollectiveEnums
   *   Enums helper.
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, OpenCollectiveClient $openCollectiveClient, OpenCollectiveEnums $openCollectiveEnums) {
    $this->openCollectiveClient = $openCollectiveClient;
    $this->openCollectiveEnums = $openCollectiveEnums;
    parent::__construct($configuration, $plugin_id, $plugin_definition);
  }

  /**
   * {@inheritDoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('oc_graphql_client.opencollective_client'),
      $container->get('oc_graphql_client.opencollective_enums')
    );
  }

  /**
   * {@inheritDoc}
   */
  public function validate($data): bool {
    $this->validateIsStringOrArray($data);

    if (is_array($data)) {
      $this->validateRequiredPropertyIsString($data, 'collective');
    }

    return TRUE;
  }

}

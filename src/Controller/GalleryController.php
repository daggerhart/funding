<?php

namespace Drupal\funding\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Render\Markup;
use Drupal\Core\Serialization\Yaml;
use Drupal\funding\Service\FundingProviderPluginManager;
use Drupal\funding\Service\FundingProviderProcessorInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Returns responses for Funding routes.
 */
class GalleryController extends ControllerBase {

  /**
   * Plugin manager.
   *
   * @var \Drupal\funding\Service\FundingProviderPluginManager
   */
  private FundingProviderPluginManager $pluginManager;

  /**
   * The funding.provider_processor service.
   *
   * @var \Drupal\funding\Service\FundingProviderProcessorInterface
   */
  private FundingProviderProcessorInterface $providerProcessor;

  /**
   * The controller constructor.
   *
   * @param \Drupal\funding\Service\FundingProviderPluginManager $pluginManager
   *   Plugin manager.
   * @param \Drupal\funding\Service\FundingProviderProcessorInterface $provider_processor
   *   The funding.provider_processor service.
   */
  public function __construct(FundingProviderPluginManager $pluginManager, FundingProviderProcessorInterface $provider_processor) {
    $this->pluginManager = $pluginManager;
    $this->providerProcessor = $provider_processor;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('plugin.manager.funding_provider'),
      $container->get('funding.provider_processor')
    );
  }

  /**
   * Builds the response.
   */
  public function build() {

    $rows = [];
    foreach ($this->pluginManager->getProviders() as $provider_id => $provider) {
      foreach ($provider->examples() as $i => $example_content) {
        $example_data = Yaml::decode($example_content);
        if (str_contains($example_content, "\n")) {
          $example_content = Yaml::encode(Yaml::decode($example_content));
        }

        if (!$provider->isReady()) {
          continue;
        }


        $example = [
          '#type' => 'fieldset',
          '#title' => $provider->label(),
          //'#description' => $provider->description(),
          //'#description_display' => 'after',
          '#collapsible' => FALSE,
          '#collapsed' => FALSE,
          '#attributes' => [
            'id' => 'funding-provider--' . $provider_id,
          ],
          'example' => [
            '#type' => 'container',
            '#attributes' => [
              'class' => ['funding-examples-all-container'],
            ],
            'yaml' => [
              '#type' => 'html_tag',
              '#tag' => 'span',
              '#value' => Markup::create("<span>{$example_content}</span>"),
              '#attributes' => [
                'class' => [
                  'funding-example',
                  'funding-example--' . $provider_id,
                  'funding-example--' . $provider_id . '--' . $i,
                ],
              ],
            ],
          ],
        ];

        $widget = $provider->build($example_data[$provider_id]);

        $rows[] = [
          ['data' => $example], ['data' => $widget],
        ];
      }
    }

    $header = [
      'col1' => t('Provider Examples'),
      'col2' => t('Output'),
    ];

    $build['content'] = [
      '#type' => 'table',
      '#header' => $header,
      '#rows' => $rows,
      '#attributes' => [
        'class' => [
          'funding-examples-gallery',
        ],
      ],
      '#attached' => [
        'library' => [
          'funding/examples-form'
        ],
      ],
    ];

    return $build;
  }

}

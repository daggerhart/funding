<?php

namespace Drupal\funding;

use Drupal\Component\Plugin\PluginBase;

/**
 * Base class for funding_provider plugins.
 */
abstract class FundingProviderPluginBase extends PluginBase implements FundingProviderInterface {

  /**
   * {@inheritdoc}
   */
  public function id(): string {
    return $this->pluginId;
  }

  /**
   * {@inheritdoc}
   */
  public function label(): string {
    // Cast the label to a string since it is a TranslatableMarkup object.
    return (string) $this->pluginDefinition['label'];
  }

  /**
   * {@inheritdoc}
   */
  public function description(): string {
    return (string) $this->pluginDefinition['description'];
  }

  /**
   * {@inheritdoc}
   */
  abstract public function build($data): array;

}

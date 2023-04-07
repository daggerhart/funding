<?php

namespace Drupal\funding\Plugin\Funding;

use Drupal\Component\Plugin\PluginBase;
use Drupal\Core\StringTranslation\StringTranslationTrait;
use Drupal\funding\Exception\InvalidFundingProviderData;

/**
 * Base class for funding_provider plugins.
 */
abstract class FundingProviderBase extends PluginBase implements FundingProviderInterface {

  use StringTranslationTrait;

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
  public function validate($data): bool {
    if (!is_string($data)) {
      throw new InvalidFundingProviderData(
        strtr('Provider @provider: Expected a string, got @type instead.', [
          '@provider' => $this->id(),
          '@type' => gettype($data),
        ])
      );
    }

    return TRUE;
  }

}

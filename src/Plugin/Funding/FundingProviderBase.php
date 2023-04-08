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
  public function examples(): array {
    return [
      "{$this->id()}: " . strtoupper($this->id()) . "_SLUG",
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function validate($data): bool {
    if (!is_string($data)) {
      throw new InvalidFundingProviderData(
        strtr('Expected a string, got @type instead.', [
          '@type' => gettype($data),
        ])
      );
    }

    return TRUE;
  }

  /**
   * {@inheritdoc}
   */
  public function isReady(): bool {
    return TRUE;
  }

  /**
   * Validates given data is string or array.
   *
   * @param mixed $data
   *   Data to validate.
   *
   * @return bool
   *   True if data is string or array.
   *
   * @throws \Drupal\funding\Exception\InvalidFundingProviderData
   */
  protected function validateIsStringOrArray($data): bool {
    if (!is_string($data) && !is_array($data)) {
      throw new InvalidFundingProviderData($this->invalidDataErrorMessage('string or array', 'data', $data));
    }

    return TRUE;
  }

  /**
   * Validates given key exists in the give data, and is a string.
   *
   * @param array $data
   *   Data to validate.
   * @param string $key
   *   Key to test.
   *
   * @return bool
   *   True if key is in data and is a string.
   * @throws \Drupal\funding\Exception\InvalidFundingProviderData
   */
  protected function validateRequiredPropertyIsString(array $data, string $key): bool {
    if (!array_key_exists($key, $data)) {
      throw new InvalidFundingProviderData("Key {$key} missing from data.");
    }
    if (!is_string($data[$key])) {
      throw new InvalidFundingProviderData($this->invalidDataErrorMessage('string', $key, $data[$key]));
    }

    return TRUE;
  }

  /**
   * Validate an optional property is a string.
   *
   * @param array $data
   *   Data to validate.
   * @param string $key
   *   Key to look for and test.
   *
   * @return bool
   *   True if the key doesn't exist, or is a string.
   *
   * @throws \Drupal\funding\Exception\InvalidFundingProviderData
   */
  protected function validateOptionalPropertyIsString(array $data, string $key): bool {
    if (array_key_exists($key, $data) && !is_string($data[$key])) {
      throw new InvalidFundingProviderData($this->invalidDataErrorMessage('string', $key, $data[$key]));
    }

    return TRUE;
  }

  /**
   * Validate an optional property is an integer.
   *
   * @param array $data
   *   Data to validate.
   * @param string $key
   *   Key to look for and test.
   *
   * @return bool
   *   True if the key doesn't exist, or is an integer.
   *
   * @throws \Drupal\funding\Exception\InvalidFundingProviderData
   */
  protected function validateOptionalPropertyIsInteger(array $data, string $key): bool {
    if (array_key_exists($key, $data) && !is_int($data[$key])) {
      throw new InvalidFundingProviderData($this->invalidDataErrorMessage('integer', $key, $data[$key]));
    }

    return TRUE;
  }

  /**
   * Validate an optional property is an array.
   *
   * @param array $data
   *   Data to validate.
   * @param string $key
   *   Key to look for and test.
   *
   * @return bool
   *   True if the key doesn't exist, or is an array.
   *
   * @throws \Drupal\funding\Exception\InvalidFundingProviderData
   */
  protected function validateOptionalPropertyIsArray(array $data, string $key): bool {
    if (array_key_exists($key, $data) && !is_array($data[$key])) {
      throw new InvalidFundingProviderData($this->invalidDataErrorMessage('array', $key, $data[$key]));
    }

    return TRUE;
  }

  /**
   * @param string $expected_type
   * @param string $key
   * @param $instead_value
   *
   * @return string
   */
  private function invalidDataErrorMessage(string $expected_type, string $key, $instead_value = NULL): string {
    return strtr('Expected @expected_type for @key, got @instead_type instead.', [
      '@expected_type' => $expected_type,
      '@key' => $key,
      '@instead_type' => gettype($instead_value),
    ]);
  }


}

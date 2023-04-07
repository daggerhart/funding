<?php

namespace Drupal\funding\Plugin\Funding\Provider;

/**
 * Plugin implementation of the funding_provider.
 *
 * @FundingProvider(
 *   id = "otechie",
 *   label = @Translation("Otechie (deprecated)"),
 *   description = @Translation("Deprecated processing for the otechie funding namespace. Use Hirepage instead.")
 * )
 */
class Otechie extends Hirepage {}

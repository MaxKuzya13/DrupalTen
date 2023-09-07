<?php

namespace Drupal\klog_hero\Plugin\KlogHero\Entity;

use Drupal\klog_hero\Annotation\KlogHeroEntity;
use Drupal\klog_hero\Plugin\KlogHero\KlogHeroPluginBase;


/**
 * The base for KlogHero entity plugin type.
 */
abstract class KlogHeroEntityPluginBase extends KlogHeroPluginBase implements KlogHeroEntityPluginInterface {

  /**
   * {@inheritdoc}
   */
  public function getEntityType() {
    return $this->pluginDefinition['entity_type'];
  }

  /**
   * {@inheritdoc}
   */
  public function getEntityBundle() {
    return $this->pluginDefinition['entity_bundle'];
  }

    /**
   * {@inheritdoc}
   */
  public function getEntity() {
    return $this->configuration['entity'];
  }
}

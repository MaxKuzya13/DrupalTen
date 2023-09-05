<?php

namespace Drupal\klog_hero\Plugin\KlogHero\Path;

use Drupal\Core\Entity\EntityInterface;
use Drupal\klog_hero\Plugin\KlogHero\KlogHeroPluginInterface;

/**
 * Interface for KlogHero entity plugin type.
 */
interface KlogHeroEntityPluginInterface extends KlogHeroPluginInterface {

  /**
   * Gets entity type id.
   *
   * @return string
   *  The entity type id.
   */
  public function getEntityType();

  /**
   * Gets entity bundles.
   *
   * @return array
   *  The array with entity type bundles.
   */
  public function getEntityBundle();

  /**
   * Gets current entity.
   *
   * @return \Drupal\Core\Entity\EntityInterface
   *  The entity object.
   */
  public function getEntity();

}

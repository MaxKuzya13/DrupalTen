<?php

namespace Drupal\klog_hero\Plugin\KlogHero\Path;

use Drupal\klog_hero\Plugin\KlogHero\KlogHeroPluginInterface;

/**
 * Interface for KlogHero path plugin type.
 */
interface KlogHeroPathPluginInterface extends KlogHeroPluginInterface {

  /**
   * Gets match paths.
   *
   * @return array
   *  An array with paths.
   */
  public function getMatchPath();

  /**
   * Gets match type.
   *
   * @return string
   *  The match type.
   */
  public function getMatchType();
}

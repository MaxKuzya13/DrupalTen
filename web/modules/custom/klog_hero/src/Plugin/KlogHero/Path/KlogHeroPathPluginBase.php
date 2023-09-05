<?php

namespace Drupal\klog_hero\Plugin\KlogHero\Path;

use Drupal\klog_hero\Plugin\KlogHero\KlogHeroPluginBase;


/**
 * The base for KlogHero path plugin type.
 */
abstract class KlogHeroPathPluginBase extends KlogHeroPluginBase implements KlogHeroPathPluginInterface {

  /**
   * {@inheritdoc}
   */
  public function getMatchPath() {
    return $this->pluginDefinition['match_path'];
  }

  /**
   * {@inheritdoc}
   */
  public function getMatchType() {
    return $this->pluginDefinition['match_type'];
  }
}

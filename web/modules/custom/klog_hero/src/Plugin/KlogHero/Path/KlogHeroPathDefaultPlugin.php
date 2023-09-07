<?php

namespace Drupal\klog_hero\Plugin\KlogHero\Path;

/**
 * Default plugin which will be used if none of others met their requirements.
 *
 * @KlogHeroPath(
 *   id = "klog_hero_path_default",
 *   match_path = {"*"},
 *   weight = -100,
 * )
 */
class KlogHeroPathDefaultPlugin extends KlogHeroPathPluginBase {

}

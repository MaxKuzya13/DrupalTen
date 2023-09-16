<?php

namespace Drupal\klog_hero\Plugin\KlogHero;

use Drupal\Component\Plugin\PluginInspectionInterface;

/**
 * Common interface for all KlogHero plugin types.
 */
interface KlogHeroPluginInterface extends PluginInspectionInterface {

  /**
   * Gets plugin status.
   *
   * @return bool
   *  The plugin status.
   */
  public function getEnabled();

  /**
   * Gets plugin weight.
   *
   * @return int
   *  The plugin weight.
   */
  public function getWeight();

  /**
   * Gets hero title.
   *
   * @return string
   *  The title.
   */
  public function getHeroTitle();

  /**
   * Gets hero subtitle.
   *
   * @return string
   *  The subtitle.
   */
  public function getHeroSubtitle();

  /**
   * Gets hero image uri.
   *
   * @return string
   *  The URI of image.
   */
  public function getHeroImage();

  /**
   * Gets hero video uri.
   *
   * An array with link to the same video in different types
   *
   * Keys of array is represent their type and value is file URI.
   *
   * @code
   * return [
   *  'video/mp4' => 'big-buck-bunny.mp4',
   *  'video/ogg' => 'big-buck-bunny.ogg',
   *  'video/webm' => 'big-buck-bunny.webm',
   * ];
   *
   * @return array
   *  An array with video URI`s.
   */
  public function getHeroVideo();
}

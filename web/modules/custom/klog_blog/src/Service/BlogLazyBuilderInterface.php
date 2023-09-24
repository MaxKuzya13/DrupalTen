<?php

namespace Drupal\klog_blog\Service;

use Drupal\Core\Security\TrustedCallbackInterface;

/**
 * Interface for blog lazy builder.
 *
 * @package \Drupal\klog_hero\Service
 *
 */
interface BlogLazyBuilderInterface extends TrustedCallbackInterface {

  /**
   * Gets random posts with theme hook klog_blog_random_posts.
   *
   * @return array
   *   Render array with team hook
   */
  public static function randomBlogPosts();
}

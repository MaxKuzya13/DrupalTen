<?php

namespace Drupal\klog_blog\Service;

/**
 * Class for blog lazy builder.
 *
 * @package \Drupal\klog_hero\Service
 *
 */
class BlogLazyBuilder implements BlogLazyBuilderInterface {

  public static function trustedCallbacks() {
    return ['randomBlogPosts'];
  }

  /**
   * {@inheritdoc}
   */
  public static function randomBlogPosts() {
    return [
      '#theme' => 'klog_blog_random_posts'
    ];
  }

}

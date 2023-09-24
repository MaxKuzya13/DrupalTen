<?php

namespace Drupal\klog_blog\Service;

use Drupal\node\NodeInterface;

/**
 * Simple helpers for blog articles
 *
 * @package Drupal\klog_blog\Service;
 */
interface BlogManagerInterface {

  /**
   * Gets related blog_posts with exact same tags.
   *
   * @param \Drupal\node\NodeInterface $node
   *   The node object for which search related posts.
   * @param int $limit
   *   The max limit of related posts.
   *
   * @return array
   *   The related blog posts entity id`s.
   */
  public function getRelatedPostsWithExactSameTags(NodeInterface $node, int $limit = 2);

  /**
   * Gets related blog_posts with same tags (one of them must exists).
   *
   * @param \Drupal\node\NodeInterface $node
   *   The node object for which search related posts.
   * @param array $exclude_ids
   *   The max limit of related posts.
   *
   * @param int $limit
   *    The array with node id`s which must be excluded.
   *
   * @return array
   *   The related blog posts entity id`s.
   */
  public function getRelatedPostsWithSameTags(NodeInterface $node, array $exclude_ids = [], int $limit = 2);

  /**
   * Gets random blog posts.
   *
   * @param int $limit
   *    The array with node id`s which must be excluded.
   *
   * @param array $exclude_ids
   *    The max limit of related posts.
   *
   * @return array
   *   The related blog posts entity id`s.
   */
  public function getRandomPosts(int $limit = 2, array $exclude_ids = []);

  /**
   * Gets related posts.
   *
   * @param \Drupal\node\NodeInterface $node
   *    The node for which related posts is looking for.
   *
   * @param int $max
   *    The max related post tying to find.
   *
   * @param array $exact_tags
   *    The max related posts trying to find with exact same tags.
   *
   * @return array
   *   The related blog posts entity id`s.
   */
  public function getRelatedPosts(NodeInterface $node, int $max = 4, int $exact_tags = 2);
}

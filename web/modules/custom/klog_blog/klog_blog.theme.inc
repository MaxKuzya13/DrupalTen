<?php

/**
 * @file
 * Main file for custom theme hook preprocess.
 */

use Drupal\node\NodeInterface;

/**
 * Implements template_preprocess_HOOK for klog-blog-related-posts.html.twig.
 */
function template_preprocess_klog_blog_related_posts(array &$variables) {

  $items = [];

  /** @var  \Drupal\node\NodeInterface $node */
  $node = \Drupal::routeMatch()->getParameter('node');

  if ($node instanceof NodeInterface) {
    /** @var \Drupal\node\NodeStorageInterface $node_storage */
    $node_storage = \Drupal::entityTypeManager()->getStorage('node');

    /** @var \Drupal\node\NodeViewBuilder $node_view_builder */
    $node_view_builder = \Drupal::entityTypeManager()->getViewBuilder('node');

    /** @var \Drupal\klog_blog\Service\BlogManagerInterface $blog_manager */
    $blog_manager = \Drupal::service('klog_blog.manager');

    $related_post_ids = $blog_manager->getRelatedPosts($node, $variables['max'], $variables['max_exact_same_tags']);
    foreach ($related_post_ids as $id) {
      /** @var \Drupal\node\NodeInterface $related_post */
      $related_post = $node_storage->load($id);
      $items[] = $node_view_builder->view($related_post, 'teaser');

    }
  }

  $variables['items'] = $items;
}

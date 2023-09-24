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
  $max_related_posts = 4;
  $max_same_tags_posts = 2;
  $counter = 0;
  $items = [];

  /** @var  \Drupal\node\NodeInterface $node */
  $node = \Drupal::routeMatch()->getParameter('node');

  if ($node instanceof NodeInterface) {
    /** @var \Drupal\node\NodeStorageInterface $node_storage */
    $node_storage = \Drupal::entityTypeManager()->getStorage('node');

    /** @var \Drupal\node\NodeViewBuilder $node_view_builder */
    $node_view_builder = \Drupal::entityTypeManager()->getViewBuilder('node');


    if ($node->hasField('field_tags') && !$node->get('field_tags')->isEmpty()) {
      // Looking for related posts where all tags exact the same
      $same_tags_post_query = \Drupal::entityQuery('node')
        ->condition('status', NodeInterface::PUBLISHED)
        ->condition('nid', $node->id(), '<>')
        ->accessCheck(FALSE)
        ->range(0, $max_same_tags_posts)
        ->addTag('entity_query_random');

      // For second query
      $field_tags_ids = [];

      foreach ($node->get('field_tags')->getValue() as $field_tag) {
        $and = $same_tags_post_query->andConditionGroup();
        $and->condition('field_tags', $field_tag['target_id']);
        $same_tags_post_query->condition($and);
        $field_tags_ids = $field_tag['target_id'];

      }

      $same_tags_post_ids = $same_tags_post_query->execute();
      foreach ($same_tags_post_ids as $id) {
        /** @var \Drupal\node\NodeInterface $related_post */
        $related_post = $node_storage->load($id);
        $items[] = $node_view_builder->view($related_post, 'teaser');
        $counter++;
      }

      // Looking fir related posts where any of tags exist.
      $any_tags_post_query = \Drupal::entityQuery('node')
        ->condition('status', NodeInterface::PUBLISHED)
        ->condition('nid', $node->id(), '<>')
        ->condition('field_tags', $field_tags_ids, 'IN')
        ->accessCheck(FALSE)
        ->range(0, ($max_related_posts - $counter))
        ->addTag('entity_query_random');

      // Exclude same tags posts from this query if they exists
      foreach ($same_tags_post_ids as $id) {
        $any_tags_post_query->condition('nid', $id, '<>');
      }

      $any_tags_post_ids = $any_tags_post_query->execute();

      foreach ($any_tags_post_ids as $id) {
        /** @var \Drupal\node\NodeInterface $related_post */
        $related_post = $node_storage->load($id);
        $items[] = $node_view_builder->view($related_post, 'teaser');
        $counter++;
      }
    }

    if($max_related_posts - $counter > 0) {
      $related_post_query = \Drupal::entityQuery('node')
        ->condition('status', NodeInterface::PUBLISHED)
        ->condition('nid', $node->id(), '<>')
        ->accessCheck(FALSE)
        ->range(0, ($max_related_posts - $counter))
        ->addTag('entity_query_random');
      $related_post_ids = $related_post_query->execute();

      foreach ($related_post_ids as $id) {
        /** @var \Drupal\node\NodeInterface $related_post */
        $related_post = $node_storage->load($id);
        $items[] = $node_view_builder->view($related_post, 'teaser');
        $counter++;
      }
    }
  }

  $variables['items'] = $items;
}

<?php

/**
 * @file
 * Custom theme hooks.
 */

use Drupal\media\MediaInterface;
use Drupal\node\NodeInterface;
use Drupal\taxonomy\TermInterface;

/**
 * Implements hook_preprocess_HOOK() for
 * klog_previous_next__blog_article.html.twig.
 */
function kenny_preprocess_klog_previous_next__blog_article(array &$variables) {

  /** @var NodeInterface $node */
  $node = $variables['entity'];
  /** @var NodeInterface $node */
  $next_entity = !empty($variables['next']) ? $variables['next']['entity'] : NULL;
  $prev_entity = !empty($variables['previous']) ? $variables['previous']['entity'] : NULL;

  if ($next_entity) {
    /** @var MediaInterface $promo_media */
    $promo_media = $next_entity->get('field_promo_image')->entity;
    $variables['next']['promo_uri'] = $promo_media->get('field_media_image')->entity->getFileUri();

    $tags = [];
    /** @var TermInterface $tag_term */
    foreach ($next_entity->get('field_tags')->referencedEntities() as $tag_term) {
      $tags[] = [
        'label' => $tag_term->label(),
      ];
    }
    $variables['next']['tags'] = $tags;
  }

  if ($prev_entity) {
    /** @var MediaInterface $promo_media */
    $promo_media = $prev_entity->get('field_promo_image')->entity;
    $variables['previous']['promo_uri'] = $promo_media->get('field_media_image')->entity->getFileUri();

    $tags = [];
    /** @var TermInterface $tag_term */
    foreach ($prev_entity->get('field_tags')->referencedEntities() as $tag_term) {
      $tags[] = [
        'label' => $tag_term->label(),
      ];
    }
    $variables['previous']['tags'] = $tags;
  }

}

/**
 * Implements hook_preprocess_HOOK() for klog-hero--klog-node-blog-article.html.twig.
 */
function kenny_preprocess_klog_hero__klog_node_blog_article(array &$variables) {
  $tags = [];
  /** @var NodeInterface $node */
  $node = Drupal::routeMatch()->getParameter('node');

  if ($node instanceof NodeInterface) {

    /** @var TermInterface $tag_term */
    foreach ($node->get('field_tags')->referencedEntities() as $tag_term) {
      $tags[] = [
        'label' => $tag_term->label(),
        'path' => $tag_term->toUrl()->toString(),
      ];
    }
  }
  $variables['tags'] = $tags;
}

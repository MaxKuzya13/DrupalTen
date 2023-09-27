<?php

namespace Drupal\klog\Plugin\KlogHero\Entity;

use Drupal\klog_hero\Plugin\KlogHero\Entity\KlogHeroEntityPluginBase;

/**
 * Hero block for blog_article node type.
 *
 * @KlogHeroEntity (
 *   id = "klog_node_blog_article",
 *   entity_type = "node",
 *   entity_bundle = {"blog_article"}
 * )
 */
class NodeBlogArticle extends KlogHeroEntityPluginBase {

  /**
   * {@inheritdoc}
   */
  public function getHeroSubtitle() {
    /** @var \Drupal\node\NodeInterface $node */
    $node = $this->getEntity();
    return $node->get('body')->value;
  }

  /**
   * {@inheritdoc}
   */
  public function getHeroImage() {
    /** @var \Drupal\node\NodeInterface $node */
    $node = $this->getEntity();
    /** @var \Drupal\media\MediaInterface $media */
    $media = $node->get('field_promo_image')->entity;
    return $media->get('field_media_image')->entity->getFileUri();
  }
}

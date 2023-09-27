<?php

namespace Drupal\klog\Plugin\KlogHero\Path;

use Drupal\klog_hero\Plugin\KlogHero\Path\KlogHeroPathPluginBase;
use Drupal\media\MediaInterface;

/**
 * Hero block for path
 *
 * @KlogHeroPath (
 *   id = "klog_blog",
 *   match_type = "listed",
 *   match_path = {"/blog"}
 * )
 */

class KlogBlog extends KlogHeroPathPluginBase {

  /**
   * {@inheritdoc}
   */
  public function getHeroSubtitle() {
    return 'Lorem Ipsum is simply dummy text of the printing and typesetting industry.';
  }

  /**
   * {@inheritdoc}
   */
  public function getHeroImage() {
    /** @var \Drupal\media\MediaStorage $media_storage */
    $media_storage = $this->getEntityTypeManager()->getStorage('media');
    $media_image = $media_storage->load(18);
    if($media_image instanceof MediaInterface) {
      return $media_image->get('field_media_image')->entity->get('uri')->value;
    }
  }

  /**
   * {@inheritdoc}
   */
  public function getHeroVideo() {
    /** @var \Drupal\media\MediaStorage $media_storage */
    $media_storage = $this->getEntityTypeManager()->getStorage('media');
    $media_video = $media_storage->load(16);
    if($media_video instanceof MediaInterface) {
      return [
        'video/mp4' => $media_video->get('field_media_video_file')->entity->get('uri')->value
      ];
    }
  }
}

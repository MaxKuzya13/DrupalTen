<?php

/**
 * @file
 * Theme and preprocess functions for breadcrumbs, messages, tabs ... etc.
 */

use Drupal\Core\Template\Attribute;
use Drupal\node\NodeInterface;

/**
 * Implements hook_preprocess__HOOK() for page.html.twig.
 */
function kenny_preprocess_page(array &$variables) {
  $main_layout_attributes = new Attribute();

  // set default class.
  $main_layout_attributes->addClass('main-layout');

  // Handle sidebar modifiers
  if (!empty($variables['page']['sidebar'])) {
    $main_layout_attributes->addClass('main-layout--sidebar');
  } else {
    $main_layout_attributes->addClass('main-layout--no-sidebar');
  }

  $variables['main_layout_attributes'] = $main_layout_attributes;
}

/**
 * Implements hook_preprocess_HOOK() for page--front.html.twig.
 */
function kenny_preprocess_page__front(&$variables) {
  /** @var \Drupal\media\MediaStorage $media_storage */
  $media_storage = \Drupal::entityTypeManager()->getStorage('media');
  /** @var \Drupal\media\MediaInterface $media_image */
  $media_image = $media_storage->load(31);
  /** @var \Drupal\media\MediaInterface $media_video */
  $media_video = $media_storage->load(30);

  $variables['search_image_uri'] = $media_image->get('field_media_image')
    ->entity
    ->getFileUri();

  $variables['search_video_uri'] = $media_video->get('field_media_video_file')
    ->entity
    ->getFileUri();

  // Author media
  /** @var \Drupal\media\MediaInterface $media_avatar */
  $media_avatar = $media_storage->load(32);

  $variables['author_avatar'] = $media_avatar->get('field_media_image')
    ->entity
    ->getFileUri();

  // Author media
  /** @var \Drupal\media\MediaInterface $author_bg */
  $author_bg = $media_storage->load(33);

  $variables['author_bg'] = $author_bg->get('field_media_image')
    ->entity
    ->getFileUri();
}

/**
 * Implements hook_preprocess_HOOK() for page--contact.html.twig.
 */
function kenny_preprocess_page__contact(&$variables) {
  /** @var \Drupal\media\MediaStorage $media_storage */
  $media_storage = \Drupal::entityTypeManager()->getStorage('media');
  /** @var \Drupal\media\MediaInterface $media_image */
  $media_image = $media_storage->load(18);
  /** @var \Drupal\media\MediaInterface $media_video */
  $media_video = $media_storage->load(24);

  $variables['contact_image_uri'] = $media_image->get('field_media_image')
    ->entity
    ->getFileUri();


  $variables['contact_video_uri'] = $media_video->get('field_media_video_file')
    ->entity
    ->getFileUri();
}

/**
 * Implements hook_preprocess_HOOK() for page--about.html.twig.
 */
function kenny_preprocess_page__about(&$variables) {
  /** @var \Drupal\media\MediaStorage $media_storage */
  $media_storage = \Drupal::entityTypeManager()->getStorage('media');
  /** @var \Drupal\media\MediaInterface $media_image */
  $media_image = $media_storage->load(35);

  $variables['about_image_uri'] = $media_image->get('field_media_image')
    ->entity
    ->getFileUri();

}

/**
 * Implements hook_theme_suggestions_HOOK_alter() for page.html.twig.
 */
function kenny_theme_suggestions_page_alter(array &$suggestions, array $variables) {
  $node = \Drupal::routeMatch()->getParameter('node');
  if ($node instanceof NodeInterface) {
    if ($node->id() == 3) {
      $suggestions[] = 'page__about';
    }
  }
}

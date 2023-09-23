<?php

/**
 * @file
 * Main file for preprocessing custom hook_theme
 */

/**
 * Implements template_preprocess_HOOK() for klog-previous-next.html.twig.
 */
function template_preprocess_klog_previous_next(&$variables) {
  /** @var \Drupal\Core\Entity\EntityInterface $entity */
  $entity = $variables['entity'];
  $variables['next'] = [];
  $variables['previous'] = [];

  /** @var \Drupal\Core\Entity\EntityStorageInterface $entity_storage */
  $entity_storage = \Drupal::entityTypeManager()->getStorage($entity->getEntityTypeId());

  // Getting next entity ID.
  $next_entity_id = $entity_storage->getQuery()
    ->condition('type', $entity->bundle())
    ->condition('created', $entity->getCreatedTime(), '>')
    ->condition('status', 1)
    ->accessCheck(TRUE)
    ->range(0, 1)
    ->sort('created', 'ASC')
    ->execute();

  if (!empty($next_entity_id)) {
    $next_entity = $entity_storage->load(array_shift($next_entity_id));

    $variables['next']['entity'] = $next_entity;
    $variables['next']['label'] = $next_entity->label();
    $variables['next']['url'] = $next_entity->toUrl()->toString(TRUE)->getGeneratedUrl();
  }

  //Getting previous entity ID.
  $previous_entity_id = $entity_storage->getQuery()
    ->condition('type', $entity->bundle())
    ->condition('created', $entity->getCreatedTime(), '<')
    ->condition('status', 1)
    ->accessCheck(TRUE)
    ->range(0, 1)
    ->sort('created', 'DESC')
    ->execute();

  if (!empty($previous_entity_id)) {
    $previous_entity = $entity_storage->load(array_shift($previous_entity_id));

    $variables['previous']['entity'] = $previous_entity;
    $variables['previous']['label'] = $previous_entity->label();
    $variables['previous']['url'] = $previous_entity->toUrl()->toString(TRUE)->getGeneratedUrl();
  }
}

/**
 * Implements template_preprocess_HOOK() for klog-label-with-icon-media-formatter.html.twig.
 */
function template_preprocess_klog_label_with_icon_media_formatter(array &$variables) {
  $mime_type = $variables['mime_type'];

  $mime_association = [
    "audio/mpeg" => 'audio.png',
    "audio/x-mpeg" => 'audio.png',
    "audio/x-wav" => 'audio.png',
    "image/jpeg" => 'image.png',
    "application/pdf" => 'document.png',
    "application/zip" => 'document.png',
    "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" => 'document.png',
    "video/mp4" => 'video.png',
    "video/x-wmv" => 'video.png',
    "application/default" => 'default.png',
  ];

//  $theme_manager = \Drupal::service('theme.manager');
//  $theme_name = 'kenny';
//  $theme_info = $theme_manager->getThemeInfo($theme_name);
//  if (!empty($theme_info)) {
//    $icon_path = $theme_info->getPath() .'/assets/images/mimetypes/';
//
//  }

  $icons_path = \Drupal::theme()->getActiveTheme()->getPath() . '/assets/images/mimetypes/';
  if (!array_key_exists($mime_type, $mime_association)) {

    $current_icon_filename = 'default.png';
  } else {

    $current_icon_filename = $mime_association[$mime_type];
  }

  $variables['mime_icon_path'] = $icons_path . $current_icon_filename;

}

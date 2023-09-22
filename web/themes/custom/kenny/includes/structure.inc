<?php

/**
 * @file
 * Theme and preprocess functions for breadcrumbs, messages, tabs ... etc.
 */

use Drupal\Core\Template\Attribute;

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

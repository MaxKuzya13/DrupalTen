<?php

/**
 * @file
 * Main file for all custom theme hooks preprocess
 */

/**
 * Implements template_preprocess_HOOK() for klog-hero.html.twig.
 */
function template_preprocess_klog_hero(&$variables) {
  // Image is required for video. It will be used for poster.
  if (!empty($variables['video'])) {
    if (!$variables['image']) {
      $variables['video'] = [];
    }
  }

}

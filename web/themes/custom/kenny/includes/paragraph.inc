<?php

/**
 * @file
 * Preprocesses for paragraphs.
 */

/**
 * Implements hook_preprocess_HOOK() for paragraph-code.html.twig.
 */
function kenny_preprocess_paragraph__code(array &$variables) {
  $variables['#attached']['library'][] = 'kenny/paragraph.code';
}

<?php

namespace Drupal\klog_taxonomy\Service;

/**
 * Interface with helpers for taxonomy vocabulary Tags
 */
interface TagsHelperInterface {

  /**
   * Gets promo image uri from taxonomy term
   *
   * @param int $tid
   *   The term id
   * @return string|null
   *   The file uri, NULL otherwise
   */
  public function getPromoUri($tid);
}

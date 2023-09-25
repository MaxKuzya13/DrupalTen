<?php

namespace Drupal\klog_comments\Service;

/**
 * Class with colors.
 *
 * @package Drupal\klog_comments\Service
 */
interface LetterAvatarInterface {

  /**
   * Gets color from username
   *
   * @param string $username
   *   The username.
   * @return array
   *  An array with RGB colors
   */

  public function fromUsername($username);

  /**
   * Gets letter from username
   *
   * @param string $username
   *   The username.
   * @return string
   *  The username letter.
   */
  public function getLetterFromUsername($username);

  /**
   * Gets text color by contrast usin YIQ formula.
   *
   * @param string|array $color
   *  The color which will be tested for contrast. Can be an array with RGB colors
   *  or HEX color.
   * @param string $text_color_dark
   *  The HEX color for dark text.
   * @param string $text_color_light
   *   The HEX color for light text.
   *
   * @return string
   *   The HEX color for dark or light text compared to $color.
   *
   * @see https://en.wikipedia.org/wiki/YIQ
   */
  public function getTextColor($color, $text_color_dark = '#00000', $text_color_light = '#fff');

  /**
   * Gets available colors
   *
   * @return array
   *   An array with RGB colors.
   */
  public function getColors();
}

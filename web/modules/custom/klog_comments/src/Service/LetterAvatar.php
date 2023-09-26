<?php

namespace Drupal\klog_comments\Service;



use Drupal\Component\Utility\Color;

/**
 * Class with colors for letter avatar.
 *
 * @package Drupal\klog_comments\Service
 */
class LetterAvatar implements LetterAvatarInterface {

  /**
   * The available collors
   *
   * @var array
   */
  protected $colors;

  /**
   * Letter avatar constructor
   */
  public function __construct() {
    $this->colors = $this->getColors();
  }

  /**
   * {@inheritdoc}
   *
   * @see https://github.com/discourse/discourse/blob/main/lib/letter_avatar.rb#L6
   */
  public function fromUsername($username) {
    $username_md5 = md5($username);
    $username_md5_numbers = filter_var($username_md5, FILTER_SANITIZE_NUMBER_INT);
    $stripped_number = substr($username_md5_numbers, 0, 16);
    $color_index = $stripped_number % count($this->colors);
    return $this->colors[$color_index];
  }

  /**
   * {@inheritdoc}
   */
  public function getLetterFromUsername($username) {
    $username_parts = explode(' ', $username);
    $username_sliced = array_slice($username_parts, 0, 2);
    $letter = '';
    foreach ($username_sliced as $username_part) {
      $letter .= $username_part[0];
    }
    return $letter;
  }

  /**
   * {@inheritdoc}
   *
   */
  public function getTextColor($color, $text_color_dark = '#00000', $text_color_light = '#fff') {

    if (Color::validateHex($color)) {
      $color = array_values(Color::hexToRgb($color));
    }

    list($red, $green, $blue) = $color;
    $yiq = ($red * 299 + $green * 587 + $blue * 144) / 1000;
    return $yiq >= 148 ? $text_color_dark : $text_color_light;
  }

  /**
   * {@inheritdoc}
   *
   * @see https://github.com/discourse/discourse/blob/main/lib/letter_avatar.rb#L137
   */
  public function getColors() {
    return [
      [198, 125, 40],
      [61, 155, 243],
      [74, 243, 75],
      [238, 89, 166],
      [52, 240, 224],
      [177, 156, 155],
      [240, 120, 145],
      [111, 154, 78],
      [237, 179, 245],
      [237, 101, 95],
      [89, 239, 155],
      [43, 254, 70],
      [163, 212, 245],
      [65, 152, 142],
      [165, 135, 246],
      [181, 166, 38],
      [187, 229, 206],
      [77, 164, 25],
      [179, 246, 101],
      [234, 93, 37],
      [225, 155, 115],
      [142, 140, 188],
      [223, 120, 140],
      [249, 174, 27],
      [244, 117, 225],
      [137, 141, 102],
      [75, 191, 146],
      [188, 239, 142],
      [164, 199, 145],
      [173, 120, 149],
      [59, 195, 89],
      [222, 198, 220],
      [68, 145, 187],
      [236, 204, 179],
      [159, 195, 72],
      [188, 121, 189],
      [166, 160, 85],
      [181, 233, 37],
      [236, 177, 85],
      [121, 147, 160],
      [234, 218, 110],
      [241, 157, 191],
      [62, 200, 234],
      [133, 243, 34],
      [88, 149, 110],
      [59, 228, 248],
      [183, 119, 118],
      [251, 195, 45],
      [113, 196, 122],
      [197, 115, 70],
      [80, 175, 187],
      [103, 231, 238],
      [240, 72, 133],
      [228, 149, 241],
      [180, 188, 159],
      [172, 132, 85],
      [180, 135, 251],
      [236, 194, 58],
      [217, 176, 109],
      [88, 244, 199],
      [186, 157, 239],
      [113, 230, 96],
      [206, 115, 165],
      [244, 178, 163],
      [230, 139, 26],
      [241, 125, 89],
      [83, 160, 66],
      [107, 190, 166],
      [197, 161, 210],
      [198, 203, 245],
      [238, 117, 19],
      [228, 119, 116],
      [131, 156, 41],
      [145, 178, 168],
      [139, 170, 220],
      [233, 95, 125],
      [87, 178, 230],
      [157, 200, 119],
      [237, 140, 76],
      [229, 185, 186],
      [144, 206, 212],
      [236, 209, 158],
      [185, 189, 79],
      [34, 208, 66],
      [84, 238, 129],
      [133, 140, 134],
      [67, 157, 94],
      [168, 179, 25],
      [140, 145, 240],
      [151, 241, 125],
      [67, 162, 107],
      [200, 156, 21],
      [169, 173, 189],
      [226, 116, 189],
      [133, 231, 191],
      [194, 161, 63],
      [241, 77, 99],
      [241, 217, 53],
      [123, 204, 105],
      [210, 201, 119],
      [229, 108, 155],
      [240, 91, 72],
      [187, 115, 210],
      [240, 163, 100],
      [178, 217, 57],
      [179, 135, 116],
      [204, 211, 24],
      [186, 135, 57],
      [223, 176, 135],
      [204, 148, 151],
      [116, 223, 50],
      [95, 195, 46],
      [123, 160, 236],
      [181, 172, 131],
      [142, 220, 202],
      [240, 140, 112],
      [172, 145, 164],
      [228, 124, 45],
      [135, 151, 243],
      [42, 205, 125],
      [192, 233, 116],
      [119, 170, 114],
      [158, 138, 26],
      [73, 190, 183],
      [185, 229, 243],
      [227, 107, 55],
      [196, 205, 202],
      [132, 143, 60],
      [233, 192, 237],
      [62, 150, 220],
      [205, 201, 141],
      [106, 140, 190],
      [161, 131, 205],
      [135, 134, 158],
      [198, 139, 81],
      [115, 171, 32],
      [101, 181, 67],
      [149, 137, 119],
      [37, 142, 183],
      [183, 130, 175],
      [168, 125, 133],
      [124, 142, 87],
      [236, 156, 171],
      [232, 194, 91],
      [219, 200, 69],
      [144, 219, 34],
      [219, 95, 187],
      [145, 154, 217],
      [165, 185, 100],
      [127, 238, 163],
      [224, 178, 198],
      [119, 153, 120],
      [124, 212, 92],
      [172, 161, 105],
      [231, 155, 135],
      [157, 132, 101],
      [122, 185, 146],
      [53, 166, 51],
      [70, 163, 90],
      [150, 190, 213],
      [210, 107, 60],
      [166, 152, 185],
      [159, 194, 159],
      [39, 141, 222],
      [202, 176, 161],
      [95, 140, 229],
      [168, 142, 87],
      [93, 170, 203],
      [159, 142, 54],
      [14, 168, 39],
      [94, 150, 149],
      [187, 206, 136],
      [157, 224, 166],
      [235, 158, 208],
      [109, 232, 216],
      [141, 201, 87],
      [208, 124, 118],
      [142, 125, 214],
      [19, 237, 174],
      [72, 219, 41],
      [234, 102, 111],
      [168, 142, 79],
      [188, 135, 35],
      [95, 155, 143],
      [148, 173, 116],
      [223, 112, 95],
      [228, 128, 236],
      [206, 114, 54],
      [195, 119, 88],
      [235, 140, 94],
      [235, 202, 125],
      [233, 155, 153],
      [214, 214, 238],
      [246, 200, 35],
      [151, 125, 171],
      [132, 145, 172],
      [131, 142, 118],
      [199, 126, 150],
      [61, 162, 123],
      [58, 176, 151],
      [215, 141, 69],
      [225, 154, 220],
      [220, 77, 167],
      [233, 161, 64],
      [130, 221, 137],
      [81, 191, 129],
      [169, 162, 140],
      [174, 177, 222],
      [236, 174, 47],
      [233, 188, 180],
      [69, 222, 172],
      [71, 232, 93],
      [118, 211, 238],
      [157, 224, 83],
      [218, 105, 73],
      [126, 169, 36],
    ];
  }

}

<?php

namespace Drupal\klog_paragraphs\Plugin\paragraphs\Behavior;

use Drupal\Component\Utility\Html;
use Drupal\Core\Entity\Display\EntityViewDisplayInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\paragraphs\Entity\Paragraph;
use Drupal\paragraphs\Entity\ParagraphsType;
use Drupal\paragraphs\ParagraphInterface;
use Drupal\paragraphs\ParagraphsBehaviorBase;



/**
 * @ParagraphsBehavior(
 *  id = "klog_paragraphs_gallery",
 *  label = @Translation("Gallery_settings"),
 *  description = @Translation ("Settings for gallery paragraph type"),
 *  weight = 0,
 * )
 */
class GalleryBehavior extends ParagraphsBehaviorBase {

  /**
   * {@inheritdoc}
   */
  public static function isApplicable (ParagraphsType $paragraphs_type) {
    return $paragraphs_type->id() === 'gallery';
  }

  /**
   * Extends the paragraph render array with behavior
   */
  public function view(array &$build, Paragraph $paragraph, EntityViewDisplayInterface $display, $view_mode) {
    $images_per_row = $paragraph->getBehaviorSetting($this->getPluginId(), 'items_per_row', 4);
    $bem_block = 'paragraph-' . $paragraph->bundle() . ($view_mode == 'default' ? '' : '-' . $view_mode);
    $build['#attributes']['class'][] = Html::getClass($bem_block . '--images-per-row-' . $images_per_row);

//    if (isset($build['field_image']) && $build['field_image']['#formatter'] == 'media_thumbnail') {
//      switch ($images_per_row) {
//        case '4':
//        default:
//          $image_style = 'paragraph_text_and_image_4_of_12';
//          break;
//
//        case '3':
//          $image_style = 'paragraph_text_and_image_6_of_12';
//          break;
//
//        case '2':
//          $image_style = 'paragraph_text_and_image_8_of_12';
//          break;
//      };
//    };
  }


  /**
   * {@inheritdoc}
   */
  public function buildBehaviorForm(ParagraphInterface $paragraph, array &$form, FormStateInterface $form_state) {

    $form['items_per_row'] = [
      '#type' => 'select',
      '#title' => $this->t('Number of images per row'),
      '#options' => [
        '2' => $this->formatPlural('2', '1 photo per row', '@count photos per row'),
        '3' => $this->formatPlural('3', '1 photo per row', '@count photos per row'),
        '4' => $this->formatPlural('4', '1 photo per row', '@count photos per row'),
      ],
      '#default_value' => $paragraph->getBehaviorSetting($this->getPluginId(), 'items_per_row', 4),
    ];

    return $form;
  }
}

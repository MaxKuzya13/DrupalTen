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
 *  id = "klog_paragraphs_text_and_image",
 *  label = @Translation("Text and image settings"),
 *  description = @Translation ("Settings for text and image paragraph type"),
 *  weight = 0,
 * )
 */
class TextAndImageBehavior extends ParagraphsBehaviorBase {

  /**
   * {@inheritdoc}
   */
  public static function isApplicable (ParagraphsType $paragraphs_type) {
    return $paragraphs_type->id() === 'text_and_image';
  }

  /**
   * Extends the paragraph render array with behavior
   */
  public function view(array &$build, Paragraph $paragraph, EntityViewDisplayInterface $display, $view_mode) {
    $image_position = $paragraph->getBehaviorSetting($this->getPluginId(), 'image_position', 'left');
    $image_size = $paragraph->getBehaviorSetting($this->getPluginId(), 'image_size', '4_12');
    $bem_block = 'paragraph-' . $paragraph->bundle() . ($view_mode == 'default' ? '' : '-' . $view_mode);

    $build['#attributes']['class'][] = Html::getClass($bem_block);
    $build['#attributes']['class'][] = Html::getClass($bem_block . '--image-size-' . $image_size . '-' . $image_position);

    if (isset($build['field_image']) && $build['field_image']['#formatter'] == 'media_thumbnail') {
      switch ($image_size) {
        case '4_12':
        default:
          $image_style = 'paragraph_text_and_image_4_of_12';
          break;

        case '6_12':
          $image_style = 'paragraph_text_and_image_6_of_12';
          break;

        case '8_12':
          $image_style = 'paragraph_text_and_image_8_of_12';
          break;
      };

      $build['field_image'][0]['#image_style'] = $image_style;
    };
  }


  /**
   * {@inheritdoc}
   */
  public function buildBehaviorForm(ParagraphInterface $paragraph, array &$form, FormStateInterface $form_state) {

    $form['image_position'] = [
      '#type' => 'select',
      '#title' => $this->t('Image position'),
      '#options' => [
        'left' => $this->t('Left'),
        'right' => $this->t('Right'),
      ],
      '#default_value' => $paragraph->getBehaviorSetting($this->getPluginId(), 'image_position', 'left'),
    ];
    $form['image_size'] = [
      '#type' => 'select',
      '#title' => $this->t('Image size'),
      '#description' => $this->t('Size of the image in grid'),
      '#options' => [
        '4_12' => $this->t('4 columns of 12'),
        '6_12' => $this->t('6 columns of 12'),
        '8_12' => $this->t('8 columns of 12'),
      ],
      '#default_value' => $paragraph->getBehaviorSetting($this->getPluginId(), 'image_size', '4_12'),
    ];

    return $form;
  }
}

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
 *  id = "klog_paragraphs_remote_video",
 *  label = @Translation("Remote video settings"),
 *  description = @Translation ("additional settings for remote video paragraph"),
 *  weight = 0,
 * )
 */
class RemoteVideoBehavior extends ParagraphsBehaviorBase {

  /**
   * {@inheritdoc}
   */
  public static function isApplicable (ParagraphsType $paragraphs_type) {
    return $paragraphs_type->id() === 'remote_video';
  }

  /**
   * Extends the paragraph render array with behavior
   */
  public function view(array &$build, Paragraph $paragraph, EntityViewDisplayInterface $display, $view_mode) {
    $max_video_width = $paragraph->getBehaviorSetting($this->getPluginId(), 'video_width', 'full');
    $bem_block = 'paragraph-' . $paragraph->bundle() . ($view_mode == 'default' ? '' : '-' . $view_mode);

    $build['#attributes']['class'][] = Html::getClass($bem_block . '--video-width-' . $max_video_width);
  }


  /**
   * {@inheritdoc}
   */
  public function buildBehaviorForm(ParagraphInterface $paragraph, array &$form, FormStateInterface $form_state) {

     $form['video_width'] = [
       '#type' => 'select',
       '#title' => $this->t('Select video width'),
       '#description' => $this->t('Maximum video width'),
       '#options' => [
         'full' => '100%',
         '720px' => '720px',
       ],
       '#defaul_value' => $paragraph->getBehaviorSetting($this->getPluginId(), 'video_width', 'full'),
     ];

    return $form;
  }

}

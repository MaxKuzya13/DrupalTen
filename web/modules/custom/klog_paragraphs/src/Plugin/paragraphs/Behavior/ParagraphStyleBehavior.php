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
 *  id = "klog_paragraphs_paragraph_style",
 *  label = @Translation("Paragraph styles settings"),
 *  description = @Translation ("Allows to select special style paragraphs"),
 *  weight = 0,
 * )
 */
class ParagraphStyleBehavior extends ParagraphsBehaviorBase {

  /**
   * {@inheritdoc}
   */
  public static function isApplicable (ParagraphsType $paragraphs_type) {
    return TRUE;
  }

  /**
   * {@inheritdoc}
   */
  public function view(array &$build, Paragraph $paragraph, EntityViewDisplayInterface $display, $view_mode) {
    $bem_block = 'paragraph-style';
    $selected_styles = $paragraph->getBehaviorSetting($this->getPluginId(), 'styles', []);

    foreach ($selected_styles as $style) {
        $build['#attributes']['class'][] = Html::getClass($bem_block . '--' . $style);
      }
    }

  /**
   * {@inheritdoc}
   */
  public function buildBehaviorForm(ParagraphInterface $paragraph, array &$form, FormStateInterface $form_state) {

   $form['style_wrapper'] = [
     '#type' => 'details',
     '#title' => $this->t('Paragraph styles'),
     '#open' => FALSE,
   ];

   $styles = $this->getStyles($paragraph);
   $selected_styles = $paragraph->getBehaviorSetting($this->getPluginId(), 'styles', []);
     foreach ($styles as $group_id => $group) {

       $form['style_wrapper'][$group_id] = [
         '#type' => 'checkboxes',
         '#title' => $group['label'],
         '#options' => $group['options'],
         '#default_value' => $selected_styles,
       ];
     }

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitBehaviorForm(ParagraphInterface $paragraph, array &$form, FormStateInterface $form_state) {

    $styles = [];
    $filtered_values = $this->filterBehaviorFormSubmitValues($paragraph, $form, $form_state);

    $style_groups = $filtered_values['style_wrapper'];

    foreach ($style_groups as $group) {
      foreach ($group as $style_name) {
        $styles[] = $style_name;
      }
    }

    $paragraph->setBehaviorSettings($this->getPluginId(), ['styles' => $styles]);

  }

  /**
   * Return styles for paragraph.
   *
   * @param \Drupal\paragraphs\ParagraphInterface
   *   The paragraph.
   *
   * @return array
   *   The array of styles.
   */
  public function getStyles(ParagraphInterface $paragraph) {

    if($paragraph->hasField('field_title')) {
      $style['title'] = [
        'label' => $this->t('Paragraphs title'),
        'options' => [
          'title_bold' => $this->t('Bold'),
          'title_centered' => $this->t('Centered'),
        ],
      ];
    }

    $style['common'] = [
      'label' => $this->t('Paragraphs common styles'),
      'options' => [
        'style_black' => $this->t('Style black'),
      ],
    ];


    return $style;
  }


}

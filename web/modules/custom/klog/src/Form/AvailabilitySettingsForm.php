<?php declare(strict_types = 1);

namespace Drupal\klog\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Configure KLOG settings for this site.
 */
final class AvailabilitySettingsForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId(): string {
    return 'klog_availability_settings';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames(): array {
    return ['klog.availability.settings'];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state): array {
    $form['availability_status'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Availability'),
      '#default_value' => $this->config('klog.availability.settings')->get('status'),
      '#required' => TRUE,
    ];
    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state): void {
    $this->config('klog.availability.settings')
      ->set('status', $form_state->getValue('availability_status'))
      ->save();
    parent::submitForm($form, $form_state);
  }

}

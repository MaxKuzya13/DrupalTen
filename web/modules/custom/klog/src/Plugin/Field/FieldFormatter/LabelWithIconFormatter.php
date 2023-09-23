<?php declare(strict_types = 1);

namespace Drupal\klog\Plugin\Field\FieldFormatter;

use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Field\FieldDefinitionInterface;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Field\Plugin\Field\FieldFormatter\EntityReferenceFormatterBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\media\MediaInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Plugin implementation of the 'Label with icon' formatter.
 *
 * @FieldFormatter(
 *   id = "klog_label_with_icon",
 *   label = @Translation("Label with icon"),
 *   field_types = {"entity_reference"},
 * )
 */
final class LabelWithIconFormatter extends EntityReferenceFormatterBase implements ContainerFactoryPluginInterface {
  /**
   * The entity type manager service.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected EntityTypeManagerInterface $entityTypeManager;

  /**
   * Label with icon formatter constructor.
   *
   * {@inheritdoc}
   */
  public function __construct($plugin_id, $plugin_definition, FieldDefinitionInterface $field_definition, array $settings, $label, $view_mode, array $third_party_settings, EntityTypeManagerInterface $entity_type_manager) {
  parent::__construct($plugin_id, $plugin_definition, $field_definition, $settings, $label, $view_mode, $third_party_settings);
  $this->entityTypeManager = $entity_type_manager;
}

  /**
   * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
   *   The container to pull out services used in the plugin.
   * @param array $configuration
   *   A configuration array containing information about the plugin instance.
   * @param $plugin_id
   *   The plugin ID fot the plugin instance.
   * @param $plugin_definition
   *   The plugin implementation definition
   * @return static
   *  Returns an instance of this plugin.
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $plugin_id,
      $plugin_definition,
      $configuration['field_definition'],
      $configuration['settings'],
      $configuration['label'],
      $configuration['view_mode'],
      $configuration['third_party_settings'],
      $container->get('entity_type.manager')
    );

  }

  /**
   * {@inheritdoc}
   */
  public static function isApplicable(FieldDefinitionInterface $field_definition) {
    return ($field_definition->getFieldStorageDefinition()->getSetting('target_type') == 'media');
  }

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode): array {
    $element = [];
    foreach ($items as $delta => $item) {
      /** @var \Drupal\media\MediaInterface $entity */
      $entity = $this->entityTypeManager->getStorage('media')->load($item->target_id);

      $element[$delta] = [
        '#theme' => 'klog_label_with_icon_media_formatter',
        '#url' => $this->getMediaUrl($entity),
        '#label' => $entity->label(),
        '#filesize' => $this->getMediaFileSize($entity),
        '#media_type' => $entity->bundle(),
        '#mime_type' => $this->getMediaMimeType($entity),
      ];
    }
    return $element;
  }

  /**
   * Gets media URL.
   *
   * @param \Drupal\media\MediaInterface $entity
   *   The entity where to look for url.
   *
   * @return string|null
   *   The url to media or NULL if not found.
   */
  protected function getMediaUrl(MediaInterface $entity) {
    switch ($entity->bundle()) {
      case 'audio':
        return $this->getFileUrlFromField($entity, 'field_media_audio_file');

      case 'document':
        return $this->getFileUrlFromField($entity, 'field_media_document');

      case 'image':
        return $this->getFileUrlFromField($entity, 'field_media_image');

      case 'remote_video':
        return $entity->get('field_media_oembed_video')->value;

      case 'video':
        return $this->getFileUrlFromField($entity, 'field_media_video_file');
    }

    return;
  }



  /**
   * Gets media filed size
   *
   * @param \Drupal\media\MediaInterface $entity
   *   The media entity.
   *
   * @return string|null
   *    The formatted file size if found, NULL otherwise
   */
  protected function getMediaFileSize(MediaInterface $entity) {
    switch ($entity->bundle()) {
      case 'audio':
        return $this->getFileSizeFromField($entity, 'field_media_audio_file');

      case 'document':
        return $this->getFileSizeFromField($entity, 'field_media_document');

      case 'image':
        return $this->getFileSizeFromField($entity, 'field_media_image');

      case 'video':
        return $this->getFileSizeFromField($entity, 'field_media_video_file');
    }

    return;
  }

  /**
   * Gets media dile mime type
   *
   * @param \Drupal\media\MediaInterface $entity
   *   The media entity.
   *
   * @return string
   *   The file mime type.
   */
  protected function getMediaMimeType(MediaInterface $entity) {
    switch ($entity->bundle()) {
      case 'audio':
        return $this->getFileMimeTypeFromField($entity, 'field_media_audio_file');

      case 'document':
        return $this->getFileMimeTypeFromField($entity, 'field_media_document');

      case 'image':
        return $this->getFileMimeTypeFromField($entity, 'field_media_image');

      case 'remote_video':
        return 'video/mp4';

      case 'video':
        return $this->getFileMimeTypeFromField($entity, 'field_media_video_file');

      default:
        return 'application/default';
    }

    return;
  }

  /**
   * Gets file url from fields file.
   *
   * @param \Drupal\media\MediaInterface $entity
   *  The entity with field
   * @param string $field_name
   *  The field name
   *
   * @return string
   *  The file URL.
   */
  public function getFileUrlFromField(MediaInterface $entity, $field_name) {
    /** @var \Drupal\file\FileInterface $file_entity */
    $file_entity = $entity->get($field_name)->entity;
    return $file_entity->createFileUrl();
  }

  /**
   * Gets file size from fields file.
   *
   * @param \Drupal\media\MediaInterface $entity
   *  The entity with field
   * @param string $field_name
   *  The field name
   *
   * @return string
   *  The formatted file size.
   */
  public function getFileSizeFromField(MediaInterface $entity, $field_name) {
    /** @var \Drupal\file\FileInterface $file_entity */
    $file_entity = $entity->get($field_name)->entity;

    return format_size($file_entity->getSize());
  }

  /**
   * Gets file mime type from fields file.
   *
   * @param \Drupal\media\MediaInterface $entity
   *  The entity with field
   * @param string $field_name
   *  The field name
   *
   * @return string
   *  The file mime type.
   */
  public function getFileMimeTypeFromField(MediaInterface $entity, $field_name) {
    /** @var \Drupal\file\FileInterface $file_entity */
    $file_entity = $entity->get($field_name)->entity;
    return $file_entity->getMimeType();
  }

}

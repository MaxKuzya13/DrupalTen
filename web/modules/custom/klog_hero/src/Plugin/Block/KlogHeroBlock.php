<?php

namespace Drupal\klog_hero\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\klog_hero\Plugin\KlogHeroPluginManager;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a klog hero block.
 *
 * @Block(
 *   id = "klog_hero",
 *   admin_label = @Translation("Klog Hero"),
 *   category = @Translation("Custom"),
 * )
 */
final class KlogHeroBlock extends BlockBase implements ContainerFactoryPluginInterface {
  /**
   * The plugin manager for klog hero entity plugins.
   *
   * @var \Drupal\klog_hero\Plugin\KlogHeroPluginManager
   */
  protected KlogHeroPluginManager $klogHeroPathManager;

  /**
   * The plugin manager for klog hero path plugins.
   *
   * @var \Drupal\klog_hero\Plugin\KlogHeroPluginManager
   */
  protected KlogHeroPluginManager $klogHeroEntityManager;

  /**
   * Construct a new KlogHeroBlock instance.
   *
   * @param array $configuration
   *  The plugin configuration.
   * @param $plugin_id
   *  The plugin_id for the plugin interface.
   * @param $plugin_definition
   *  The plugin implementation definition.
   * @param Drupal\klog_hero\Plugin\KlogHeroPluginManager $klog_hero_entity
   *  The plugin manager for klog hero entity plugins.
   * @param Drupal\klog_hero\Plugin\KlogHeroPluginManager $klog_hero_path
   * The plugin manager for klog hero path plugins.
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, KlogHeroPluginManager $klog_hero_entity, KlogHeroPluginManager $klog_hero_path, ) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);

    $this->klogHeroEntityManager = $klog_hero_entity;
    $this->klogHeroPathManager = $klog_hero_path;
  }

  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('plugin.manager.klog_hero.entity'),
      $container->get('plugin.manager.klog_hero.path'),
    );
  }

  /**
   * {@inheritdoc}
   */
  public function build(): array {
    $entity_plugins = $this->klogHeroEntityManager->gerSuitablePlugins();
    $path_plugins = $this->klogHeroPathManager->gerSuitablePlugins();
    $plugins = $entity_plugins + $path_plugins;
    uasort($plugins, '\Drupal\Component\Utility\SortArray::sortByWeightElement');
    $plugin = end($plugins);

    if ($plugin['plugin_type'] == 'entity') {
      /** @var \Drupal\klog_hero\Plugin\KlogHero\KlogHeroPluginInterface $instance */
      $instance = $this->klogHeroEntityManager->createInstance($plugin['id']);
    }

    if ($plugin['plugin_type'] == 'path') {
      $instance = $this->klogHeroPathManager->createInstance($plugin['id']);
    }

    $build['content'] = [
      '#theme' => 'klog_hero',
      '#title' => $instance->getHeroTitle(),
      '#subtitle' => $instance->getHeroSubtitle(),
      '#image' => $instance->getHeroImage(),
      '#video' => $instance->getHeroVideo(),
    ];
    return $build;
  }

  /**
   * {@inheritdoc}
   */
  public function getCacheContexts() {
    return [
      'url.path',
    ];
  }
}

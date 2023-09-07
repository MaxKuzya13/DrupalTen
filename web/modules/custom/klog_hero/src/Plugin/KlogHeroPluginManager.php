<?php

namespace Drupal\klog_hero\Plugin;


use Drupal\Core\Cache\CacheBackendInterface;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Extension\ModuleHandlerInterface;
use Drupal\Core\Path\CurrentPathStack;
use Drupal\Core\Path\PathMatcherInterface;
use Drupal\Core\Plugin\DefaultPluginManager;
use Drupal\Core\Plugin\Factory\ContainerFactory;
use Drupal\Core\Routing\CurrentRouteMatch;
use Symfony\Component\DependencyInjection\Container;

/**
 * KlogHero plugin manager.
 */
class KlogHeroPluginManager extends DefaultPluginManager {

  /**
   * The current path stack.
   *
   * @var Drupal\Core\Path\CurrentPathStack
   */
  protected CurrentPathStack $pathCurrent;

  /**
   * The path matcher.
   *
   * @var Drupal\Core\Path\PathMatcherInterface
   */
  protected PathMatcherInterface $pathMatcher;

  /**
   * The current route match.
   *
   * @var Drupal\Core\Routing\CurrentRouteMatch
   */
  protected CurrentRouteMatch $routeMatch;

  /**
   * @param $type
   *  The KlogHero plugin type.
   * @param \Traversable $namespaces
   *    The namespaces.
   * @param CacheBackendInterface $cache_backend
   *  the cache backend.
   * @param ModuleHandlerInterface $module_handler
   *  The module handler.
   * @param CurrentPathStack $path_current
   *  The current path stack.
   * @param PathMatcherInterface $path_matcher
   *  The path matcher.
   * @param CurrentRouteMatch $current_route_match
   *  The current route match.
   */
  public function __construct($type, \Traversable $namespaces, CacheBackendInterface $cache_backend, ModuleHandlerInterface $module_handler, CurrentPathStack $path_current, PathMatcherInterface $path_matcher, CurrentRouteMatch $current_route_match) {

    $this->pathCurrent = $path_current;
    $this->pathMatcher = $path_matcher;
    $this->routeMatch = $current_route_match;

    // E.g. entity => Entity, path => Path.
    $type_camelized = Container::camelize($type);
    $subdir = "Plugin/KlogHero/{$type_camelized}";
    $plugin_interface = "Drupal\klog_hero\Plugin\KlogHero\{$type_camelized}\KlogHero{$type_camelized}PluginInterface";
    $plugin_definition_annotation_name = "Drupal\klog_hero\Annotation\KlogHero{$type_camelized}";


    parent::__construct($subdir, $namespaces, $module_handler, $plugin_interface, $plugin_definition_annotation_name);


    $this->defaults += [
      'plugin_type' => $type,
      'enabled' => TRUE,
      'weight' => 0,
    ];

    if($type == 'path') {
      $this->defaults += [
        'match_type' => 'listed',
      ];
    }

    // Call hook_klog_hero_TYPE_alter().
    $this->alterInfo("klog_hero_{$type}");

    $this->setCacheBackend($cache_backend, "klog_hero:{$type}");
    $this->factory = new ContainerFactory($this->getDiscovery());

  }

  /**
   * Hers suitable plugins for current request.
   */
  public function getSuitablePlugins() {
    $plugin_type = $this->defaults['plugin_type'];

    if($plugin_type == 'entity') {
      return $this->getSuitableEntityPlugins();
    }

    if ($plugin_type == 'path') {
      return $this->getSuitablePathPlugins();
    }

  }

  /**
   * Gets klog hero entity plugins suitable for current request.
   */
  protected function getSuitableEntityPlugins() {
    $plugins = [];

    $entity = NULL;
    foreach ($this->routeMatch->getParameters() as $parameter) {
      if ($parameter instanceof EntityInterface) {
        $entity = $parameter;
        break;
      }
    };

    if ($entity) {
      foreach ($this->getDefinitions() as $plugin_id => $plugin) {
        if ($plugin['enabled']) {
          $same_entity_type = $plugin['entity_type']  == $entity->getEntityTypeId();
          $needed_bundle = in_array($entity->bundle(), $plugin['entity_bundle']) || in_array('*', $plugin['entity_bundle']);

          if ($same_entity_type && $needed_bundle) {
            $plugins[$plugin_id] = $plugin;
            $plugins[$plugin_id]['entity'] = $entity;
          }
        }
      }
    }


    uasort($plugins, '\Drupal\Component\Utility\SortArray::sortByWeightElement');
    return $plugins;
  }

  /**
   * gets klog hero path plugins suitable for current request
   */
  protected function getSuitablePathPlugins() {

    $plugins = [];

    foreach ($this->getDefinitions() as $plugin_id => $plugin) {
      if ($plugin['enabled']) {
        $patterns = implode(PHP_EOL, $plugin['match_path']);
        $current_path = $this->pathCurrent->getPath();
        $is_match_path = $this->pathMatcher->matchPath($current_path, $patterns);

        switch ($plugin['match_type']) {
          case 'listed':
          default:
            $math_type = 0;
            break;

          case 'unlisted':
            $math_type = 1;
            break;
        }

        $is_plugin_needed = ($is_match_path xor $math_type);

        if($is_plugin_needed) {
          $plugins[$plugin_id] = $plugin;
        }
      }
    }

    uasort($plugins, '\Drupal\Component\Utility\SortArray::sortByWeightElement');
    return $plugins;
  }

}

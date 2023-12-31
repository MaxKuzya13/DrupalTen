<?php

namespace Drupal\klog_taxonomy\Plugin\KlogHero\Entity;

use Drupal\Core\Controller\TitleResolverInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\Routing\CurrentRouteMatch;
use Drupal\klog_hero\Plugin\KlogHero\Entity\KlogHeroEntityPluginBase;
use Drupal\klog_taxonomy\Service\TagsHelperInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Hero block for entity
 *
 * @KlogHeroEntity (
 *    id = "klog_tags",
 *    entity_type = "taxonomy_term",
 *    entity_bundle = {"*"}
 *  )
 */
class KlogTags extends KlogHeroEntityPluginBase implements ContainerFactoryPluginInterface {

  /**
   * The tags helpers.
   *
   * @var \Drupal\klog_taxonomy\Service\TagsHelperInterface
   */
  protected $tagsHelper;

  /**
   * {@inheritdoc}
   */
  public function __construct(array $configuration, string $plugin_id, $plugin_definition, Request $request, CurrentRouteMatch $current_route_match, TitleResolverInterface $title_resolver, EntityTypeManagerInterface $entity_type_manager, TagsHelperInterface $tags_helper) {
    parent::__construct($configuration, $plugin_id, $plugin_definition, $request, $current_route_match, $title_resolver, $entity_type_manager);

    $this->tagsHelper = $tags_helper;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('request_stack')->getCurrentRequest(),
      $container->get('current_route_match'),
      $container->get('title_resolver'),
      $container->get('entity_type.manager'),
      $container->get('klog_taxonomy.tags_helper')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getHeroSubtitle() {
    /** @var \Drupal\taxonomy\TermInterface $term */
    $term = $this->getEntity();

    if(!$term->get('description')->isEmpty()) {
      return $term->getDescription();
    }
  }

  /**
   * {@inheritdoc}
   */
  public function getHeroImage() {
    /** @var \Drupal\taxonomy\TermInterface $term */
    $term = $this->getEntity();

    return $this->tagsHelper->getPromoUri($term->id());
  }
}

<?php declare(strict_types = 1);

namespace Drupal\klog\Service;

use Drupal\Core\Config\ConfigFactoryInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;
use Twig\TwigTest;

/**
 * Twig extension.
 */
final class KlogTwigExtension extends AbstractExtension {

  /**
   * The config factory interface
   *
   * @var \Drupal\Core\Config\ConfigFactoryInterface
   */
  protected ConfigFactoryInterface $configFactory;

  /**
   * Construct a new KlogTwigExtension instance.
   */
  public function __construct(ConfigFactoryInterface $config_factory) {
    $this->configFactory = $config_factory;
  }

  /**
   * {@inheritdoc}
   */
  public function getFunctions(): array {
    return [
      new TwigFunction('klog_availability_status', function() {
        $availability_settings = $this->configFactory->get('klog.availability.settings');
        return $availability_settings->get('status');
      }),
    ];
  }

}

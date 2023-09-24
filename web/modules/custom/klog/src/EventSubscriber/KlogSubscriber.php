<?php declare(strict_types = 1);

namespace Drupal\klog\EventSubscriber;

use Drupal\Core\Session\SessionManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * @todo Add description for this subscriber.
 */
final class KlogSubscriber implements EventSubscriberInterface {

  /**
   * The session manager.
   *
   * @var \Drupal\Core\Session\SessionManagerInterface
   */
  protected $sessionManager;

  /**
   * Constructs a KlogSubscriber object.
   */
  public function __construct(SessionManagerInterface $session_manager) {
    $this->sessionManager = $session_manager;
  }

  /**
   * Kernel request event handler.
   */
  public function onKernelRequest(RequestEvent $event) {
    // for #lazy_builder work for anonymous
    $this->sessionManager->start();
  }



  /**
   * {@inheritdoc}
   */
  public static function getSubscribedEvents(): array {
    return [
      KernelEvents::REQUEST => ['onKernelRequest']
    ];
  }

}

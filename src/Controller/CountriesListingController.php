<?php

namespace Drupal\countries_rest_api\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Logger\LoggerChannelFactoryInterface;
use GuzzleHttp\ClientInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;


class CountriesListingController extends ControllerBase {

  /**
   * The http client service.
   * 
   * @var \GuzzleHttp\ClientInterface
   */
  private $http_client;

  /**
   * The logger channel service.
   * 
   * @var \Drupal\Core\Logger\LoggerChannelFactoryInterface
   */
  private $logger;


  /**
   * Constructs a CountriesListing controller.
   * 
   * @param \GuzzleHttp\ClientInterface $http_client
   *   The http client service.
   * @param \Drupal\Core\Logger\LoggerChannelFactoryInterface $logger
   *   The logger channel service.
   */
  public function __construct(ClientInterface $http_client, LoggerChannelFactoryInterface $logger) {
    $this->http_client = $http_client;
    $this->logger = $logger->get('countries_rest_api');
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('http_client'),
      $container->get('logger.factory')
    );  
  }

  public function content() {
    $build = [];

    return $build;
  }
}

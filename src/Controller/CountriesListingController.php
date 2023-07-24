<?php

namespace Drupal\countries_rest_api\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Logger\LoggerChannelFactoryInterface;
use Drupal\countries_rest_api\CountriesService;
use Symfony\Component\DependencyInjection\ContainerInterface;


class CountriesListingController extends ControllerBase {

  /**
   * @var \Drupal\countries_rest_api\CountriesService
   */
  protected $countries_service;

  /**
   * @var Drupal\Core\Logger\LoggerChannel
   */
  protected $logger;


  /**
   * Constructs a CountriesListing object.
   * 
   * @param \Drupal\Core\Logger\LoggerChannelFactoryInterface $logger
   *   The logger channel service.
   */
  public function __construct(CountriesService $countries_service, LoggerChannelFactoryInterface $logger) {
    $this->countries_service = $countries_service;
    $this->logger = $logger->get('countries_rest_api');
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('countries_rest_api.countries'),
      $container->get('logger.factory')
    );  
  }

  public function content() {
    $build = [];



    return $build;
  }
}

<?php

namespace Drupal\countries_rest_api\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Logger\LoggerChannelFactoryInterface;
use Drupal\countries_rest_api\CountriesService;
use Symfony\Component\DependencyInjection\ContainerInterface;


class CountriesDetailController extends ControllerBase {

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

  public function content($name) {
    $countryDetails = $this->countries_service->getCountryByName($name)[0];

    dump($countryDetails);

    $names = [
      'common_name' => $countryDetails['name']['common'],
      'official' => $countryDetails['name']['official'],
    ];

    return [
      '#theme' => 'country_details_list',
      '#names' => $names,
      '#independent' => $countryDetails['independent'],
      '#currency' => array_shift($countryDetails['currencies'])['name'],
      '#capital' => $countryDetails['capital'][0],
      '#region' => $countryDetails['region'],
      '#subregion' => $countryDetails['subregion'],
      '#languages' => array_values($countryDetails['languages']),
      '#maps' => $countryDetails['maps']['googleMaps'],
      '#timezone' => $countryDetails['timezones'][0],
      '#continent' => $countryDetails['continents'][0],
    ];
  }
}

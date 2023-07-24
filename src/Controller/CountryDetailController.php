<?php

namespace Drupal\countries_rest_api\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\countries_rest_api\CountriesService;
use Symfony\Component\DependencyInjection\ContainerInterface;


class CountryDetailController extends ControllerBase {

  /**
   * @var \Drupal\countries_rest_api\CountriesService
   */
  protected $countries_service;


  /**
   * Constructs a CountriesListing object.
   * 
   * @param \Drupal\countries_rest_api\CountriesService $countries_service
   *  The Countries Service.
   */
  public function __construct(CountriesService $countries_service) {
    $this->countries_service = $countries_service;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('countries_rest_api.countries'),
    );
  }

  public function content($name) {
    $countryDetails = $this->countries_service->getCountryByName($name)[0];

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

  public function titleCallback($name) {
    return "$name Details";
  }
}

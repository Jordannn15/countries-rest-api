<?php

namespace Drupal\countries_rest_api\Controller;

use Drupal\Core\Url;
use Drupal\Core\Controller\ControllerBase;
use Drupal\countries_rest_api\CountriesService;
use Symfony\Component\DependencyInjection\ContainerInterface;


class CountryListingController extends ControllerBase {

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

  public function content() {
    $countriesList = $this->countries_service->getAllCountries();

    $characteristics = [];
    $regions = [];

    foreach ($countriesList as $country) {
      if (!array_key_exists(0, $country['capital'])) {
        continue;
      }

      $regions[] = $country['region'];

      $name = $country['name']['official'];

      $characteristics[] = [
        'url' => Url::fromRoute('country-details.content', ['name' => $name], []),
        'name' => $name,
        'capital' => $country['capital'][0],
        'region' => $country['region'],
      ];
    }

    $regions = array_unique($regions);

    return [
      '#theme' => 'country_list',
      '#characteristics' => $characteristics,
      '#attached' => [
        'library' => [ 'countries_rest_api/country_list' ],
      ],
    ];
  }
}

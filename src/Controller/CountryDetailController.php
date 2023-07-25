<?php

namespace Drupal\countries_rest_api\Controller;

use Drupal\Core\Url;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Messenger\MessengerTrait;
use Drupal\countries_rest_api\CountriesService;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;


class CountryDetailController extends ControllerBase {

  use MessengerTrait;

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
    $countryDetails = $this->countries_service->getCountryByName($name);

    if (empty($countryDetails)) {
      $this->messenger()->addError('You were redirected to the countries listing page because an invalid country name was used.');
      return new RedirectResponse(Url::fromRoute('countries.content')->toString());
    }

    $names = [
      'common_name' => $countryDetails[0]['name']['common'],
      'official' => $countryDetails[0]['name']['official'],
    ];

    return [
      '#theme' => 'country_details_list',
      '#names' => $names,
      '#independent' => $countryDetails[0]['independent'],
      '#currency' => array_shift($countryDetails[0]['currencies'])['name'],
      '#capital' => $countryDetails[0]['capital'][0],
      '#region' => $countryDetails[0]['region'],
      '#subregion' => $countryDetails[0]['subregion'],
      '#languages' => array_values($countryDetails[0]['languages']),
      '#maps' => $countryDetails[0]['maps']['googleMaps'],
      '#timezone' => $countryDetails[0]['timezones'][0],
      '#continent' => $countryDetails[0]['continents'][0],
    ];
  }

  public function titleCallback($name) {
    return "$name Details";
  }
}

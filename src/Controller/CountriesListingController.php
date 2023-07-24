<?php

namespace Drupal\countries_rest_api\Controller;

use Drupal\Core\Url;
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
    $countriesList = $this->countries_service->getAllCountries();

    $build = [
      '#type' => 'container',
      '#attributes' => [
        'id' => 'countries-container',
      ],
      '#attached' => [
        'library' => [ 'countries_rest_api/countries_list' ],
      ],
    ];

    foreach ($countriesList as $country) {
      if (!array_key_exists(0, $country['capital'])) {
        continue;
      }

      $name = $country['name']['official'];
      $capital = $country['capital'][0];
      $region = $country['region'];

      $build[] = [
        '#type' => 'container',
        '#attributes' => [
          'class' => [ 'country-details' ],
        ],
        'link' => [
          '#type' => 'link',
          '#title' => $name,
          '#url' => Url::fromRoute('country-details.content', ['name' => $name], []),
          'content' => [
            '#markup' => "
              <h1>$name</h1>
              <div id='capital-container'>
                <span id='capital'>Capital: </span><p>$capital</p>
              </div>
              <div id='region-container'>
                <span id='region'>Region: </span><p>$region</p>
              </div>
            "
          ],
        ],
      ];
    }

    return $build;
  }
}

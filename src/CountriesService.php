<?php

namespace  Drupal\countries_rest_api;

use Drupal\Core\Logger\LoggerChannelFactoryInterface;
use GuzzleHttp\Client;

class CountriesService {

 /**
   * GuzzleHttp\Client definition.
   *
   * @var GuzzleHttp\Client
   */
  protected $http_client;

  /**
   * @var Drupal\Core\Logger\LoggerChannel
   */
  protected $logger;

  /**
   * Constructs a new Subsite object.
   *
   * @param Client $http_client
   * @param LoggerChannelFactoryInterface $logger
   */
  public function __construct(Client $http_client, LoggerChannelFactoryInterface $logger) {
    $this->http_client = $http_client;
    $this->logger = $logger->get('countries_rest_api');
  }

  public function getAllCountries(): array {
    try {
      $response = $this->http_client->get('https://restcountries.com/v3.1/all');
    } catch (Exception $e) {
      $this->logger->notice('Countries could not be fetched.');
    }

    return $response->getBody();
  }

}

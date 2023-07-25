# Countries REST API

Provides a page with a list of all countries with a search function and region filter. Also provides a page for each country with more detailed information.

## API

The API with documentation used in this project can be found here: https://restcountries.com/

## Endpoints

The endpoints used in this project are:
  - https://restcountries.com/v3.1/all
  - https://restcountries.com/v3.1/name/{name}

## Countries Service

Service that makes calls to the above two endpoints and returns data about the countries.

## Custom Routes

The custom routes created in this project are:
  - /countries-listing
    - Provides a list of all countries with their name, capital, and region with a search function and region filter
  - /countries-listing/{name}/details
    - Provides a dynamic route and dynamic title for each country and lists more information about them
    - Redirects to the /countries-listing route and provides an error message if invalid selection occurs

## Search and Filter Functionality

Allows users to search for any string within a country's name and filter based on the region(s) of countries, created with javascript.

## Custom Templates

The controllers take in route parameters if any and then build a render array that is used to provide variables to the two custom templates:
  - country-list.html.twig which renders all of the countries with their name, capital, and region along with the search and filter
  - country-details-list.html.twig which renders more information about a the selected country

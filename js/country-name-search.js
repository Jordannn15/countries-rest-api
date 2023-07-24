(function (Drupal, once) {

  document.getElementById('country-name-search').onkeyup = () => searchCountries();
  
  function searchCountries() {
    let input = document.getElementById('country-name-search');
    let filter = input.value.toUpperCase();
    let detailContainers = document.querySelectorAll('#countries-container .country-details');

    // Loop through all list items, and hide those who don't match the search query
    for (i = 0; i < detailContainers.length; i++) {
      a = detailContainers[i].getElementsByTagName("a")[0];
      textVal = a.textContent || a.innerText;

      if (textVal.toUpperCase().indexOf(filter) > -1) {
        detailContainers[i].style.display = "";
      } else {
        detailContainers[i].style.display = "none";
      }
    }
  }

})(Drupal, once);

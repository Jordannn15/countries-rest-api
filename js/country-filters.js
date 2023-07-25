(function () {

  document.getElementById('country-name-search').onkeyup = () => filterCountries();
  document.querySelectorAll('#region-filters input').forEach(checkbox => {
    checkbox.onclick = () => filterCountries();
  });
  
  function filterCountries() {
    const errorMessages = document.getElementsByClassName('messages--error');

    if (errorMessages.length) {
      for (message of errorMessages) {
        message.remove();
      }
    }

    let input = document.getElementById('country-name-search');
    let searchfilter = input.value.toLowerCase();
    let detailContainers = document.querySelectorAll('#countries-container .country-details');

    let checkboxVals = [];
    document.querySelectorAll('#region-filters input:checked').forEach(checkbox => {
      checkboxVals.push(checkbox.value);
    });

    for (i = 0; i < detailContainers.length; i++) {
      let a = detailContainers[i].getElementsByTagName('a')[0];
      let textVal = (a.textContent || a.innerText).toLowerCase();

      let region = detailContainers[i].querySelector('#region-container p');
      let regionVal = (region.textContent || region.innerText).toLowerCase();

      if (checkboxVals.length) {
        if (textVal.indexOf(searchfilter) > -1 && checkboxVals.includes(regionVal)) {
          detailContainers[i].style.display = '';
        } else {
          detailContainers[i].style.display = 'none';
        }
      } else if (textVal.indexOf(searchfilter) > -1) {
        detailContainers[i].style.display = '';
      } else {
        detailContainers[i].style.display = 'none';
      }
    }
  }

})();

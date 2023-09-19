//Getting the page 1 back button
var button = document.getElementById('page1');
//adding an event listener that redirects to the home page catalog.php
button.addEventListener('click', function() {
  document.location.href = '../php/catalog.php';
});

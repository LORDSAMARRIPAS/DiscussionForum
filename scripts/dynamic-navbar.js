// dynamic-navbar.js
document.addEventListener("DOMContentLoaded", function() {
  fetch('../php/navbar.php') 
    .then(response => response.text())
    .then(html => {
      document.getElementById('navbar').innerHTML = html;
    })
    .catch(error => {
      console.error('Error loading navbar:', error);
    });
});

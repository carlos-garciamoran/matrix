// Code snippet taken from getbootstrap.com/docs/4.1/components/forms/#custom-styles
var form = document.getElementsByClassName('needs-validation')[0];
var validation = form.addEventListener('submit', function(event) {
if (form.checkValidity() === false) {
  event.preventDefault();
  event.stopPropagation();
}
form.classList.add('was-validated');
}, false);
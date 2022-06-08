function printDiv(divID) {
  'use strict';
  let divElements = document.getElementById(divID).innerHTML;
  let oldPage     = document.body.innerHTML;
  document.body.innerHTML = "<html><head><title></title></head><body>" + divElements + "</body>";
  window.print();
  document.body.innerHTML = oldPage;
  window.location.reload();
}
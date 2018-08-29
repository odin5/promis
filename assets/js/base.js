import constants from './config.js';

require('./baseParts/leftMenu.js');

if($) {
  let $tooltips = $('[data-toggle="tooltip"]');
  if($tooltips.length > 0) {
    $tooltips.tooltip();
  }
}

document.addEventListener('DOMContentLoaded', function() {
  let elems, instances;
  elems = document.querySelectorAll('.modal');
  instances = M.Modal.init(elems);
  elems = document.querySelectorAll('select');
  instances = M.FormSelect.init(elems);
  elems = document.querySelectorAll('.tooltipped');
  instances = M.Tooltip.init(elems);
});
// document.addEventListener('DOMContentLoaded', function() {
//   const elems = document.querySelectorAll('.sidenav');
//   const instances = M.Sidenav.init(elems);
//   //instances.forEach((i) => i.open());
// });


// document.querySelectorAll('h1').forEach((el) => el.innerHTML = 'nopee');
// $('h1').html('wooo');
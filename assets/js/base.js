import constants from './constants.js';

require('./baseParts/leftMenu.js');

document.addEventListener('DOMContentLoaded', function() {
    const elems = document.querySelectorAll('.modal');
    const instances = M.Modal.init(elems);
});
document.addEventListener('DOMContentLoaded', function() {
    const elems = document.querySelectorAll('.sidenav');
    const instances = M.Sidenav.init(elems);
    //instances.forEach((i) => i.open());
});


// document.querySelectorAll('h1').forEach((el) => el.innerHTML = 'nopee');
// $('h1').html('wooo');
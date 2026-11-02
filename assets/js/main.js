(function () {
  var nav = document.getElementById('nav'), burger = document.getElementById('burger');
  burger.addEventListener('click', function () {
    var open = nav.classList.toggle('menu-open');
    burger.setAttribute('aria-expanded', open ? 'true' : 'false');
    burger.setAttribute('aria-label', open ? 'Close menu' : 'Open menu');
  });
  function ready() { document.body.classList.add('is-ready'); }
  if (document.readyState === 'complete') setTimeout(ready, 700);
  else window.addEventListener('load', function () { setTimeout(ready, 700); });
  setTimeout(ready, 3500); // safety net
})();

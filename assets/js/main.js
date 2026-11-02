(function () {
  var nav = document.getElementById('nav'), burger = document.getElementById('burger');
  function setMenu(open) {
    nav.classList.toggle('menu-open', open);
    if (open) nav.classList.remove('is-hidden');
    document.body.classList.toggle('menu-lock', open);
    burger.setAttribute('aria-expanded', open ? 'true' : 'false');
    burger.setAttribute('aria-label', open ? 'Close menu' : 'Open menu');
  }
  burger.addEventListener('click', function () { setMenu(!nav.classList.contains('menu-open')); });
  document.addEventListener('keydown', function (e) { if (e.key === 'Escape') setMenu(false); });
  window.addEventListener('resize', function () { if (window.innerWidth > 1100) setMenu(false); });
  window.addEventListener('menuclose', function () { setMenu(false); });

  function ready() { document.body.classList.add('is-ready'); }
  if (document.readyState === 'complete') setTimeout(ready, 700);
  else window.addEventListener('load', function () { setTimeout(ready, 700); });
  setTimeout(ready, 3500); // safety net
})();

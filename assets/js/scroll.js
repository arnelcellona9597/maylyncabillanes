/* Lightweight smooth scroll (lerp) + progress bar + nav state. */
(function () {
  var reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  var touch = window.matchMedia('(hover: none)').matches;
  var bar = document.querySelector('.progress span');
  var nav = document.getElementById('nav');
  var links = [].slice.call(document.querySelectorAll('.nav__links a'));
  var sections = links.map(function (a) { return document.querySelector(a.getAttribute('href')); });
  var current = window.scrollY, target = current, lastY = current, ticking = false;
  var useSmooth = !reduce && !touch;

  function max() { return document.documentElement.scrollHeight - window.innerHeight; }

  function ui(y) {
    bar.style.transform = 'scaleX(' + (max() > 0 ? y / max() : 0) + ')';
    nav.classList.toggle('is-scrolled', y > 30);
    var down = y > lastY && y > 400;
    if (!nav.classList.contains('menu-open')) nav.classList.toggle('is-hidden', down);
    lastY = y;
    var idx = -1, probe = y + window.innerHeight * 0.35;
    sections.forEach(function (s, i) { if (s && s.offsetTop <= probe) idx = i; });
    links.forEach(function (a, i) { a.classList.toggle('is-active', i === idx); });
    window.dispatchEvent(new CustomEvent('scrollupdate', { detail: y }));
  }

  if (useSmooth) {
    window.addEventListener('wheel', function (e) {
      if (e.ctrlKey) return;
      e.preventDefault();
      target = Math.max(0, Math.min(max(), target + e.deltaY * (e.deltaMode === 1 ? 32 : 1)));
      if (!ticking) { ticking = true; requestAnimationFrame(loop); }
    }, { passive: false });
    window.addEventListener('keydown', function () { setTimeout(function () { target = window.scrollY; current = target; }, 50); });
    window.addEventListener('scroll', function () {
      if (!ticking) { target = current = window.scrollY; ui(current); }
    }, { passive: true });
  } else {
    window.addEventListener('scroll', function () { ui(window.scrollY); }, { passive: true });
  }

  function loop() {
    current += (target - current) * 0.085;
    if (Math.abs(target - current) < 0.4) { current = target; ticking = false; }
    window.scrollTo(0, current);
    ui(current);
    if (ticking) requestAnimationFrame(loop);
  }

  window.smoothTo = function (y) {
    if (useSmooth) {
      target = Math.max(0, Math.min(max(), y));
      if (!ticking) { ticking = true; requestAnimationFrame(loop); }
    } else {
      window.scrollTo({ top: y, behavior: reduce ? 'auto' : 'smooth' });
    }
  };

  document.querySelectorAll('a[href^="#"]').forEach(function (a) {
    a.addEventListener('click', function (e) {
      var id = a.getAttribute('href');
      var el = id === '#top' ? document.body : document.querySelector(id);
      if (!el) return;
      e.preventDefault();
      window.dispatchEvent(new Event('menuclose'));
      /* Keyboard/screen-reader users: move focus to the section that was jumped to. */
      if (id !== '#top') {
        if (!el.hasAttribute('tabindex')) el.setAttribute('tabindex', '-1');
        try { el.focus({ preventScroll: true }); } catch (err) {}
      }
      window.smoothTo(id === '#top' ? 0 : el.getBoundingClientRect().top + window.scrollY - 40);
    });
  });
  ui(window.scrollY);
})();

/* Gallery slider: arrows, dots, autoplay, swipe/drag, keyboard. */
(function () {
  var root = document.getElementById('gallerySlider');
  if (!root) return;
  var view = document.getElementById('galleryViewport'), rail = document.getElementById('rail');
  var prev = document.getElementById('galPrev'), next = document.getElementById('galNext');
  var dotsEl = document.getElementById('galDots'), playBtn = document.getElementById('galPlay');
  var items = [].slice.call(rail.querySelectorAll('.g-item'));
  var reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  var DELAY = 4800;
  var positions = [0], index = 0, playing = !reduce, inView = false, hovered = false, focused = false;
  var timer = 0, dragging = false, startX = 0, startShift = 0, moved = 0, curShift = 0;

  function padLeft() { return parseFloat(getComputedStyle(rail).paddingLeft) || 0; }

  function measure() {
    var pad = padLeft(), vw = view.clientWidth;
    var maxShift = Math.max(0, rail.scrollWidth - vw);
    positions = [];
    for (var i = 0; i < items.length; i++) {
      var p = items[i].offsetLeft - pad;
      if (p < maxShift - 8) positions.push(Math.max(0, p)); else break;
    }
    if (!positions.length || positions[positions.length - 1] < maxShift - 8) positions.push(maxShift);
    else positions[positions.length - 1] = maxShift;
    positions = positions.filter(function (v, i, a) { return i === 0 || v > a[i - 1] + 1; });
    if (index > positions.length - 1) index = positions.length - 1;
    buildDots(); go(index, true);
  }

  function buildDots() {
    dotsEl.innerHTML = '';
    positions.forEach(function (_, i) {
      var b = document.createElement('button');
      b.type = 'button'; b.className = 'slider__dot'; b.setAttribute('role', 'tab');
      b.setAttribute('aria-label', 'Go to slide ' + (i + 1) + ' of ' + positions.length);
      b.addEventListener('click', function () { go(i); restart(); });
      dotsEl.appendChild(b);
    });
  }

  function paint() {
    [].forEach.call(dotsEl.children, function (d, i) {
      var on = i === index;
      d.classList.toggle('is-active', on);
      d.setAttribute('aria-selected', on ? 'true' : 'false');
      d.style.setProperty('--dur', DELAY + 'ms');
    });
    root.classList.toggle('is-playing', playing && !hovered && !focused && inView);
  }

  function go(i, instant) {
    index = (i + positions.length) % positions.length;
    curShift = positions[index] || 0;
    rail.style.transition = instant ? 'none' : '';
    rail.style.transform = 'translate3d(' + (-curShift) + 'px,0,0)';
    if (instant) { void rail.offsetWidth; rail.style.transition = ''; }
    paint();
  }

  function tick() {
    clearTimeout(timer); timer = 0;
    var lb = document.getElementById('lightbox');
    if (playing && !hovered && !focused && inView && !dragging && !document.hidden && !(lb && !lb.hidden)) {
      timer = setTimeout(function () { go(index + 1); tick(); }, DELAY);
    }
    paint();
  }
  function restart() { tick(); }

  prev.addEventListener('click', function () { go(index - 1); restart(); });
  next.addEventListener('click', function () { go(index + 1); restart(); });
  playBtn.addEventListener('click', function () {
    playing = !playing;
    playBtn.setAttribute('aria-pressed', playing ? 'true' : 'false');
    playBtn.setAttribute('aria-label', playing ? 'Pause autoplay' : 'Start autoplay');
    playBtn.classList.toggle('is-paused', !playing);
    tick();
  });

  root.addEventListener('mouseenter', function () { hovered = true; tick(); });
  root.addEventListener('mouseleave', function () { hovered = false; tick(); });
  root.addEventListener('focusin', function (e) { focused = !!(e.target.matches && e.target.matches(':focus-visible')); tick(); });
  root.addEventListener('focusout', function () { focused = false; tick(); });
  document.addEventListener('visibilitychange', tick);
  root.addEventListener('keydown', function (e) {
    if (e.key === 'ArrowLeft') { go(index - 1); restart(); }
    if (e.key === 'ArrowRight') { go(index + 1); restart(); }
  });

  /* Swipe / drag: vertical page scroll is left to the browser (touch-action: pan-y). */
  view.addEventListener('pointerdown', function (e) {
    if (e.pointerType === 'mouse' && e.button !== 0) return;
    dragging = true; moved = 0; startX = e.clientX; startShift = curShift;
    rail.style.transition = 'none'; clearTimeout(timer);
  });
  window.addEventListener('pointermove', function (e) {
    if (!dragging) return;
    var dx = e.clientX - startX; moved = Math.max(moved, Math.abs(dx));
    var maxShift = positions[positions.length - 1] || 0;
    var s = startShift - dx;
    if (s < 0) s *= 0.35; else if (s > maxShift) s = maxShift + (s - maxShift) * 0.35;
    rail.style.transform = 'translate3d(' + (-s) + 'px,0,0)';
    if (moved > 6) view.classList.add('is-dragging');
  });
  function endDrag(e) {
    if (!dragging) return; dragging = false;
    rail.style.transition = ''; view.classList.remove('is-dragging');
    var dx = e.clientX - startX;
    if (Math.abs(dx) > 50) go(dx < 0 ? index + 1 : index - 1); else go(index);
    tick();
  }
  window.addEventListener('pointerup', endDrag);
  window.addEventListener('pointercancel', endDrag);
  /* A drag must not open the lightbox. */
  view.addEventListener('click', function (e) {
    if (moved > 6) { e.stopPropagation(); e.preventDefault(); moved = 0; }
  }, true);
  view.addEventListener('dragstart', function (e) { e.preventDefault(); });

  new IntersectionObserver(function (en) { inView = en[0].isIntersecting; tick(); }, { threshold: 0.25 }).observe(root);
  var rt; window.addEventListener('resize', function () { clearTimeout(rt); rt = setTimeout(measure, 150); });
  window.addEventListener('load', measure);
  if (reduce) { playBtn.classList.add('is-paused'); playBtn.setAttribute('aria-pressed', 'false'); playBtn.setAttribute('aria-label', 'Start autoplay'); }
  measure();
})();

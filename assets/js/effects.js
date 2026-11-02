(function () {
  var reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  var fine = window.matchMedia('(hover: hover) and (pointer: fine)').matches;
  var $ = function (s, c) { return [].slice.call((c || document).querySelectorAll(s)); };

  /* Split hero title into letters */
  $('[data-split]').forEach(function (el, n) {
    var t = el.textContent; el.textContent = ''; el.setAttribute('aria-hidden', 'true');
    t.split('').forEach(function (c, i) {
      var s = document.createElement('span'); s.className = 'ch'; s.textContent = c;
      s.style.setProperty('--i', i + n * 6); el.appendChild(s);
    });
  });

  /* Hero canvas: drifting gold dust + connecting light */
  var cv = document.getElementById('heroCanvas');
  if (cv && !reduce) {
    var ctx = cv.getContext('2d'), W, H, dpr, parts = [], mouse = { x: -999, y: -999 }, run = true;
    function size() {
      dpr = Math.min(window.devicePixelRatio || 1, 2);
      W = cv.clientWidth; H = cv.clientHeight;
      cv.width = W * dpr; cv.height = H * dpr; ctx.setTransform(dpr, 0, 0, dpr, 0, 0);
      var n = Math.round(Math.min(110, W * H / 14000));
      parts = [];
      for (var i = 0; i < n; i++) parts.push({
        x: Math.random() * W, y: Math.random() * H, r: Math.random() * 1.8 + .4,
        vx: (Math.random() - .5) * .25, vy: -Math.random() * .35 - .05, a: Math.random() * .6 + .2
      });
    }
    function rgb() { return document.documentElement.getAttribute('data-theme') === 'light' ? '154,116,48' : '232,207,150'; }
    function draw() {
      if (run) {
        ctx.clearRect(0, 0, W, H);
        var c = rgb();
        for (var i = 0; i < parts.length; i++) {
          var p = parts[i];
          var dx = p.x - mouse.x, dy = p.y - mouse.y, d = dx * dx + dy * dy;
          if (d < 14000) { var f = (1 - d / 14000) * 1.4; p.x += dx / 40 * f; p.y += dy / 40 * f; }
          p.x += p.vx; p.y += p.vy;
          if (p.y < -5) { p.y = H + 5; p.x = Math.random() * W; }
          if (p.x < -5) p.x = W + 5; if (p.x > W + 5) p.x = -5;
          ctx.beginPath(); ctx.arc(p.x, p.y, p.r, 0, 6.283);
          ctx.fillStyle = 'rgba(' + c + ',' + p.a + ')'; ctx.fill();
          for (var j = i + 1; j < parts.length; j++) {
            var q = parts[j], ax = p.x - q.x, ay = p.y - q.y, dd = ax * ax + ay * ay;
            if (dd < 9000) {
              ctx.strokeStyle = 'rgba(' + c + ',' + (0.14 * (1 - dd / 9000)) + ')';
              ctx.lineWidth = .6; ctx.beginPath(); ctx.moveTo(p.x, p.y); ctx.lineTo(q.x, q.y); ctx.stroke();
            }
          }
        }
      }
      requestAnimationFrame(draw);
    }
    window.addEventListener('resize', size); size(); draw();
    window.addEventListener('pointermove', function (e) {
      var r = cv.getBoundingClientRect(); mouse.x = e.clientX - r.left; mouse.y = e.clientY - r.top;
    });
    new IntersectionObserver(function (e) { run = e[0].isIntersecting; }).observe(cv);
  }

  /* Custom cursor */
  if (fine) {
    document.body.classList.add('has-cursor');
    var cur = document.querySelector('.cursor'), dot = cur.children[0], ring = cur.children[1];
    var mx = 0, my = 0, rx = 0, ry = 0;
    window.addEventListener('pointermove', function (e) {
      mx = e.clientX; my = e.clientY; dot.style.transform = 'translate(' + mx + 'px,' + my + 'px)';
    });
    (function tick() { rx += (mx - rx) * .16; ry += (my - ry) * .16; ring.style.transform = 'translate(' + rx + 'px,' + ry + 'px)'; requestAnimationFrame(tick); })();
    document.addEventListener('pointerover', function (e) {
      cur.classList.toggle('is-hover', !!e.target.closest('a,button,.card,input,textarea'));
    });
  }

  /* Magnetic buttons + ripple */
  $('[data-magnetic]').forEach(function (el) {
    if (fine && !reduce) {
      el.addEventListener('pointermove', function (e) {
        var r = el.getBoundingClientRect();
        el.style.transform = 'translate(' + (e.clientX - r.left - r.width / 2) * .22 + 'px,' + (e.clientY - r.top - r.height / 2) * .32 + 'px)';
      });
      el.addEventListener('pointerleave', function () { el.style.transform = ''; });
    }
  });
  $('.btn').forEach(function (b) {
    b.addEventListener('click', function (e) {
      var r = b.getBoundingClientRect(), s = Math.max(r.width, r.height), sp = document.createElement('span');
      sp.className = 'ripple'; sp.style.cssText = 'width:' + s + 'px;height:' + s + 'px;left:' + (e.clientX - r.left - s / 2) + 'px;top:' + (e.clientY - r.top - s / 2) + 'px';
      b.appendChild(sp); setTimeout(function () { sp.remove(); }, 800);
    });
  });

  /* Card spotlight */
  $('[data-spot]').forEach(function (c) {
    c.addEventListener('pointermove', function (e) {
      var r = c.getBoundingClientRect();
      c.style.setProperty('--mx', (e.clientX - r.left) + 'px'); c.style.setProperty('--my', (e.clientY - r.top) + 'px');
    });
  });

  /* Hero portrait tilt */
  if (fine && !reduce) $('[data-tilt]').forEach(function (el) {
    el.addEventListener('pointermove', function (e) {
      var r = el.getBoundingClientRect(), x = (e.clientX - r.left) / r.width - .5, y = (e.clientY - r.top) / r.height - .5;
      el.style.transform = 'perspective(900px) rotateY(' + x * 9 + 'deg) rotateX(' + -y * 9 + 'deg)';
    });
    el.addEventListener('pointerleave', function () { el.style.transform = ''; });
    el.style.transition = 'transform .6s cubic-bezier(.22,1,.36,1)';
  });

  /* Reveal on scroll with stagger */
  var io = new IntersectionObserver(function (es) {
    es.forEach(function (e) { if (e.isIntersecting) { e.target.classList.add('in'); io.unobserve(e.target); } });
  }, { threshold: .15, rootMargin: '0px 0px -6% 0px' });
  $('.grid3, .timeline, .edu__list, .hero__copy, .about__text, .contact__intro, .section__head').forEach(function (g) {
    $('.reveal', g).forEach(function (el, i) { el.style.setProperty('--d', (i * 0.09) + 's'); });
  });
  $('.reveal, .reveal-img').forEach(function (el) { io.observe(el); });

  /* Counters */
  $('[data-count]').forEach(function (el) {
    var end = +el.dataset.count;
    new IntersectionObserver(function (e, o) {
      if (!e[0].isIntersecting) return; o.disconnect();
      var t0 = performance.now();
      (function step(t) { var p = Math.min(1, (t - t0) / 1400); el.textContent = Math.round(end * (1 - Math.pow(1 - p, 3))); if (p < 1) requestAnimationFrame(step); })(t0);
    }).observe(el);
  });

  /* Parallax (driven by scroll updates) */
  var par = $('[data-parallax]');
  function parallax() {
    var vh = window.innerHeight;
    par.forEach(function (el) {
      var r = el.getBoundingClientRect(); if (r.bottom < -100 || r.top > vh + 100) return;
      el.style.transform = 'translate3d(0,' + ((r.top + r.height / 2 - vh / 2) * parseFloat(el.dataset.parallax) * -1) + 'px,0)';
    });
  }
  if (!reduce) window.addEventListener('scrollupdate', parallax);

  /* Lightbox */
  var lb = document.getElementById('lightbox'), lbi = document.getElementById('lightboxImg');
  var items = $('.g-item, .c-item'), idx = 0;
  function show(i) {
    idx = (i + items.length) % items.length;
    lbi.src = 'assets/img/' + items[idx].dataset.full + '.jpg'; lbi.alt = items[idx].dataset.alt;
  }
  function open(i) { show(i); lb.hidden = false; requestAnimationFrame(function () { lb.classList.add('is-open'); }); document.body.style.overflow = 'hidden'; }
  function close() { lb.classList.remove('is-open'); setTimeout(function () { lb.hidden = true; document.body.style.overflow = ''; }, 400); }
  items.forEach(function (it, i) { it.addEventListener('click', function () { open(i); }); });
  lb.querySelector('.lightbox__close').addEventListener('click', close);
  lb.querySelector('.lightbox__prev').addEventListener('click', function () { show(idx - 1); });
  lb.querySelector('.lightbox__next').addEventListener('click', function () { show(idx + 1); });
  lb.addEventListener('click', function (e) { if (e.target === lb) close(); });
  document.addEventListener('keydown', function (e) {
    if (lb.hidden) return;
    if (e.key === 'Escape') close(); if (e.key === 'ArrowLeft') show(idx - 1); if (e.key === 'ArrowRight') show(idx + 1);
  });
})();

/* Floating hearts for the "Maylyn & Arnel" section: slow, soft and gold. */
(function () {
  var cv = document.getElementById('heartsCanvas');
  if (!cv) return;
  var reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  if (reduce) return;
  var sec = cv.parentElement, ctx = cv.getContext('2d');
  var W = 0, H = 0, dpr = 1, hearts = [], visible = false, raf = 0, lastSpawn = 0;
  var small = window.matchMedia('(max-width: 760px)').matches;

  function palette() {
    return document.documentElement.getAttribute('data-theme') === 'light'
      ? [[154, 116, 48], [176, 82, 108], [107, 31, 58]]
      : [[232, 207, 150], [214, 150, 160], [201, 164, 92]];
  }

  function size() {
    dpr = Math.min(window.devicePixelRatio || 1, 2);
    W = sec.clientWidth; H = sec.clientHeight;
    cv.width = W * dpr; cv.height = H * dpr;
    ctx.setTransform(dpr, 0, 0, dpr, 0, 0);
  }

  function heartPath(s) {
    ctx.beginPath();
    ctx.moveTo(0, s * 0.35);
    ctx.bezierCurveTo(-s * 0.05, s * 0.05, -s * 0.55, -s * 0.05, -s * 0.55, -s * 0.38);
    ctx.bezierCurveTo(-s * 0.55, -s * 0.72, -s * 0.05, -s * 0.78, 0, -s * 0.42);
    ctx.bezierCurveTo(s * 0.05, -s * 0.78, s * 0.55, -s * 0.72, s * 0.55, -s * 0.38);
    ctx.bezierCurveTo(s * 0.55, -s * 0.05, s * 0.05, s * 0.05, 0, s * 0.35);
    ctx.closePath();
  }

  function make(x, y, boost) {
    var pal = palette(), c = pal[(Math.random() * pal.length) | 0];
    return {
      x: x == null ? Math.random() * W : x,
      y: y == null ? H + 30 + Math.random() * 120 : y,
      s: (small ? 9 : 11) + Math.random() * (small ? 12 : 20) * (boost ? 0.7 : 1),
      vy: 0.22 + Math.random() * 0.45 + (boost ? 0.25 : 0),
      sway: 8 + Math.random() * 22, ph: Math.random() * 6.283, sp: 0.006 + Math.random() * 0.01,
      rot: (Math.random() - 0.5) * 0.5, a: 0.18 + Math.random() * 0.4,
      fill: Math.random() < 0.55, c: c, age: 0
    };
  }

  function seed() {
    hearts = [];
    var n = small ? 10 : Math.min(26, Math.round(W / 55));
    for (var i = 0; i < n; i++) { var h = make(null, Math.random() * H); h.age = 60; hearts.push(h); }
  }

  function draw(t) {
    ctx.clearRect(0, 0, W, H);
    for (var i = hearts.length - 1; i >= 0; i--) {
      var h = hearts[i];
      h.y -= h.vy; h.age++;
      var x = h.x + Math.sin(h.ph + h.age * h.sp * 6) * h.sway;
      var fadeIn = Math.min(1, h.age / 50), fadeOut = Math.min(1, Math.max(0, h.y + 40) / 160);
      var a = h.a * fadeIn * fadeOut;
      if (h.y < -50) { hearts.splice(i, 1); continue; }
      var beat = 1 + 0.07 * Math.max(0, Math.sin(t / 420 + h.ph)) ;
      ctx.save();
      ctx.translate(x, h.y); ctx.rotate(h.rot + Math.sin(h.ph + h.age * 0.01) * 0.12); ctx.scale(beat, beat);
      var col = h.c.join(',');
      ctx.shadowColor = 'rgba(' + col + ',' + (a * 0.9) + ')'; ctx.shadowBlur = h.s * 0.9;
      heartPath(h.s);
      if (h.fill) {
        var g = ctx.createLinearGradient(0, -h.s * 0.7, 0, h.s * 0.4);
        g.addColorStop(0, 'rgba(' + col + ',' + a + ')'); g.addColorStop(1, 'rgba(' + col + ',' + (a * 0.45) + ')');
        ctx.fillStyle = g; ctx.fill();
      } else {
        ctx.lineWidth = 1.1; ctx.strokeStyle = 'rgba(' + col + ',' + Math.min(1, a * 1.5) + ')'; ctx.stroke();
      }
      ctx.restore();
    }
    while (hearts.length < (small ? 10 : Math.min(26, Math.round(W / 55)))) hearts.push(make());
  }

  function loop(t) {
    if (!visible) { raf = 0; return; }
    draw(t); raf = requestAnimationFrame(loop);
  }

  new IntersectionObserver(function (e) {
    visible = e[0].isIntersecting;
    if (visible && !raf) raf = requestAnimationFrame(loop);
  }, { rootMargin: '120px' }).observe(sec);

  /* Gentle trail of hearts that follows the pointer over the photos. */
  if (window.matchMedia('(hover: hover) and (pointer: fine)').matches) {
    sec.addEventListener('pointermove', function (e) {
      var now = performance.now();
      if (now - lastSpawn < 140 || !e.target.closest('.c-item, .partner, .vow')) return;
      lastSpawn = now;
      var r = sec.getBoundingClientRect();
      hearts.push(make(e.clientX - r.left, e.clientY - r.top, true));
    });
  }

  window.addEventListener('resize', function () { size(); });
  size(); seed();
})();

/* Cookie consent: Google Consent Mode v2 (analytics only after "Accept"), persisted for 12 months. */
(function () {
  var KEY = 'cookie-consent';
  var banner = document.getElementById('consent');
  if (!banner) return;
  var acceptBtn = document.getElementById('consentAccept');
  var declineBtn = document.getElementById('consentDecline');
  var settingsBtn = document.getElementById('cookieSettings');
  var dialog = document.getElementById('privacy');
  var closeBtn = document.getElementById('privacyClose');
  var hideTimer = 0, showTimer = 0, lastFocus = null;

  function read() {
    var v = null;
    try { v = localStorage.getItem(KEY); } catch (e) {}
    if (!v) { var m = document.cookie.match(/(?:^|; )cookie_consent=(granted|denied)/); v = m && m[1]; }
    return v === 'granted' || v === 'denied' ? v : null;
  }

  function save(v) {
    try { localStorage.setItem(KEY, v); } catch (e) {}
    document.cookie = 'cookie_consent=' + v + ';path=/;max-age=31536000;SameSite=Lax' + (location.protocol === 'https:' ? ';Secure' : '');
  }

  function updateConsent(v) {
    if (typeof window.gtag === 'function') window.gtag('consent', 'update', { analytics_storage: v });
  }

  /* When analytics is declined after being accepted, remove Google Analytics cookies. */
  function clearAnalyticsCookies() {
    var host = location.hostname, parts = host.split('.'), domains = ['', host, '.' + host];
    if (parts.length > 2) domains.push('.' + parts.slice(-2).join('.'));
    document.cookie.split(';').forEach(function (c) {
      var name = c.split('=')[0].trim();
      if (!/^_ga(_|$)/.test(name)) return;
      domains.forEach(function (d) {
        document.cookie = name + '=;expires=Thu, 01 Jan 1970 00:00:00 GMT;path=/' + (d ? ';domain=' + d : '');
      });
    });
  }

  function show() {
    clearTimeout(hideTimer); clearTimeout(showTimer);
    lastFocus = document.activeElement;
    banner.hidden = false;
    requestAnimationFrame(function () { requestAnimationFrame(function () { banner.classList.add('is-open'); }); });
  }

  function hide() {
    banner.classList.remove('is-open');
    clearTimeout(hideTimer);
    hideTimer = setTimeout(function () { banner.hidden = true; }, 600);
  }

  function choose(v) {
    save(v); updateConsent(v);
    if (v === 'denied') clearAnalyticsCookies();
    hide();
    if (lastFocus && lastFocus.focus && document.body.contains(lastFocus) && lastFocus !== document.body) {
      try { lastFocus.focus({ preventScroll: true }); } catch (e) {}
    }
  }

  acceptBtn.addEventListener('click', function () { choose('granted'); });
  declineBtn.addEventListener('click', function () { choose('denied'); });
  if (settingsBtn) settingsBtn.addEventListener('click', function () { show(); acceptBtn.focus({ preventScroll: true }); });

  /* Privacy notice (native <dialog>, with a fallback for browsers without showModal). */
  function openPrivacy() {
    if (!dialog) return;
    if (typeof dialog.showModal === 'function') { if (!dialog.open) dialog.showModal(); }
    else dialog.setAttribute('open', '');
    document.body.classList.add('menu-lock', 'native-cursor');
  }
  function closePrivacy() {
    if (!dialog) return;
    if (typeof dialog.close === 'function') dialog.close(); else dialog.removeAttribute('open');
    document.body.classList.remove('menu-lock', 'native-cursor');
  }
  [].forEach.call(document.querySelectorAll('[data-open-privacy]'), function (b) { b.addEventListener('click', openPrivacy); });
  if (dialog) {
    if (closeBtn) closeBtn.addEventListener('click', closePrivacy);
    dialog.addEventListener('close', function () { document.body.classList.remove('menu-lock', 'native-cursor'); });
    dialog.addEventListener('click', function (e) { if (e.target === dialog) closePrivacy(); });
    /* Keep Tab / Shift+Tab cycling inside the dialog instead of leaving the page. */
    dialog.addEventListener('keydown', function (e) {
      if (e.key !== 'Tab') return;
      var f = [].slice.call(dialog.querySelectorAll('button, a[href], [tabindex]:not([tabindex="-1"])'));
      if (!f.length) return;
      var first = f[0], last = f[f.length - 1], a = document.activeElement;
      if (e.shiftKey && (a === first || !dialog.contains(a))) { e.preventDefault(); last.focus(); }
      else if (!e.shiftKey && (a === last || !dialog.contains(a))) { e.preventDefault(); first.focus(); }
    });
  }

  /* First visit: show the banner shortly after the page has finished loading. */
  if (!read()) {
    var start = function () { showTimer = setTimeout(show, 1400); };
    if (document.readyState === 'complete') start(); else window.addEventListener('load', start);
  }
})();

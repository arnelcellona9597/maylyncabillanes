(function () {
  var root = document.documentElement;
  var btn = document.getElementById('themeToggle');
  function save(t) {
    try { localStorage.setItem('theme', t); } catch (e) {}
    document.cookie = 'theme=' + t + ';path=/;max-age=31536000;SameSite=Lax';
  }
  btn.addEventListener('click', function () {
    var next = root.getAttribute('data-theme') === 'dark' ? 'light' : 'dark';
    root.classList.add('theme-anim');
    root.setAttribute('data-theme', next);
    btn.setAttribute('aria-pressed', next === 'light' ? 'true' : 'false');
    var m = document.querySelector('meta[name="theme-color"]');
    if (m) m.content = next === 'light' ? '#faf6ef' : '#0d0b0e';
    save(next);
    window.dispatchEvent(new CustomEvent('themechange', { detail: next }));
  });
})();

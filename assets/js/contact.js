(function () {
  var form = document.getElementById('contactForm');
  if (!form) return;
  var status = document.getElementById('formStatus');
  var btn = form.querySelector('button[type=submit]');
  var label = btn.querySelector('.btn__label');

  function clearErrors() {
    form.querySelectorAll('.field').forEach(function (f) { f.classList.remove('has-error'); });
    form.querySelectorAll('.err').forEach(function (e) { e.textContent = ''; });
  }
  function showErrors(errs) {
    Object.keys(errs).forEach(function (k) {
      var s = form.querySelector('.err[data-for="' + k + '"]');
      if (s) { s.textContent = errs[k]; s.parentElement.classList.add('has-error'); }
    });
  }

  form.addEventListener('submit', function (e) {
    e.preventDefault();
    clearErrors(); status.className = 'form__status'; status.textContent = '';
    var errs = {};
    if (!form.name.value.trim()) errs.name = 'Please enter your name.';
    if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(form.email.value.trim())) errs.email = 'Please enter a valid email address.';
    if (form.message.value.trim().length < 10) errs.message = 'Please write at least 10 characters.';
    if (Object.keys(errs).length) { showErrors(errs); return; }

    btn.classList.add('is-loading'); label.textContent = 'Sending…';
    fetch(form.action, { method: 'POST', body: new FormData(form), headers: { Accept: 'application/json' } })
      .then(function (r) { return r.json().catch(function () { return { ok: false, message: 'Unexpected server response.' }; }); })
      .then(function (d) {
        if (d.ok) { form.reset(); status.classList.add('ok'); }
        else { status.classList.add('bad'); if (d.errors) showErrors(d.errors); }
        status.textContent = d.message;
      })
      .catch(function () { status.classList.add('bad'); status.textContent = 'Network error. Please try again.'; })
      .finally(function () { btn.classList.remove('is-loading'); label.textContent = 'Send message'; });
  });
})();

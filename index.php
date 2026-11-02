<?php
declare(strict_types=1);

session_start(['cookie_httponly' => true, 'cookie_samesite' => 'Lax']);
if (empty($_SESSION['csrf'])) {
    $_SESSION['csrf'] = bin2hex(random_bytes(32));
}
$theme = ($_COOKIE['theme'] ?? '') === 'light' ? 'light' : 'dark';
$year = date('Y');

function img(string $name, string $alt, string $class = '', string $loading = 'lazy'): string
{
    $a = htmlspecialchars($alt, ENT_QUOTES);
    return '<picture><source srcset="assets/img/' . $name . '.webp" type="image/webp">'
        . '<img src="assets/img/' . $name . '.jpg" alt="' . $a . '" class="' . $class . '" loading="' . $loading . '" decoding="async"></picture>';
}

$moments = [
    ['moment-1', 'Maylyn seated beside a gilded landscape painting'],
    ['moment-2', 'Maylyn in a sparkling top, evening out'],
    ['moment-3', 'Maylyn, candid moment'],
    ['moment-4', 'Maylyn, candid moment'],
    ['moment-5', 'Maylyn, relaxed portrait'],
    ['moment-6', 'Maylyn, relaxed portrait'],
];
?>
<!DOCTYPE html>
<html lang="en" data-theme="<?= $theme ?>">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Maylyn Cabillanes | Human Resource Management Staff</title>
<meta name="description" content="Maylyn Cabillanes — Human Resource Management Staff at the Philippine Postal Corporation, Davao City. BS Information Technology graduate and Dean's Lister.">
<meta name="theme-color" content="#0d0b0e">
<meta property="og:title" content="Maylyn Cabillanes | Human Resource Management Staff">
<meta property="og:description" content="Where people, process and technology meet.">
<meta property="og:image" content="https://maylyncabillanes.com/assets/img/portrait-3.jpg">
<link rel="icon" href="/favicon.ico" sizes="48x48">
<link rel="icon" type="image/png" sizes="32x32" href="/assets/img/favicon-32.png">
<link rel="icon" type="image/png" sizes="192x192" href="/assets/img/favicon-192.png">
<link rel="apple-touch-icon" href="/assets/img/apple-touch-icon.png">
<link rel="canonical" href="https://maylyncabillanes.com/">
<meta name="robots" content="index, follow, max-image-preview:large">
<meta name="author" content="Maylyn Cabillanes">
<meta property="og:type" content="website">
<meta property="og:site_name" content="Maylyn Cabillanes">
<meta property="og:url" content="https://maylyncabillanes.com/">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:image" content="https://maylyncabillanes.com/assets/img/portrait-3.jpg">
<script type="application/ld+json">
{"@context":"https://schema.org","@type":"Person","name":"Maylyn Cabillanes","url":"https://maylyncabillanes.com/","image":"https://maylyncabillanes.com/assets/img/portrait-3.jpg","jobTitle":"Human Resource Management Staff","worksFor":{"@type":"Organization","name":"Philippine Postal Corporation","url":"https://phlpost.gov.ph/"},"alumniOf":{"@type":"CollegeOrUniversity","name":"Agusan del Sur State College of Agriculture and Technology"},"address":{"@type":"PostalAddress","addressLocality":"Davao City","addressCountry":"PH"},"email":"mailto:info@maylyncabillanes.com","sameAs":["https://www.facebook.com/maylyn.cabillanes"]}
</script>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;1,400;1,500&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
<script>
  // Resolve saved theme before first paint (cookie already handled server-side).
  try {
    var t = localStorage.getItem('theme');
    if (t === 'light' || t === 'dark') document.documentElement.setAttribute('data-theme', t);
  } catch (e) {}
</script>
<link rel="stylesheet" href="assets/css/base.css">
<link rel="stylesheet" href="assets/css/layout.css">
<link rel="stylesheet" href="assets/css/components.css">
<link rel="stylesheet" href="assets/css/effects.css">
<link rel="stylesheet" href="assets/css/premium.css">
</head>
<body>
<a class="skip" href="#main">Skip to content</a>

<div class="progress" aria-hidden="true"><span></span></div>
<div class="overlay overlay--grain" aria-hidden="true"></div>
<div class="overlay overlay--vignette" aria-hidden="true"></div>
<div class="overlay overlay--sweep" aria-hidden="true"></div>
<div class="cursor" aria-hidden="true"><span class="cursor__dot"></span><span class="cursor__ring"></span></div>

<div class="loader" aria-hidden="true"><span class="loader__mark">M<i>C</i></span></div>

<header class="nav" id="nav">
  <a href="#top" class="nav__brand" data-magnetic>Maylyn<span> Cabillanes</span></a>
  <nav class="nav__links" id="navLinks" aria-label="Primary">
    <a href="#about">About</a>
    <a href="#experience">Experience</a>
    <a href="#education">Education</a>
    <a href="#skills">Expertise</a>
    <a href="#gallery">Gallery</a>
    <a href="#together">Together</a>
    <a href="#contact">Contact</a>
  </nav>
  <div class="nav__actions">
    <a class="icon-btn" href="https://www.facebook.com/maylyn.cabillanes" target="_blank" rel="noopener" aria-label="Maylyn Cabillanes on Facebook">
      <svg viewBox="0 0 24 24" width="19" height="19" fill="currentColor" aria-hidden="true"><path d="M13.5 21v-7.5h2.6l.4-3h-3V8.7c0-.9.3-1.5 1.5-1.5h1.6V4.5c-.3 0-1.2-.1-2.3-.1-2.3 0-3.8 1.4-3.8 3.9v2.2H7.9v3h2.6V21h3z"/></svg>
    </a>
    <button class="theme-toggle" id="themeToggle" type="button" aria-label="Toggle light and dark mode" aria-pressed="<?= $theme === 'light' ? 'true' : 'false' ?>">
      <svg class="i-sun" viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"><circle cx="12" cy="12" r="4.2"/><path d="M12 2.5v2.3M12 19.2v2.3M2.5 12h2.3M19.2 12h2.3M5.3 5.3l1.6 1.6M17.1 17.1l1.6 1.6M18.7 5.3l-1.6 1.6M6.9 17.1l-1.6 1.6"/></svg>
      <svg class="i-moon" viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M20.5 14.2A8.5 8.5 0 0 1 9.8 3.5a8.5 8.5 0 1 0 10.7 10.7z"/></svg>
    </button>
    <button class="burger" id="burger" type="button" aria-label="Open menu" aria-expanded="false" aria-controls="navLinks"><span></span><span></span></button>
  </div>
</header>

<main id="main">
<!-- HERO -->
<section class="hero" id="top">
  <canvas class="hero__canvas" id="heroCanvas" aria-hidden="true"></canvas>
  <div class="hero__glow" aria-hidden="true"></div>
  <div class="container hero__inner">
    <div class="hero__copy">
      <p class="eyebrow reveal">Human Resource Management Staff</p>
      <h1 class="hero__title" aria-label="Maylyn Cabillanes">
        <span class="line"><span class="split" data-split>Maylyn</span></span>
        <span class="line"><span class="split" data-split>Cabillanes</span></span>
      </h1>
      <p class="hero__lead reveal">Where people, process and technology meet. A Bachelor of Science in Information Technology graduate building a thoughtful career in public-service human resources.</p>
      <div class="hero__cta reveal">
        <a href="#contact" class="btn btn--gold" data-magnetic><span>Get in touch</span><svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M13 6l6 6-6 6"/></svg></a>
        <a href="#experience" class="btn btn--ghost" data-magnetic><span>View experience</span></a>
      </div>
      <ul class="hero__meta reveal">
        <li><strong>Philippine Postal Corporation</strong>Davao City</li>
        <li><strong>BS Information Technology</strong>Dean’s Lister</li>
      </ul>
    </div>
    <figure class="hero__portrait" data-tilt>
      <div class="arch" data-parallax="0.06">
        <?= img('portrait-3', 'Portrait of Maylyn Cabillanes in a black blazer', 'arch__img', 'eager') ?>
      </div>
      <span class="hero__ring" aria-hidden="true"></span>
      <figcaption class="hero__badge"><b>HR</b><span>Management<br>Staff</span></figcaption>
    </figure>
  </div>
  <a href="#about" class="scroll-cue" aria-label="Scroll to About"><span></span>Scroll</a>
</section>

<!-- MARQUEE -->
<div class="marquee" aria-hidden="true">
  <div class="marquee__track">
    <span>Human Resource Management</span><i>✦</i><span>Public Service</span><i>✦</i><span>Information Technology</span><i>✦</i><span>Recruitment &amp; Records</span><i>✦</i><span>Integrity</span><i>✦</i>
    <span>Human Resource Management</span><i>✦</i><span>Public Service</span><i>✦</i><span>Information Technology</span><i>✦</i><span>Recruitment &amp; Records</span><i>✦</i><span>Integrity</span><i>✦</i>
  </div>
</div>

<!-- ABOUT -->
<section class="section" id="about">
  <div class="container about">
    <div class="about__media reveal-img">
      <div class="frame frame--tall" data-parallax="-0.04"><?= img('portrait-4', 'Studio portrait of Maylyn Cabillanes') ?></div>
      <div class="frame frame--small" data-parallax="0.07"><?= img('moment-5', 'Maylyn smiling, relaxed portrait') ?></div>
      <span class="about__outline" aria-hidden="true"></span>
      <div class="about__stat"><b data-count="2">0</b><span>Years in<br>public service</span></div>
    </div>
    <div class="about__text">
      <p class="eyebrow reveal">About</p>
      <h2 class="h2 reveal">Technology-minded, <em>people-centered.</em></h2>
      <p class="lead reveal">I’m Maylyn, a Human Resource Management Staff member at the Philippine Postal Corporation in Davao City.</p>
      <p class="reveal">My path began in Information Technology, where I graduated from Agusan del Sur State College of Agriculture and Technology as a Dean’s Lister. It led me to a role where organized systems and genuine care for people work hand in hand.</p>
      <blockquote class="quote reveal">Good HR is quietly excellent: reliable, respectful and always on time.</blockquote>
      <ul class="facts reveal">
        <li><span>Based in</span>Davao City, Philippines</li>
        <li><span>Role</span>HR Management Staff</li>
        <li><span>Degree</span>BS Information Technology</li>
        <li><span>Training</span>CSC, TESDA &amp; PHLPost</li>
      </ul>
    </div>
  </div>
</section>

<!-- EXPERIENCE -->
<section class="section section--alt" id="experience">
  <div class="container">
    <header class="section__head">
      <p class="eyebrow reveal">Experience</p>
      <h2 class="h2 reveal">A career built on <em>service.</em></h2>
    </header>
    <div class="exp">
      <aside class="exp__media reveal-img">
        <div class="frame frame--tall" data-parallax="0.04"><?= img('portrait-1', 'Maylyn Cabillanes, full-length studio portrait') ?></div>
        <div class="exp__tag"><b>PHLPost</b><span>Davao City</span></div>
      </aside>
      <div class="exp__body">
        <ol class="timeline">
          <li class="tl reveal">
            <span class="tl__date">Dec 2024 — Present</span>
            <div class="tl__card card" data-spot>
              <span class="chip">Current role</span>
              <h3>Human Resource Management Staff</h3>
              <p class="tl__org">Philippine Postal Corporation · Davao City</p>
              <p>Supports day-to-day human resource operations of PHLPost, including personnel records, employee engagement and participation in agency learning and development programs, in service of a nationwide public institution.</p>
              <a class="link" href="https://phlpost.gov.ph/cpt-press-releases/phlpost-davao-city-opens-first-ever-drive-thru-postal-service-in-the-country/" target="_blank" rel="noopener">PHLPost Davao’s first drive-thru postal service <span aria-hidden="true">↗</span></a>
            </div>
          </li>
          <li class="tl reveal">
            <span class="tl__date">2023</span>
            <div class="tl__card card" data-spot>
              <span class="chip">Internship</span>
              <h3>Administrative Staff</h3>
              <p class="tl__org">Agusan del Sur State College of Agriculture and Technology</p>
              <p>Completed a government-service internship providing administrative support, document handling and office coordination as part of the BSIT program.</p>
            </div>
          </li>
        </ol>
        <h3 class="h3 reveal">Learning &amp; development</h3>
        <div class="trainings">
          <article class="train reveal" data-spot><span class="train__n">01</span><div><h4>Orientation on CSC Values-Driven Leadership</h4><p>Civil Service Commission / Philippine Postal Corporation</p></div><span class="chip">Managerial · 4 hrs</span></article>
          <article class="train reveal" data-spot><span class="train__n">02</span><div><h4>Earthquake Preparedness Lecture and Drill</h4><p>Philippine Postal Corporation · 2025</p></div><span class="chip">Technical · 4 hrs</span></article>
          <article class="train reveal" data-spot><span class="train__n">03</span><div><h4>Food Processing NC II</h4><p>Technical Education and Skills Development Authority (TESDA)</p></div><span class="chip">Technical · 16 hrs</span></article>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- EDUCATION -->
<section class="section" id="education">
  <div class="container edu">
    <div class="edu__media reveal-img"><div class="frame frame--tall" data-parallax="0.05"><?= img('portrait-2', 'Full-length studio portrait of Maylyn Cabillanes') ?></div><span class="about__outline about__outline--r" aria-hidden="true"></span></div>
    <div class="edu__text">
      <p class="eyebrow reveal">Education</p>
      <h2 class="h2 reveal">Foundations of <em>excellence.</em></h2>
      <ul class="edu__list">
        <li class="reveal"><b class="yr">2024</b><div><span>2019 — 2024</span><h3>Bachelor of Science in Information Technology</h3><p>Agusan del Sur State College of Agriculture and Technology · Dean’s Lister</p></div></li>
        <li class="reveal"><b class="yr">2019</b><div><span>2018 — 2019</span><h3>Senior High School</h3><p>Informatic Computer Institute of Agusan del Sur · With Honors</p></div></li>
        <li class="reveal"><b class="yr">2013</b><div><span>2008 — 2013</span><h3>Elementary</h3><p>Consuelo Elementary School · With Honors</p></div></li>
      </ul>
    </div>
  </div>
</section>

<!-- SKILLS -->
<section class="section section--alt" id="skills">
  <div class="container skills-lay">
    <div class="skills-lay__media reveal-img">
      <div class="frame frame--tall" data-parallax="-0.04"><?= img('moment-6', 'Maylyn at an elegant venue beneath chandeliers') ?></div>
      <span class="about__outline" aria-hidden="true"></span>
    </div>
    <div>
      <header class="section__head">
        <p class="eyebrow reveal">Expertise</p>
        <h2 class="h2 reveal">Human skills, <em>technical edge.</em></h2>
      </header>
      <div class="skills">
        <article class="skill reveal" data-spot><span class="skill__n">01</span><div><h3>HR Operations</h3><p>Personnel records, documentation, onboarding support and Civil Service compliance.</p></div></article>
        <article class="skill reveal" data-spot><span class="skill__n">02</span><div><h3>Administrative Excellence</h3><p>Organized filing, scheduling, correspondence and accurate reporting.</p></div></article>
        <article class="skill reveal" data-spot><span class="skill__n">03</span><div><h3>Information Technology</h3><p>Digital fluency, productivity tools and systems thinking from a BSIT foundation.</p></div></article>
        <article class="skill reveal" data-spot><span class="skill__n">04</span><div><h3>Communication</h3><p>Clear, courteous and professional engagement with colleagues and the public.</p></div></article>
        <article class="skill reveal" data-spot><span class="skill__n">05</span><div><h3>Learning &amp; Development</h3><p>Active participant in leadership values, safety and technical skills programs.</p></div></article>
        <article class="skill reveal" data-spot><span class="skill__n">06</span><div><h3>Integrity &amp; Service</h3><p>Grounded in public-service values: honesty, accountability and respect.</p></div></article>
      </div>
    </div>
  </div>
</section>

<!-- GALLERY -->
<section class="section gallery" id="gallery">
  <div class="container">
    <header class="section__head">
      <p class="eyebrow reveal">Gallery</p>
      <h2 class="h2 reveal">Moments &amp; portraits.</h2>
    </header>
  </div>
  <div class="gallery__rail" id="rail">
    <button type="button" class="g-item" data-full="portrait-1" data-alt="Full-length studio portrait of Maylyn Cabillanes"><?= img('portrait-1', 'Full-length studio portrait of Maylyn Cabillanes') ?></button>
    <?php foreach ($moments as [$n, $alt]): ?>
    <button type="button" class="g-item" data-full="<?= $n ?>" data-alt="<?= htmlspecialchars($alt, ENT_QUOTES) ?>"><?= img($n, $alt) ?></button>
    <?php endforeach; ?>
    <button type="button" class="g-item" data-full="portrait-4" data-alt="Studio portrait of Maylyn Cabillanes"><?= img('portrait-4', 'Studio portrait of Maylyn Cabillanes') ?></button>
  </div>
</section>

<!-- TOGETHER -->
<section class="section together" id="together">
  <div class="container">
    <header class="section__head">
      <p class="eyebrow reveal">Together</p>
      <h2 class="h2 reveal">Maylyn &amp; Arnel.</h2>
      <p class="reveal together__lead">A studio photoshoot celebrating partnership, support and the people who make the work worthwhile.</p>
    </header>
    <div class="together__grid">
      <?php foreach ([1, 2, 3, 4] as $n): ?>
      <button type="button" class="c-item reveal-img" data-full="couple-<?= $n ?>" data-alt="Maylyn and Arnel, studio couple portrait <?= $n ?>" style="--d:<?= ($n - 1) * .12 ?>s"><?= img('couple-' . $n, 'Maylyn and Arnel, studio couple portrait ' . $n) ?><span class="c-item__zoom" aria-hidden="true">+</span></button>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- CONTACT -->
<section class="section section--alt" id="contact">
  <div class="container">
    <header class="section__head section__head--center">
      <p class="eyebrow eyebrow--center reveal">Contact</p>
      <h2 class="h2 reveal">Let’s start a <em>conversation.</em></h2>
      <p class="reveal together__lead">For inquiries, collaborations or professional connections, send a message and I’ll respond promptly.</p>
    </header>
    <div class="cform reveal">
      <aside class="cform__side">
        <?= img('moment-3', 'Maylyn smiling, close portrait', 'cform__img') ?>
        <div class="cform__veil"></div>
        <div class="cform__info">
          <h3>Maylyn Cabillanes</h3>
          <p>Human Resource Management Staff<br>Philippine Postal Corporation</p>
          <ul>
            <li><span>Email</span><a class="link" href="mailto:info@maylyncabillanes.com">info@maylyncabillanes.com</a></li>
            <li><span>Email</span><a class="link" href="mailto:maylyncabillanes3@gmail.com">maylyncabillanes3@gmail.com</a></li>
            <li><span>Location</span>Davao City, Philippines</li>
          </ul>
          <a class="social" href="https://www.facebook.com/maylyn.cabillanes" target="_blank" rel="noopener"><svg viewBox="0 0 24 24" width="18" height="18" fill="currentColor" aria-hidden="true"><path d="M13.5 21v-7.5h2.6l.4-3h-3V8.7c0-.9.3-1.5 1.5-1.5h1.6V4.5c-.3 0-1.2-.1-2.3-.1-2.3 0-3.8 1.4-3.8 3.9v2.2H7.9v3h2.6V21h3z"/></svg>Connect on Facebook</a>
        </div>
      </aside>
      <form class="form" id="contactForm" method="post" action="api/contact.php" novalidate>
        <input type="hidden" name="csrf" value="<?= htmlspecialchars($_SESSION['csrf']) ?>">
        <div class="hp" aria-hidden="true"><label>Website<input type="text" name="website" tabindex="-1" autocomplete="off"></label></div>
        <h3 class="form__title">Send a message</h3>
        <fieldset class="topics">
          <legend>I’m reaching out about</legend>
          <label class="topic"><input type="radio" name="subject" value="Professional inquiry" checked><span>Professional inquiry</span></label>
          <label class="topic"><input type="radio" name="subject" value="Collaboration"><span>Collaboration</span></label>
          <label class="topic"><input type="radio" name="subject" value="General question"><span>General question</span></label>
        </fieldset>
        <div class="form__row">
          <div class="field"><input id="f-name" name="name" type="text" placeholder=" " required maxlength="100" autocomplete="name"><label for="f-name">Your name</label><small class="err" data-for="name"></small></div>
          <div class="field"><input id="f-email" name="email" type="email" placeholder=" " required maxlength="160" autocomplete="email"><label for="f-email">Email address</label><small class="err" data-for="email"></small></div>
        </div>
        <div class="field"><textarea id="f-message" name="message" rows="5" placeholder=" " required maxlength="5000"></textarea><label for="f-message">Your message</label><small class="err" data-for="message"></small></div>
        <button class="btn btn--gold btn--block" type="submit" data-magnetic><span class="btn__label">Send message</span><span class="btn__spin" aria-hidden="true"></span></button>
        <p class="form__status" id="formStatus" role="status" aria-live="polite"></p>
        <p class="form__note">Your details are only used to reply to your message.</p>
      </form>
    </div>
  </div>
</section>
</main>

<footer class="footer">
  <div class="container footer__inner">
    <span class="footer__brand">Maylyn Cabillanes</span>
    <span>© <?= $year ?> All rights reserved.</span>
    <a href="#top" class="link" data-magnetic>Back to top ↑</a>
  </div>
</footer>

<div class="lightbox" id="lightbox" role="dialog" aria-modal="true" aria-label="Image viewer" hidden>
  <button type="button" class="lightbox__close" aria-label="Close">×</button>
  <button type="button" class="lightbox__nav lightbox__prev" aria-label="Previous image">‹</button>
  <img alt="" id="lightboxImg">
  <button type="button" class="lightbox__nav lightbox__next" aria-label="Next image">›</button>
</div>

<script src="assets/js/theme.js"></script>
<script src="assets/js/scroll.js"></script>
<script src="assets/js/effects.js"></script>
<script src="assets/js/contact.js"></script>
<script src="assets/js/main.js"></script>
</body>
</html>

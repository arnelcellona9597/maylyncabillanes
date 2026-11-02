<?php
declare(strict_types=1);

session_start(['cookie_httponly' => true, 'cookie_samesite' => 'Lax']);
if (empty($_SESSION['csrf'])) {
    $_SESSION['csrf'] = bin2hex(random_bytes(32));
}
$theme = ($_COOKIE['theme'] ?? '') === 'light' ? 'light' : 'dark';
$year = date('Y');
$site = 'https://maylyncabillanes.com';
$ogImage = $site . '/assets/img/og-image.jpg?v=1';
$modified = date('c', filemtime(__FILE__));
$schema = [
    '@context' => 'https://schema.org',
    '@graph' => [
        [
            '@type' => 'WebSite',
            '@id' => "$site/#website",
            'url' => "$site/",
            'name' => 'Maylyn Cabillanes',
            'description' => 'Professional portfolio of Maylyn Cabillanes, Human Resource Management Staff in Davao City.',
            'inLanguage' => 'en-PH',
            'publisher' => ['@id' => "$site/#person"],
        ],
        [
            '@type' => 'ProfilePage',
            '@id' => "$site/#webpage",
            'url' => "$site/",
            'name' => 'Maylyn Cabillanes | Human Resource Management Staff',
            'isPartOf' => ['@id' => "$site/#website"],
            'about' => ['@id' => "$site/#person"],
            'mainEntity' => ['@id' => "$site/#person"],
            'primaryImageOfPage' => ['@id' => "$site/#primaryimage"],
            'inLanguage' => 'en-PH',
            'dateModified' => $modified,
        ],
        [
            '@type' => 'ImageObject',
            '@id' => "$site/#primaryimage",
            'url' => "$site/assets/img/og-image.jpg",
            'contentUrl' => "$site/assets/img/og-image.jpg",
            'width' => 1200,
            'height' => 630,
            'caption' => 'Maylyn Cabillanes, Human Resource Management Staff',
        ],
        [
            '@type' => 'Person',
            '@id' => "$site/#person",
            'name' => 'Maylyn Cabillanes',
            'givenName' => 'Maylyn',
            'familyName' => 'Cabillanes',
            'url' => "$site/",
            'image' => [
                '@type' => 'ImageObject',
                'url' => "$site/assets/img/portrait-3.jpg",
                'width' => 1024,
                'height' => 1024,
            ],
            'jobTitle' => 'Human Resource Management Staff',
            'description' => "Human Resource Management Staff at the Philippine Postal Corporation and BS Information Technology graduate (Dean's Lister).",
            'email' => 'mailto:info@maylyncabillanes.com',
            'worksFor' => [
                '@type' => 'GovernmentOrganization',
                'name' => 'Philippine Postal Corporation',
                'alternateName' => 'PHLPost',
                'url' => 'https://phlpost.gov.ph/',
            ],
            'hasOccupation' => [
                '@type' => 'Occupation',
                'name' => 'Human Resource Management Staff',
                'occupationLocation' => ['@type' => 'City', 'name' => 'Davao City'],
            ],
            'alumniOf' => [
                '@type' => 'CollegeOrUniversity',
                'name' => 'Agusan del Sur State College of Agriculture and Technology',
            ],
            'hasCredential' => [
                ['@type' => 'EducationalOccupationalCredential', 'name' => 'Bachelor of Science in Information Technology', 'credentialCategory' => 'degree'],
                ['@type' => 'EducationalOccupationalCredential', 'name' => 'Food Processing NC II', 'credentialCategory' => 'certificate', 'recognizedBy' => ['@type' => 'GovernmentOrganization', 'name' => 'TESDA']],
            ],
            'award' => ["Dean's Lister, BS Information Technology", 'Food Processing certificate, TESDA (September 2022)'],
            'knowsAbout' => ['Human resource management', 'Records management', 'Public service', 'Information technology', 'ICT network maintenance', 'Computer system servicing', 'Learning and development'],
            'homeLocation' => ['@type' => 'Place', 'address' => ['@type' => 'PostalAddress', 'addressLocality' => 'Davao City', 'addressCountry' => 'PH']],
            'contactPoint' => [
                '@type' => 'ContactPoint',
                'contactType' => 'professional inquiries',
                'email' => 'info@maylyncabillanes.com',
                'availableLanguage' => ['English', 'Filipino'],
            ],
            'sameAs' => ['https://www.facebook.com/maylyn.cabillanes'],
        ],
    ],
];

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
<title>Maylyn Cabillanes | Human Resource Management Staff, Davao City</title>
<meta name="description" content="Maylyn Cabillanes is a Human Resource Management Staff member at the Philippine Postal Corporation in Davao City, and a BS Information Technology graduate and Dean's Lister.">
<meta name="keywords" content="Maylyn Cabillanes, Human Resource Management Staff, HR, Philippine Postal Corporation, PHLPost, Davao City, BS Information Technology">
<meta name="author" content="Maylyn Cabillanes">
<meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1">
<meta name="theme-color" content="#0d0b0e">
<link rel="canonical" href="<?= $site ?>/">
<link rel="alternate" hreflang="en" href="<?= $site ?>/">
<link rel="manifest" href="/site.webmanifest">
<link rel="icon" href="/favicon.ico" sizes="48x48">
<link rel="icon" type="image/png" sizes="32x32" href="/assets/img/favicon-32.png">
<link rel="icon" type="image/png" sizes="192x192" href="/assets/img/favicon-192.png">
<link rel="apple-touch-icon" href="/assets/img/apple-touch-icon.png">

<!-- Open Graph (Facebook, LinkedIn, WhatsApp, Messenger, Telegram, Viber) -->
<meta property="og:type" content="profile">
<meta property="og:site_name" content="Maylyn Cabillanes">
<meta property="og:locale" content="en_PH">
<meta property="og:url" content="<?= $site ?>/">
<meta property="og:title" content="Maylyn Cabillanes | Human Resource Management Staff">
<meta property="og:description" content="Human Resource Management Staff at the Philippine Postal Corporation, Davao City. Where people, process and technology meet.">
<meta property="og:image" content="<?= $ogImage ?>">
<meta property="og:image:secure_url" content="<?= $ogImage ?>">
<meta property="og:image:type" content="image/jpeg">
<meta property="og:image:width" content="1200">
<meta property="og:image:height" content="630">
<meta property="og:image:alt" content="Maylyn Cabillanes, Human Resource Management Staff, Davao City">
<meta property="profile:first_name" content="Maylyn">
<meta property="profile:last_name" content="Cabillanes">

<!-- Twitter / X -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="Maylyn Cabillanes | Human Resource Management Staff">
<meta name="twitter:description" content="Human Resource Management Staff at the Philippine Postal Corporation, Davao City.">
<meta name="twitter:image" content="<?= $ogImage ?>">
<meta name="twitter:image:alt" content="Maylyn Cabillanes, Human Resource Management Staff, Davao City">

<script type="application/ld+json"><?= json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG) ?></script>
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
          <li class="tl reveal">
            <span class="tl__date">2018 — 2019</span>
            <div class="tl__card card" data-spot>
              <span class="chip">Work immersion · 80 hrs</span>
              <h3>Work Immersion, ICT Network &amp; Maintenance</h3>
              <p class="tl__org">Provincial Information Management Office, ICT Network &amp; Maintenance Division · Provincial Government</p>
              <p>Completed 80 hours in ICT network maintenance, troubleshooting and IT support, ensuring efficient system operations and network connectivity.</p>
              <ul class="tags" aria-label="Skills"><li>OSHA 10-Hour</li><li>Laptops</li></ul>
            </div>
          </li>
        </ol>
        <h3 class="h3 reveal">Learning &amp; development</h3>
        <div class="trainings">
          <article class="train reveal" data-spot><span class="train__n">01</span><div><h4>Orientation on CSC Values-Driven Leadership</h4><p>Civil Service Commission / Philippine Postal Corporation</p></div><span class="chip">Managerial · 4 hrs</span></article>
          <article class="train reveal" data-spot><span class="train__n">02</span><div><h4>Earthquake Preparedness Lecture and Drill</h4><p>Philippine Postal Corporation · 2025</p></div><span class="chip">Technical · 4 hrs</span></article>
          <article class="train reveal" data-spot><span class="train__n">03</span><div><h4>Food Processing NC II</h4><p>Technical Education and Skills Development Authority (TESDA) · Sep 2022</p></div><span class="chip">Technical · 16 hrs</span></article>
        </div>
        <h3 class="h3 reveal">Honors &amp; awards</h3>
        <div class="awards">
          <article class="award reveal" data-spot>
            <span class="award__icon" aria-hidden="true"><svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="9" r="5.5"/><path d="m8.5 13.5-1.5 7 5-2.5 5 2.5-1.5-7"/></svg></span>
            <div>
              <span class="chip">Certificate · Sep 2022</span>
              <h4>Food Processing</h4>
              <p class="award__org">Issued by TESDA · Associated with TESDA</p>
              <p>I completed a certificate in Food Processing focused on Tocino and Longganisa production. The program gave me hands-on experience in meat preservation, seasoning and food safety standards, and I’m passionate about preserving culinary traditions.</p>
            </div>
          </article>
          <article class="award reveal" data-spot>
            <span class="award__icon" aria-hidden="true"><svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="9" r="5.5"/><path d="m8.5 13.5-1.5 7 5-2.5 5 2.5-1.5-7"/></svg></span>
            <div><span class="chip">2019 — 2024</span><h4>Dean’s Lister</h4><p class="award__org">Agusan del Sur State College of Agriculture and Technology</p></div>
          </article>
          <article class="award reveal" data-spot>
            <span class="award__icon" aria-hidden="true"><svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="9" r="5.5"/><path d="m8.5 13.5-1.5 7 5-2.5 5 2.5-1.5-7"/></svg></span>
            <div><span class="chip">2019</span><h4>With Honors, Senior High School</h4><p class="award__org">Informatic Computer Institute</p></div>
          </article>
          <article class="award reveal" data-spot>
            <span class="award__icon" aria-hidden="true"><svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="9" r="5.5"/><path d="m8.5 13.5-1.5 7 5-2.5 5 2.5-1.5-7"/></svg></span>
            <div><span class="chip">2013</span><h4>With Honors, Elementary</h4><p class="award__org">Consuelo Elementary School</p></div>
          </article>
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
        <li class="reveal"><b class="yr">2024</b><div><span>Aug 2019 — Jun 2024</span><h3>Bachelor of Science in Information Technology</h3><p>Agusan del Sur State College of Agriculture and Technology · Dean’s Lister</p><ul class="tags" aria-label="Skills"><li>Communication skills</li><li>Technical proficiency</li></ul></div></li>
        <li class="reveal"><b class="yr">2022</b><div><span>Sep 2022</span><h3>Vocational · Food Technology and Processing</h3><p>TESDA — Technical Education and Skills Development Authority</p></div></li>
        <li class="reveal"><b class="yr">2019</b><div><span>2018 — 2019</span><h3>Senior High School · TVL-ICT, Computer System Servicing</h3><p>Informatic Computer Institute of Agusan del Sur · With Honors</p><p class="edu__note">Completed 486 hours as an administrative assistant managing paper works and data encoding, honing organizational skills and attention to detail.</p><ul class="tags" aria-label="Skills"><li>OSHA 10-Hour</li><li>Laptops</li></ul></div></li>
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
  <div class="slider" id="gallerySlider" role="region" aria-roledescription="carousel" aria-label="Photo gallery">
    <div class="slider__stage">
    <button type="button" class="slider__arrow slider__arrow--prev" id="galPrev" aria-label="Previous photos"><svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M15 5l-7 7 7 7"/></svg></button>
    <button type="button" class="slider__arrow slider__arrow--next" id="galNext" aria-label="Next photos"><svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M9 5l7 7-7 7"/></svg></button>
    <div class="gallery__viewport" id="galleryViewport">
      <div class="gallery__rail" id="rail" aria-live="off">
        <button type="button" class="g-item" data-full="portrait-1" data-alt="Full-length studio portrait of Maylyn Cabillanes"><?= img('portrait-1', 'Full-length studio portrait of Maylyn Cabillanes') ?></button>
        <?php foreach ($moments as [$n, $alt]): ?>
        <button type="button" class="g-item" data-full="<?= $n ?>" data-alt="<?= htmlspecialchars($alt, ENT_QUOTES) ?>"><?= img($n, $alt) ?></button>
        <?php endforeach; ?>
        <button type="button" class="g-item" data-full="portrait-4" data-alt="Studio portrait of Maylyn Cabillanes"><?= img('portrait-4', 'Studio portrait of Maylyn Cabillanes') ?></button>
      </div>
    </div>
    </div>
    <div class="slider__bar">
      <span class="slider__count" aria-hidden="true"><b id="galCur">01</b><i></i><span id="galTotal">06</span></span>
      <div class="slider__dots" id="galDots" role="tablist" aria-label="Choose slide"></div>
      <button type="button" class="slider__play" id="galPlay" aria-label="Pause autoplay" aria-pressed="true">
        <svg class="i-pause" viewBox="0 0 24 24" width="16" height="16" fill="currentColor" aria-hidden="true"><rect x="6" y="5" width="4" height="14" rx="1"/><rect x="14" y="5" width="4" height="14" rx="1"/></svg>
        <svg class="i-play" viewBox="0 0 24 24" width="16" height="16" fill="currentColor" aria-hidden="true"><path d="M8 5.5v13l11-6.5z"/></svg>
        <span class="slider__play-label">Pause</span>
      </button>
    </div>
  </div>
</section>

<!-- TOGETHER -->
<section class="section together" id="together">
  <canvas class="hearts" id="heartsCanvas" aria-hidden="true"></canvas>
  <div class="container together__inner">
    <header class="section__head">
      <p class="eyebrow reveal">Together</p>
      <h2 class="h2 reveal">Maylyn <span class="amp" aria-label="and">&amp;</span> Arnel.</h2>
      <p class="reveal together__lead">A studio photoshoot of girlfriend and boyfriend: two people who laugh, grow and dream together, and who make every day worth coming home to.</p>
    </header>
    <div class="vow reveal" aria-hidden="true">
      <span class="vow__line"></span>
      <svg class="vow__rings" viewBox="0 0 120 56" width="120" height="56" fill="none" stroke="currentColor" stroke-width="1.4">
        <circle class="ring ring--a" cx="44" cy="30" r="20"/>
        <circle class="ring ring--b" cx="76" cy="30" r="20"/>
        <path class="vow__heart" d="M60 14.5c-2.6-4.6-9.2-3.4-9.2 1.8 0 3.7 4.4 6.6 9.2 10.8 4.8-4.2 9.2-7.1 9.2-10.8 0-5.2-6.6-6.4-9.2-1.8z" fill="currentColor" stroke="none"/>
      </svg>
      <span class="vow__line"></span>
    </div>
    <div class="together__grid">
      <?php foreach ([1, 2, 3, 4] as $n): ?>
      <button type="button" class="c-item reveal-img" data-full="couple-<?= $n ?>" data-alt="Maylyn and her boyfriend Arnel, studio couple portrait <?= $n ?>" style="--d:<?= ($n - 1) * .12 ?>s"><?= img('couple-' . $n, 'Maylyn and her boyfriend Arnel, studio couple portrait ' . $n) ?><span class="c-item__zoom" aria-hidden="true">+</span></button>
      <?php endforeach; ?>
    </div>
    <div class="together__link reveal">
      <span>Her boyfriend’s website</span>
      <a class="partner" href="https://www.arnelcellona.com" target="_blank" rel="noopener" title="Arnel Cellona — arnelcellona.com">
        <b>Arnel Cellona</b><i>www.arnelcellona.com</i>
        <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M7 17 17 7M8 7h9v9"/></svg>
      </a>
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
  <div class="footer__mark" aria-hidden="true">Maylyn Cabillanes</div>
  <div class="container">
    <div class="footer__top">
      <div class="footer__about">
        <a href="#top" class="footer__brand" data-magnetic>Maylyn<span> Cabillanes</span></a>
        <p>Human Resource Management Staff at the Philippine Postal Corporation, Davao City. Where people, process and technology meet.</p>
        <a class="icon-btn" href="https://www.facebook.com/maylyn.cabillanes" target="_blank" rel="noopener" aria-label="Maylyn Cabillanes on Facebook"><svg viewBox="0 0 24 24" width="19" height="19" fill="currentColor" aria-hidden="true"><path d="M13.5 21v-7.5h2.6l.4-3h-3V8.7c0-.9.3-1.5 1.5-1.5h1.6V4.5c-.3 0-1.2-.1-2.3-.1-2.3 0-3.8 1.4-3.8 3.9v2.2H7.9v3h2.6V21h3z"/></svg></a>
      </div>
      <nav class="footer__col" aria-label="Footer">
        <h4>Explore</h4>
        <a href="#about">About</a><a href="#experience">Experience</a><a href="#education">Education</a><a href="#skills">Expertise</a><a href="#gallery">Gallery</a><a href="#together">Together</a>
      </nav>
      <div class="footer__col">
        <h4>Contact</h4>
        <a href="mailto:info@maylyncabillanes.com">info@maylyncabillanes.com</a>
        <a href="mailto:maylyncabillanes3@gmail.com">maylyncabillanes3@gmail.com</a>
        <span>Davao City, Philippines</span>
        <a href="#contact" class="footer__cta">Send a message <span aria-hidden="true">→</span></a>
      </div>
    </div>
    <div class="footer__bottom">
      <span>© <?= $year ?> Maylyn Cabillanes. All rights reserved.</span>
      <a href="#top" class="totop" aria-label="Back to top" data-magnetic><svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M12 19V5M6 11l6-6 6 6"/></svg></a>
    </div>
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
<script src="assets/js/hearts.js"></script>
<script src="assets/js/gallery.js"></script>
<script src="assets/js/contact.js"></script>
<script src="assets/js/main.js"></script>
</body>
</html>

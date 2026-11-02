// Classic script (loaded after the shader runtime and effect scripts) so the page also works
// when opened directly from file://.
(() => {

const DESIGN_WIDTH = 1920

// Layout modes (match the media queries in css/styles.css):
//   desktop (>= 1200px): the 1920px design frame is scaled to the viewport width (--page-zoom);
//   fluid (< 1200px): the page reflows at real size, the pinned scroll scenes are off, and the
//   art-directed blocks (hero artwork, banners, pattern, saree carousel) are scaled on their own
//   with the factors below.
const fluidQuery = window.matchMedia('(max-width: 1199.98px)')
const isFluid = fluidQuery.matches

function fitPage() {
  const root = document.documentElement
  const width = root.clientWidth
  // Breakpoints via matchMedia, which (like the CSS) counts the scrollbar; clientWidth doesn't.
  const gutter = window.matchMedia('(max-width: 575.98px)').matches ? 16 : 24
  const scale = width / DESIGN_WIDTH
  root.style.setProperty('--page-zoom', String(isFluid ? 1 : scale))
  root.style.setProperty('--scale', String(scale)) // 1920px frame -> full width
  root.style.setProperty('--banner-zoom', String(width / 1580)) // 1580px banners -> full width
  root.style.setProperty('--inset-zoom', String((width - 2 * gutter) / 1580)) // 1580px block inside the gutters
  // Saree carousel below 768px: zoomed so the centre card is ~62% of the screen, and shifted so
  // it is centred (the side cards run off the edges). Values in the carousel's own design px.
  const carouselZoom = (width * 0.62) / 522
  root.style.setProperty('--carousel-zoom', String(carouselZoom))
  root.style.setProperty('--carousel-half', String(width / 2 / carouselZoom))
  // Hero (>= 992px, where it is the scaled 1920x1080 composition): at least as tall as the
  // screen, in design px; the artwork is shifted down by the extra so the model stays on the
  // bottom edge. Below 992px the hero is a CSS full-screen layout instead.
  const heroHeight = window.matchMedia('(min-width: 992px)').matches ? Math.max(1080, window.innerHeight / scale) : 1080
  root.style.setProperty('--hero-h', `${heroHeight}px`)
  root.style.setProperty('--hero-shift', `${heroHeight - 1080}px`)
  // Screen height in design px (the pinned bride banner's backdrop fills the screen).
  root.style.setProperty('--screen-h', `${window.innerHeight / (isFluid ? 1 : scale)}px`)
}
fitPage()
window.addEventListener('resize', fitPage)
// The scroll scenes are set up for one mode at load; crossing the breakpoint reloads into the other.
fluidQuery.addEventListener('change', () => window.location.reload())

// Menu button (fluid mode): opens the menu full screen (page scroll locked while open); closes
// on a link, Esc or the button.
const siteHeader = document.querySelector('.site-header')
const navToggle = document.querySelector('.nav-toggle')
if (siteHeader && navToggle) {
  const setMenu = (open) => {
    siteHeader.classList.toggle('is-menu-open', open)
    document.documentElement.classList.toggle('menu-locked', open)
    navToggle.setAttribute('aria-expanded', String(open))
    navToggle.setAttribute('aria-label', open ? 'Close menu' : 'Menu')
  }
  navToggle.addEventListener('click', () => setMenu(!siteHeader.classList.contains('is-menu-open')))
  siteHeader.querySelectorAll('.site-menu a').forEach((a) => a.addEventListener('click', () => setMenu(false)))
  document.addEventListener('keydown', (e) => { if (e.key === 'Escape') setMenu(false) })
}

// Hero scroll scene + parallax.
// 1. Pinned phase (first --pin-distance of scroll): the hero sticks while the model zooms in and
//    the copy splits apart — left-hand words slide out left, right-hand words out right.
// 2. Reveal phase (--curtain-distance): still zooming in and blurring, the hero is covered by the
//    next section, held at the top of the screen and shown through a 2px slit drawn top to
//    bottom, which then opens to full width. Its heading floats in as it opens. At the end the
//    section sits exactly in its normal place, so the page simply scrolls on.
// Throughout, layers drift with the pointer by depth (mouse parallax).
//   mouse = max px drift at the hero's edge   split = -1 left / +1 right   fade = fades out while splitting
//   zoom / blur = extra scale / blur (px) reached at the end of the pin phase
//   coverZoom / coverBlur = further scale / blur added during the curtain phase
function initHeroScene(pin, hero) {
  const SPLIT_DISTANCE = 1100
  const layers = [
    { selector: '.hero__bg', mouse: 10, base: 1.02, zoom: 0.12, blur: 2, coverZoom: 0.06, coverBlur: 6 },
    { selector: '.hero__warp', mouse: 22, zoom: 0.4, blur: 3, coverZoom: 0.2, coverBlur: 8 },
    { selector: '.hero__text--a', mouse: 18, split: -1, fade: true },
    { selector: '.hero__text--thousand', mouse: 18, fade: true },
    { selector: '.hero__word[data-split="left"]', split: -1 },
    { selector: '.hero__word[data-split="right"]', split: 1 },
    { selector: '.hero__model', mouse: 30, zoom: 0.75, blur: 4, coverZoom: 0.35, coverBlur: 12 },
    { selector: '.hero__text--color', mouse: 44, split: -1, fade: true },
    { selector: '.hero__text--pure', mouse: 44, split: 1, fade: true },
    { selector: '.hero__text--cotton', mouse: 52, split: -1, fade: true },
    { selector: '.hero__text--breathes', mouse: 52, split: -1, fade: true },
    { selector: '.hero__text--elegance', mouse: 52, split: -1, fade: true },
    { selector: '.hero__text--stays', mouse: 52, split: -1, fade: true },
  ]
  pin.classList.add('is-active')
  const pinDistance = parseFloat(getComputedStyle(pin).getPropertyValue('--pin-distance')) || 0
  const coverDistance = parseFloat(getComputedStyle(pin).getPropertyValue('--curtain-distance')) || 0
  const nextSection = pin.nextElementSibling.querySelector('section')
  const sceneReveals = [...nextSection.querySelectorAll('[data-reveal="scene"]')]
  const SLIT_HALF = 1 // the reveal starts as a 2px-wide slit
  const ease = (t) => t * t * (3 - 2 * t)
  const clamp01 = (t) => Math.min(Math.max(t, 0), 1)
  const target = { x: 0, y: 0 }
  const current = { x: 0, y: 0 }
  let running = false

  if (window.matchMedia('(hover: hover) and (pointer: fine)').matches) {
    hero.addEventListener('pointermove', (e) => {
      const r = hero.getBoundingClientRect()
      target.x = ((e.clientX - r.left) / r.width) * 2 - 1
      target.y = ((e.clientY - r.top) / r.height) * 2 - 1
      start()
    })
    hero.addEventListener('pointerleave', () => {
      target.x = 0
      target.y = 0
      start()
    })
  }
  // The next section's heading and cards animate in once its reveal has opened to full width, so
  // the cards don't slide in behind the still-closed sides of the slit. Checked synchronously on
  // every scroll (not only in the animation loop) so fast scrolls and jumps can't skip it.
  // The cards (not the heading) slide back out when you scroll back up into the curtain (a little
  // earlier than they came in, so they don't flicker at the line).
  const REVEAL_AT = 0.9 // share of the curtain phase
  const HIDE_AT = 0.89
  function revealNextHead() {
    const zoom = parseFloat(getComputedStyle(document.documentElement).getPropertyValue('--page-zoom')) || 1
    const cover = (-pin.getBoundingClientRect().top / zoom - pinDistance) / coverDistance
    if (cover > REVEAL_AT) sceneReveals.forEach((el) => el.classList.add('is-inview'))
    else if (cover < HIDE_AT) sceneReveals.forEach((el) => { if (el.matches('.wedding__grid')) el.classList.remove('is-inview') })
  }
  window.addEventListener('scroll', () => { revealNextHead(); start() }, { passive: true })
  revealNextHead()

  function frame() {
    current.x += (target.x - current.x) * 0.08
    current.y += (target.y - current.y) * 0.08
    // Page coordinates are scaled by --page-zoom; convert scroll back to design pixels.
    const zoom = parseFloat(getComputedStyle(document.documentElement).getPropertyValue('--page-zoom')) || 1
    const scrolled = Math.max(0, -pin.getBoundingClientRect().top / zoom)
    const progress = ease(Math.min(scrolled / pinDistance, 1))
    const cover = Math.min(Math.max((scrolled - pinDistance) / coverDistance, 0), 1)
    const opacity = 1 - Math.min(Math.max((progress - 0.15) / 0.6, 0), 1)
    for (const layer of layers) {
      // Query each frame: the warp layer is swapped for a <canvas> once the live shader loads.
      const el = hero.querySelector(layer.selector)
      if (!el) continue
      const x = -current.x * (layer.mouse ?? 0) + (layer.split ?? 0) * progress * SPLIT_DISTANCE
      const y = -current.y * (layer.mouse ?? 0)
      const scale = (layer.base ?? 1) + (layer.zoom ?? 0) * progress + (layer.coverZoom ?? 0) * cover
      el.style.transform = `translate3d(${x.toFixed(2)}px, ${y.toFixed(2)}px, 0)` + (scale !== 1 ? ` scale(${scale.toFixed(4)})` : '')
      if (layer.fade) el.style.opacity = opacity.toFixed(3)
      if (layer.blur) {
        const blur = layer.blur * progress + (layer.coverBlur ?? 0) * cover
        el.style.filter = blur > 0.05 ? `blur(${blur.toFixed(2)}px)` : ''
      }
    }
    // Next-section reveal: first half draws the slit top to bottom, second half opens it fully.
    // The section itself is held at the top of the screen by CSS (sticky in .curtain-hold).
    const line = ease(clamp01(cover / 0.5))
    const spread = ease(clamp01((cover - 0.5) / 0.5))
    // Once open, <main> covers the hero with the page white: the hero (taller than the screen-tall
    // Wedding section) would otherwise show through the sections below Wedding, which have no
    // background of their own. Transparent while the slit is open over the hero.
    pin.nextElementSibling.style.backgroundColor = cover >= 1 ? '#fff' : ''
    if (cover >= 1) {
      nextSection.style.clipPath = ''
    } else {
      const side = (nextSection.offsetWidth / 2 - SLIT_HALF) * (1 - spread)
      nextSection.style.clipPath = `inset(0 ${side.toFixed(2)}px ${((1 - line) * 100).toFixed(3)}% ${side.toFixed(2)}px)`
    }
    revealNextHead()
    const settling = Math.abs(target.x - current.x) > 0.001 || Math.abs(target.y - current.y) > 0.001
    running = settling
    if (settling) requestAnimationFrame(frame)
  }
  function start() {
    if (running) return
    running = true
    requestAnimationFrame(frame)
  }
  start()
}

// Wedding collection: the section is exactly one screen tall (CSS); size the arch cards so the
// heading and every row of cards fit in it. Desktop: --wedding-card-zoom scales the design card
// (at most 1). Below 1200px: --wedding-card-w caps the card width in its grid column.
function fitWedding(section) {
  const head = section.querySelector('.section-head')
  const grid = section.querySelector('.wedding__grid')
  const CARD = { w: 417.367, h: 621 }
  function fit() {
    // Layout units: design px on desktop (inside the zoomed page), real px below 1200px.
    const unit = isFluid ? 1 : (parseFloat(getComputedStyle(document.documentElement).getPropertyValue('--page-zoom')) || 1)
    const cs = getComputedStyle(section)
    const gs = getComputedStyle(grid)
    const cols = gs.display === 'grid' ? gs.gridTemplateColumns.split(' ').length : grid.children.length
    const rows = Math.ceil(grid.children.length / cols)
    const rowGap = parseFloat(gs.rowGap) || 0
    const available = window.innerHeight / unit - parseFloat(cs.paddingTop) - parseFloat(cs.paddingBottom) -
      head.getBoundingClientRect().height / unit - parseFloat(gs.marginTop)
    const cardHeight = Math.max(120, (available - (rows - 1) * rowGap) / rows)
    section.style.setProperty('--wedding-card-zoom', String(Math.min(1, cardHeight / CARD.h)))
    section.style.setProperty('--wedding-card-w', `${(cardHeight * CARD.w / CARD.h).toFixed(2)}px`)
  }
  fit()
  window.addEventListener('resize', fit)
  document.fonts.ready.then(fit)
}
const weddingSection = document.querySelector('.wedding')
if (weddingSection) fitWedding(weddingSection)

const heroPin = document.querySelector('.hero-pin')
const reduceMotionQuery = window.matchMedia('(prefers-reduced-motion: reduce)')
const sceneActive = Boolean(heroPin) && !isFluid && !reduceMotionQuery.matches
// Below 1200px only the curtain part of the hero scene runs (see initHeroCurtain).
const curtainOnly = Boolean(heroPin) && isFluid && !reduceMotionQuery.matches

// Reveal-on-scroll: [data-reveal] blocks get .is-inview once they have risen into the upper half
// of the viewport, which starts their CSS entrance animations. [data-reveal="scene"] blocks are
// triggered by the hero scene instead (when it runs).
// [data-reveal="toggle"] blocks play their animation in reverse when scrolled back up. They are
// keyed to their section's top so the whole section animates together: scrolling down they come
// in once it has risen into the upper half; scrolling up they go out as soon as it has moved
// back down a little, while still on screen. Jumps past either end settle the state directly.
let pendingReveals = [...document.querySelectorAll(sceneActive || curtainOnly ? '[data-reveal]:not([data-reveal="scene"]):not([data-reveal="toggle"])' : '[data-reveal]:not([data-reveal="toggle"])')]
const toggleReveals = [...document.querySelectorAll('[data-reveal="toggle"]')]
let lastScrollY = window.scrollY
function checkToggleReveals() {
  // No movement (repeat scroll events, initial check): only the jump rules apply, so a stray
  // event can't count as "scrolling down" and bring hidden cards back.
  const delta = window.scrollY - lastScrollY
  const down = delta > 0
  const up = delta < 0
  lastScrollY = window.scrollY
  for (const el of toggleReveals) {
    const top = el.closest('section').getBoundingClientRect().top
    if (top <= 0 || (down && top < window.innerHeight * 0.45)) el.classList.add('is-inview')
    else if (top > window.innerHeight || (up && top > window.innerHeight * 0.15)) el.classList.remove('is-inview')
  }
}
if (toggleReveals.length) {
  window.addEventListener('scroll', checkToggleReveals, { passive: true })
  checkToggleReveals()
}
function checkReveals() {
  pendingReveals = pendingReveals.filter((el) => {
    const top = el.getBoundingClientRect().top
    if (top < window.innerHeight * 0.5) {
      el.classList.add('is-inview')
      // Curtain sections: mark when the sheet has fully opened (1.5s), so reversible card rows
      // inside wait for the curtain only the first time they come in.
      if (el.classList.contains('curtain-reveal')) setTimeout(() => el.classList.add('is-opened'), 1500)
      return false
    }
    return true
  })
  if (pendingReveals.length === 0) window.removeEventListener('scroll', checkReveals)
}
window.addEventListener('scroll', checkReveals, { passive: true })
checkReveals()

if (sceneActive) {
  initHeroScene(heroPin, heroPin.querySelector('.hero'))
}

// Hero curtain below 1200px: the curtain phase of the desktop scene on its own. The hero sticks
// while the page content (Wedding collection first) is held at the top of the screen and
// revealed over it through a 2px slit drawn top to bottom, which then opens to full width; the
// Wedding heading and cards animate in once it is open. Then the page scrolls on. The slit is cut
// from <main> rather than the Wedding section so it always spans the full screen height, even
// when the section is shorter than the screen. Distances in real px.
function initHeroCurtain(pin, hero) {
  const main = pin.nextElementSibling
  const section = main.querySelector('section')
  const hold = main.querySelector('.curtain-hold')
  const reveals = [...section.querySelectorAll('[data-reveal="scene"]')]
  const SLIT_HALF = 1
  const REVEAL_AT = 0.9
  const HIDE_AT = 0.89
  const ease = (t) => t * t * (3 - 2 * t)
  const clamp01 = (t) => Math.min(Math.max(t, 0), 1)
  let distance = 0

  hero.style.position = 'sticky'
  hero.style.top = '0'
  main.style.position = 'relative'
  main.style.zIndex = '1'

  // <main> starts at the top of the hero; the Wedding section sticks to the top of the screen
  // inside .curtain-hold (a curtain-distance taller than it), so the browser holds it while
  // scrolling (no script lag) and it scrolls on once the curtain is done.
  section.style.position = 'sticky'
  section.style.top = '0'
  function layout() {
    distance = Math.round(window.innerHeight * 1.1)
    const heroHeight = hero.offsetHeight
    pin.style.height = `${heroHeight + distance}px`
    main.style.marginTop = `${-(heroHeight + distance)}px`
    hold.style.height = `${section.offsetHeight + distance}px`
  }

  function update() {
    const scrolled = Math.max(0, -pin.getBoundingClientRect().top)
    const cover = clamp01(scrolled / distance)
    // First half draws the slit top to bottom, second half opens it to full width.
    const line = ease(clamp01(cover / 0.5))
    const spread = ease(clamp01((cover - 0.5) / 0.5))
    // <main> gets a background (its sections below Wedding have none, and the hero sits behind
    // it): night while the slit is drawn, so the line is black the full screen height, fading
    // to the page white as it opens.
    const mix = (a, b) => Math.round(a + (b - a) * spread)
    main.style.backgroundColor = cover >= 1 ? '#fff' : `rgb(${mix(5, 255)}, ${mix(3, 255)}, ${mix(10, 255)})`
    // The slit is cut from <main>, whose top is `scrolled` above the screen top.
    if (cover >= 1) {
      main.style.clipPath = ''
    } else {
      const side = (main.offsetWidth / 2 - SLIT_HALF) * (1 - spread)
      const bottom = main.offsetHeight - scrolled - window.innerHeight * line
      main.style.clipPath = `inset(${scrolled.toFixed(2)}px ${side.toFixed(2)}px ${bottom.toFixed(2)}px ${side.toFixed(2)}px)`
    }
    // Cards (not the heading) slide back out when scrolling back up into the curtain.
    if (cover >= REVEAL_AT) reveals.forEach((el) => el.classList.add('is-inview'))
    else if (cover < HIDE_AT) reveals.forEach((el) => { if (el.matches('.wedding__grid')) el.classList.remove('is-inview') })
  }

  layout()
  window.addEventListener('resize', () => { layout(); update() })
  window.addEventListener('scroll', update, { passive: true })
  update()
}

if (curtainOnly) {
  initHeroCurtain(heroPin, heroPin.querySelector('.hero'))
}

// Slide scene: the bride banner scrolls up normally and pins, then, as scroll steps:
//   1. the banner zooms in until it fills the screen (its photo zooms a little more for depth);
//   2. Shop by Occasion slides in from the right over the banner (the banner dims).
// Then the stage releases and the page scrolls on through Shop by Occasion.
//   length = scroll px for the step   hold = share of it spent before anything moves
function initSlideScene(pin) {
  pin.classList.add('is-active')
  const stage = pin.querySelector('.slide-pin__stage')
  const banner = pin.querySelector('.slide-still')
  const frame = banner.querySelector('.bride-banner')
  const photo = banner.querySelector('.bride-banner__b')
  const occasions = pin.querySelector('.slide-panel')
  const steps = [
    { length: 1000, hold: 0.1 }, // banner zooms to full screen
    { length: 2200, hold: 0.1 }, // Shop by Occasion in, then its cards one by one
  ]
  const occasionCards = [...occasions.querySelectorAll('.occasion-card')]
  const PANEL_END = 0.45 // Occasion panel fully in at this share of its step
  const CARDS_START = 0.38 // share of the step when the first card starts (panel ~90% across)
  const CARD_DURATION = 0.22
  const CARD_STAGGER = 0.12
  const media = frame.querySelector('.bride-banner__media')
  const text = frame.querySelector('.bride-banner__text')
  // Banner frame geometry in the design (px) and its text block's vertical centre in the frame.
  const BANNER = { left: 170, top: 124, w: 1580, h: 639, textCentreY: 320 }
  // The couple photo (.bride-banner__b) spans this vertical range of the frame (top: -89px, 1053px tall).
  const PHOTO = { top: -89, bottom: 964 }
  const PHOTO_EXTRA_ZOOM = 0.12
  const TEXT_EXTRA_ZOOM = 0.15
  const ease = (t) => t * t * (3 - 2 * t)
  const clamp01 = (t) => Math.min(Math.max(t, 0), 1)

  // The stage is as tall as Shop by Occasion; the pin adds the scroll length of every step.
  function layout() {
    stage.style.height = `${occasions.offsetHeight}px`
    pin.style.height = `${occasions.offsetHeight + steps.reduce((sum, s) => sum + s.length, 0)}px`
  }

  function update() {
    const zoom = parseFloat(getComputedStyle(document.documentElement).getPropertyValue('--page-zoom')) || 1
    let scrolled = -pin.getBoundingClientRect().top / zoom
    const [zoomT, occRaw] = steps.map((step) => {
      const t = clamp01((scrolled - step.hold * step.length) / ((1 - step.hold) * step.length))
      scrolled -= step.length
      return t
    }).map((t, i) => (i < 1 ? ease(t) : t))
    const occT = ease(clamp01(occRaw / PANEL_END))
    occasionCards.forEach((card, i) => {
      const c = ease(clamp01((occRaw - CARDS_START - i * CARD_STAGGER) / CARD_DURATION))
      card.style.setProperty('--card', c.toFixed(4))
    })

    // Banner zoom: the frame (1580×639 at 170, 124) grows to the full screen; its media layer
    // scales to cover the new size; the text keeps its screen x, moves to the vertical centre
    // and grows only slightly, so nothing is cropped.
    const screenHeight = window.innerHeight / zoom
    const z = zoomT
    const W = BANNER.w + (1920 - BANNER.w) * z
    const H = BANNER.h + (screenHeight - BANNER.h) * z
    banner.style.paddingTop = z > 0 ? `${(BANNER.top * (1 - z)).toFixed(2)}px` : ''
    frame.style.marginLeft = z > 0 ? `${(BANNER.left * (1 - z)).toFixed(2)}px` : ''
    frame.style.width = z > 0 ? `${W.toFixed(2)}px` : ''
    frame.style.height = z > 0 ? `${H.toFixed(2)}px` : ''
    // Scale only as far as the photo (taller than the frame: PHOTO.top..PHOTO.bottom in frame px)
    // needs to cover the screen, not the frame box, so tall screens don't over-crop the couple;
    // and move the photo's centre (rather than the frame's) to the screen's centre.
    const cover = Math.max(W / BANNER.w, H / (PHOTO.bottom - PHOTO.top))
    const photoCentreOffset = ((PHOTO.top + PHOTO.bottom) / 2 - BANNER.h / 2) * cover * z
    media.style.transform = z > 0
      ? `translate(${(W / 2 - BANNER.w / 2).toFixed(2)}px, ${(H / 2 - BANNER.h / 2 - photoCentreOffset).toFixed(2)}px) scale(${cover.toFixed(4)})`
      : ''
    const textCentreY = BANNER.top + BANNER.textCentreY // on screen, before zooming
    text.style.transform = z > 0
      ? `translate(${(BANNER.left * z).toFixed(2)}px, ${((screenHeight / 2 - textCentreY) * z + BANNER.top * z).toFixed(2)}px) scale(${(1 + TEXT_EXTRA_ZOOM * z).toFixed(4)})`
      : ''
    photo.style.transform = z > 0 ? `scale(${(1 + PHOTO_EXTRA_ZOOM * z).toFixed(4)})` : ''

    occasions.style.setProperty('--p', occT.toFixed(4))
    banner.style.setProperty('--dim', occT.toFixed(4))
  }
  layout()
  window.addEventListener('resize', layout)
  window.addEventListener('scroll', update, { passive: true })
  window.addEventListener('resize', update)
  update()
}

const slidePin = document.querySelector('.slide-pin')
if (slidePin && !isFluid && !window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
  initSlideScene(slidePin)
}

// Bride banner below 1200px (no pinned scene there): it zooms in from the design's inset width
// (1580 of 1920) to the full screen width as it scrolls from the bottom of the screen to the
// middle. A transform, so nothing below it moves.
function initBannerGrow(banner) {
  const START = 1580 / 1920
  const clamp01 = (t) => Math.min(Math.max(t, 0), 1)
  const ease = (t) => t * t * (3 - 2 * t)
  function update() {
    const r = banner.getBoundingClientRect()
    const vh = window.innerHeight
    // 0 when its top enters at the bottom of the screen, 1 when its centre reaches the middle.
    const p = ease(clamp01((vh - r.top) / (vh / 2 + r.height / 2)))
    banner.style.setProperty('--grow-scale', (START + (1 - START) * p).toFixed(4))
  }
  window.addEventListener('scroll', update, { passive: true })
  window.addEventListener('resize', update)
  update()
}

const brideBanner = document.querySelector('.bride-banner')
if (brideBanner && isFluid && !window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
  initBannerGrow(brideBanner)
}

// Hero: Figma "Warp" effect (Twist) on the translucent copy of the model (node 147:15).
// The page ships with that shader's output pre-rendered (hero-model-warp.png), so the effect
// shows everywhere. Where WebGPU is available we swap in the live shader, which renders the
// same image at the screen's exact resolution.
async function upgradeHeroWarp(host) {
  const { acquireDevice, mountShaderEffect } = window.ShaderRuntime
  const { warp } = window.FigmaEffects
  const img = host.querySelector('img')
  const baked = img.getAttribute('src')
  try {
    await acquireDevice()
    const source = new Image()
    source.src = img.dataset.shaderSource
    await source.decode()
    img.src = source.src
    img.classList.add('is-shader-input')
  } catch {
    return
  }
  const canvas = await mountShaderEffect(host, [
    {
      setup: warp.setup,
      render: warp.render,
      params: { warpMode: 1, centerPoint: { x: 50, y: 50 }, warpScale: 1.649999976158142, amplitude: 12.100000381469727 },
      manifest: warp.manifest,
    },
  ])
  if (!canvas) {
    img.src = baked
    img.classList.remove('is-shader-input')
  }
}

const heroWarp = document.getElementById('hero-warp')
if (heroWarp && navigator.gpu && location.protocol !== 'file:') {
  upgradeHeroWarp(heroWarp)
}

// Saree collection: rotate the slides through the five fixed card slots. Each change moves every
// card from its neighbouring slot into its own (position and size, so photos never stretch); the
// card at the trailing edge slides off and fades out while a new one enters from the leading edge,
// and the caption lifts in.
// It auto-advances every AUTO_MS while on screen, pausing while hovered/focused or while the tab
// is hidden; manual arrows restart the timer.
function initSareeCarousel(root) {
  const AUTO_MS = 4000
  const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches
  const slots = [...root.querySelectorAll('[data-slot]')]
    .sort((a, b) => parseFloat(a.style.left) - parseFloat(b.style.left))
  const photos = slots.map((slot) => slot.querySelector('.carousel-card__photo'))
  const slides = photos.map((img) => ({ src: img.getAttribute('src'), alt: img.alt, caption: img.dataset.caption }))
  const center = Math.floor(slots.length / 2)
  const caption = root.querySelector('[data-caption-target]')
  const dots = [...root.querySelectorAll('.carousel-pager__dot')]
  const nameEl = caption.querySelector('.carousel-card__name')
  const kindEl = caption.querySelector('.carousel-card__kind')
  let offset = 0

  // Captions keep the Figma layout of the first one ("Kanchipuram" / "Sarees"): the name centred
  // where it was, the small word's right edge the same distance in from the name's end. Names
  // wider than the card's margins shrink to fit, keeping their baseline.
  const original = { name: nameEl.textContent, kind: kindEl.textContent }
  const NAME_LEFT = parseFloat(getComputedStyle(nameEl).left)
  const NAME_TOP = parseFloat(getComputedStyle(nameEl).top)
  const KIND_LEFT = parseFloat(getComputedStyle(kindEl).left)
  const CARD_WIDTH = parseFloat(getComputedStyle(caption.parentElement).width)
  const measureCtx = document.createElement('canvas').getContext('2d')
  const measure = (el, text) => {
    measureCtx.font = getComputedStyle(el).font
    return measureCtx.measureText(text)
  }
  const textWidth = (el, text) => measure(el, text).width
  function placeCaption() {
    nameEl.style.fontSize = ''
    nameEl.style.top = ''
    const baseSize = parseFloat(getComputedStyle(nameEl).fontSize)
    const baseName = textWidth(nameEl, original.name)
    const baseKind = textWidth(kindEl, original.kind)
    const metrics = measure(nameEl, nameEl.textContent)
    const fit = Math.min(1, (CARD_WIDTH - 2 * NAME_LEFT) / metrics.width)
    const nameW = metrics.width * fit
    if (fit < 1) {
      const size = baseSize * fit
      const ascent = metrics.fontBoundingBoxAscent / baseSize
      nameEl.style.fontSize = `${size.toFixed(2)}px`
      nameEl.style.top = `${(NAME_TOP + (baseSize - size) * ascent).toFixed(2)}px`
    }
    const kindW = textWidth(kindEl, kindEl.textContent)
    const nameLeft = NAME_LEFT + (baseName - nameW) / 2
    const kindRight = KIND_LEFT + baseKind + (nameLeft + nameW - (NAME_LEFT + baseName))
    nameEl.style.left = `${nameLeft.toFixed(2)}px`
    kindEl.style.left = `${(kindRight - kindW).toFixed(2)}px`
  }
  // Web fonts change the measurements once they have loaded.
  document.fonts.ready.then(placeCaption)

  function render() {
    photos.forEach((img, i) => {
      const slide = slides[(i + offset) % slides.length]
      img.src = slide.src
      img.alt = slide.alt
    })
    const current = slides[(center + offset) % slides.length]
    const [name, kind] = (current.caption ?? '').split('|')
    caption.hidden = !current.caption
    nameEl.textContent = name ?? ''
    kindEl.textContent = kind ?? ''
    if (current.caption) placeCaption()
    dots.forEach((dot, i) => dot.classList.toggle('is-active', i === offset))
  }

  // Slot geometry in design px: { left, top, width, height } as keyframe values.
  const geometry = slots.map((slot) => {
    const cs = getComputedStyle(slot)
    return { left: parseFloat(cs.left), top: parseFloat(cs.top), width: parseFloat(cs.width), height: parseFloat(cs.height) }
  })
  const px = (g) => ({ left: `${g.left}px`, top: `${g.top}px`, width: `${g.width}px`, height: `${g.height}px` })
  // One slot further out past the given edge slot (for cards entering / leaving the row).
  const beyond = (edge, inner) => ({ ...geometry[edge], left: 2 * geometry[edge].left - geometry[inner].left })
  const MOVE = { duration: 850, easing: 'cubic-bezier(0.65, 0, 0.35, 1)' }

  // Forwards (direction 1) each card's slide came from the slot on its right.
  function animateMove(direction) {
    if (reduceMotion) return
    const last = slots.length - 1
    slots.forEach((slot, i) => {
      const from = i + direction
      const start = from < 0 ? beyond(0, 1) : from > last ? beyond(last, last - 1) : geometry[from]
      const entering = from < 0 || from > last
      slot.animate(
        [{ ...px(start), opacity: entering ? 0 : 1 }, { ...px(geometry[i]), opacity: 1 }],
        MOVE,
      )
    })
    caption.animate(
      [{ transform: 'translateY(30px)', opacity: 0 }, { transform: 'none', opacity: 1 }],
      { duration: 700, delay: 450, easing: 'cubic-bezier(0.22, 1, 0.36, 1)', fill: 'backwards' },
    )
  }

  // Copy of the card about to leave the row, slid off past its edge and removed.
  function animateLeaving(direction) {
    if (reduceMotion) return
    const last = slots.length - 1
    const [edge, inner] = direction > 0 ? [0, 1] : [last, last - 1]
    const ghost = slots[edge].cloneNode(true)
    ghost.removeAttribute('data-slot')
    ghost.setAttribute('aria-hidden', 'true')
    ghost.style.pointerEvents = 'none'
    root.appendChild(ghost)
    ghost.animate(
      [{ ...px(geometry[edge]), opacity: 1 }, { ...px(beyond(edge, inner)), opacity: 0 }],
      { ...MOVE, fill: 'forwards' },
    ).finished.then(() => ghost.remove())
  }

  const step = (delta) => {
    animateLeaving(delta)
    offset = (offset + delta + slides.length) % slides.length
    render()
    animateMove(delta)
  }

  // Auto-slide, only while the carousel is on screen.
  let timer = null
  let paused = false
  let onScreen = false
  new IntersectionObserver(([entry]) => { onScreen = entry.isIntersecting }, { threshold: 0.4 }).observe(root)
  const restart = () => {
    clearInterval(timer)
    if (reduceMotion) return
    timer = setInterval(() => {
      if (!paused && onScreen && !document.hidden) step(1)
    }, AUTO_MS)
  }
  root.addEventListener('pointerenter', () => { paused = true })
  root.addEventListener('pointerleave', () => { paused = false })
  root.addEventListener('focusin', () => { paused = true })
  root.addEventListener('focusout', () => { paused = false })

  root.querySelectorAll('[data-carousel-prev]').forEach((btn) => btn.addEventListener('click', () => { step(-1); restart() }))
  root.querySelectorAll('[data-carousel-next]').forEach((btn) => btn.addEventListener('click', () => { step(1); restart() }))
  restart()
}

// Shop by pattern: rotate the three patterns through the side / main / side pills. Each change
// slides the new images in (forwards from the right, backwards from the left). It auto-advances
// every AUTO_MS once revealed, pausing while hovered/focused or while the tab is hidden; manual
// arrows restart the timer.
function initPatternCarousel(root) {
  const AUTO_MS = 3500
  const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches
  const slots = [...root.querySelectorAll('[data-pattern-slot]')]
  const items = slots.map((slot) => {
    const img = slot.querySelector('img')
    return { src: img.getAttribute('src'), alt: img.alt, label: slot.querySelector('.pattern-pill__label').textContent, crop: img.getAttribute('style'), href: slot.getAttribute('href') }
  })
  let offset = 0

  function render() {
    slots.forEach((slot, i) => {
      const item = items[(i + offset) % items.length]
      const img = slot.querySelector('img')
      img.src = item.src
      img.alt = item.alt
      // Figma crops are specific to each pattern's original pill; elsewhere fill the frame.
      img.setAttribute('style', offset === 0 ? item.crop : '')
      img.classList.toggle('is-fitted', offset !== 0)
      slot.querySelector('.pattern-pill__label').textContent = item.label
      slot.setAttribute('href', item.href) // the link moves with its pattern
    })
  }

  function animateIn(direction) {
    if (reduceMotion) return
    slots.forEach((slot, i) => {
      const from = { transform: `translateX(${direction * 80}px)`, opacity: 0 }
      const to = { transform: 'translateX(0)', opacity: 1 }
      const timing = { duration: 650, delay: i * 90, easing: 'cubic-bezier(0.22, 1, 0.36, 1)', fill: 'backwards' }
      slot.querySelector('.pattern-pill__frame img').animate([from, to], timing)
      slot.querySelector('.pattern-pill__label').animate([from, to], timing)
    })
  }

  const step = (delta) => {
    offset = (offset + delta + items.length) % items.length
    render()
    animateIn(delta)
  }

  // Auto-slide.
  let timer = null
  let paused = false
  const restart = () => {
    clearInterval(timer)
    if (reduceMotion) return
    timer = setInterval(() => {
      if (!paused && !document.hidden && root.classList.contains('is-inview')) step(1)
    }, AUTO_MS)
  }
  root.addEventListener('pointerenter', () => { paused = true })
  root.addEventListener('pointerleave', () => { paused = false })
  root.addEventListener('focusin', () => { paused = true })
  root.addEventListener('focusout', () => { paused = false })

  root.querySelector('[data-pattern-prev]').addEventListener('click', () => { step(-1); restart() })
  root.querySelector('[data-pattern-next]').addEventListener('click', () => { step(1); restart() })
  restart()
}

// Blogs: a looping carousel. The cards (plus a copy of them for a seamless loop) sit on a track
// that glides one card left every AUTO_MS while on screen, pausing while hovered/focused or while
// the tab is hidden. After a full lap the track jumps back to the start without a transition,
// which looks identical because the copies are showing.
function initBlogCarousel(grid) {
  const AUTO_MS = 3500
  const cards = [...grid.children]
  const track = document.createElement('div')
  track.className = 'blog-track'
  track.append(...cards)
  cards.forEach((card) => {
    const copy = card.cloneNode(true)
    copy.setAttribute('aria-hidden', 'true')
    copy.querySelectorAll('a').forEach((a) => a.setAttribute('tabindex', '-1'))
    track.append(copy)
  })
  grid.append(track)
  grid.classList.add('is-carousel')

  const MOVE_MS = 900 // matches the .blog-track transition
  let index = 0
  // Exact (fractional) widths: offsetWidth rounds, which would drift over a lap.
  const stepWidth = () => parseFloat(getComputedStyle(cards[0]).width) + parseFloat(getComputedStyle(track).columnGap)
  const place = () => { track.style.transform = `translateX(${-index * stepWidth()}px)` }
  // After the last step of a lap, jump back to the start once the glide has finished (a timer,
  // not transitionend, so it can't be missed while the tab is in the background).
  function rewind() {
    track.style.transition = 'none'
    index = 0
    place()
    track.offsetWidth // apply the jump before transitions come back
    track.style.transition = ''
  }

  let paused = false
  let onScreen = false
  new IntersectionObserver(([entry]) => { onScreen = entry.isIntersecting }, { threshold: 0.4 }).observe(grid)
  grid.addEventListener('pointerenter', () => { paused = true })
  grid.addEventListener('pointerleave', () => { paused = false })
  grid.addEventListener('focusin', () => { paused = true })
  grid.addEventListener('focusout', () => { paused = false })
  setInterval(() => {
    if (paused || !onScreen || document.hidden) return
    index += 1
    place()
    if (index === cards.length) setTimeout(rewind, MOVE_MS + 50)
  }, AUTO_MS)
  window.addEventListener('resize', place)
}

const blogGrid = document.querySelector('.blog-grid')
if (blogGrid && !window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
  initBlogCarousel(blogGrid)
}

// Search: the header search button opens a full-width search bar (focused) over a dimmed page;
// Esc, the close button or a click on the backdrop closes it and returns focus to the button.
function initSearch(button, panel) {
  const input = panel.querySelector('input')
  const CLOSE_MS = 450 // matches the .search-bar transition
  let closeTimer = null

  function open() {
    clearTimeout(closeTimer)
    panel.hidden = false
    panel.offsetWidth // start the slide from the hidden state
    panel.classList.add('is-open')
    button.setAttribute('aria-expanded', 'true')
    input.focus({ preventScroll: true })
  }
  function close() {
    if (!panel.classList.contains('is-open')) return
    panel.classList.remove('is-open')
    button.setAttribute('aria-expanded', 'false')
    closeTimer = setTimeout(() => { panel.hidden = true }, CLOSE_MS)
    button.focus({ preventScroll: true })
  }

  button.addEventListener('click', open)
  panel.querySelectorAll('[data-search-close]').forEach((el) => el.addEventListener('click', close))
  document.addEventListener('keydown', (e) => { if (e.key === 'Escape') close() })
  // No search results page yet: keep the bar open instead of reloading the page.
  panel.querySelector('form').addEventListener('submit', (e) => e.preventDefault())
}

const searchButton = document.querySelector('.site-actions__search')
const searchPanel = document.getElementById('search-panel')
if (searchButton && searchPanel) initSearch(searchButton, searchPanel)

// Cursor sparkle trail (mouse/trackpad only, not with reduced motion). Moving: PER_STEP gold
// sparkles are dropped every SPACING px along the path, drifting slightly down. Still:
// IDLE_PER_TICK sparkles keep flowing out of the pointer in all directions every IDLE_MS (stops
// when the pointer leaves the window or the tab is hidden). Each animates itself out (CSS) and is
// removed; at most MAX are on screen at once.
function initCursorSparkles() {
  const SPACING = 8
  const PER_STEP = 2
  const IDLE_MS = 30
  const IDLE_PER_TICK = 2
  const MAX = 180
  const layer = document.createElement('div')
  layer.className = 'cursor-sparkles'
  layer.setAttribute('aria-hidden', 'true')
  document.body.append(layer)
  const rand = (min, max) => min + Math.random() * (max - min)
  let last = null // last spawn point
  let pointer = null // current pointer position, null when outside the window

  function spawn(x, y, dx, dy) {
    if (layer.childElementCount >= MAX) layer.firstElementChild.remove()
    const s = document.createElement('span')
    s.className = 'cursor-sparkle'
    s.style.setProperty('--x', `${x.toFixed(1)}px`)
    s.style.setProperty('--y', `${y.toFixed(1)}px`)
    s.style.setProperty('--s', `${rand(12, 24).toFixed(1)}px`)
    s.style.setProperty('--r', `${rand(0, 90).toFixed(0)}deg`)
    s.style.setProperty('--dx', `${dx.toFixed(1)}px`)
    s.style.setProperty('--dy', `${dy.toFixed(1)}px`)
    s.addEventListener('animationend', () => s.remove())
    layer.append(s)
  }

  window.addEventListener('pointermove', (e) => {
    if (e.pointerType !== 'mouse') return
    pointer = { x: e.clientX, y: e.clientY }
    if (last && Math.hypot(e.clientX - last.x, e.clientY - last.y) < SPACING) return
    last = { ...pointer }
    for (let i = 0; i < PER_STEP; i++) {
      spawn(e.clientX + rand(-10, 10), e.clientY + rand(-10, 10), rand(-18, 18), rand(6, 28))
    }
  }, { passive: true })
  document.documentElement.addEventListener('pointerleave', () => { pointer = null })

  // Still pointer: a steady fountain of sparkles flowing outward from it in all directions.
  setInterval(() => {
    if (!pointer || document.hidden) return
    for (let i = 0; i < IDLE_PER_TICK; i++) {
      const angle = rand(0, Math.PI * 2)
      const dist = rand(35, 95)
      spawn(pointer.x + rand(-6, 6), pointer.y + rand(-6, 6), Math.cos(angle) * dist, Math.sin(angle) * dist)
    }
  }, IDLE_MS)
}
if (window.matchMedia('(hover: hover) and (pointer: fine)').matches && !window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
  initCursorSparkles()
}

// Account menu: the header account button toggles a small card under it; a click outside, Esc,
// scrolling or resizing closes it. Placed from the button's on-screen position, so it lines up
// at any page zoom.
function initAccountMenu(button, menu) {
  const CLOSE_MS = 250 // matches the .account-menu transition
  let closeTimer = null

  function place() {
    const r = button.getBoundingClientRect()
    const right = Math.max(12, window.innerWidth - r.right - 16)
    menu.style.top = `${Math.round(r.bottom + 14)}px`
    menu.style.right = `${Math.round(right)}px`
    // Point the arrow at the icon's centre.
    menu.style.setProperty('--arrow-right', `${Math.round(window.innerWidth - right - (r.left + r.width / 2) - 6)}px`)
  }
  function open() {
    clearTimeout(closeTimer)
    place()
    menu.hidden = false
    menu.offsetWidth // start the transition from the closed state
    menu.classList.add('is-open')
    button.setAttribute('aria-expanded', 'true')
  }
  function close() {
    if (!menu.classList.contains('is-open')) return
    menu.classList.remove('is-open')
    button.setAttribute('aria-expanded', 'false')
    closeTimer = setTimeout(() => { menu.hidden = true }, CLOSE_MS)
  }

  button.addEventListener('click', (e) => {
    e.stopPropagation()
    if (menu.classList.contains('is-open')) close()
    else open()
  })
  document.addEventListener('click', (e) => { if (!menu.contains(e.target)) close() })
  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape' && menu.classList.contains('is-open')) { close(); button.focus({ preventScroll: true }) }
  })
  window.addEventListener('scroll', close, { passive: true })
  window.addEventListener('resize', close)
}

const accountButton = document.querySelector('.site-actions__account')
const accountMenu = document.getElementById('account-menu')
if (accountButton && accountMenu) initAccountMenu(accountButton, accountMenu)

// Cart drawer: slides in from the right when the header bag button or an Add to Cart / Buy Now
// button is used; Esc, the close button or a click on the backdrop closes it. Items can be
// stepped up/down or removed; the NEW10 coupon takes 10% off; "Top deals" (js/products.js, when
// loaded) can be added with their + buttons; the bill summary, footer total and bag badge follow.
// The cart is kept in localStorage so it survives moving between pages (and still works without).
const CART_KEY = 'mighty-silks-cart'
// The featured coupon comes from the store (window.SHOP, Admin › Coupons); without one there's
// no code to apply.
const COUPON = (window.SHOP && window.SHOP.coupon) || { code: '', rate: 0 }

// Store endpoints (Laravel, under api/): JSON or FormData posted with the page's CSRF token. Resolves
// to the response body; a failed request rejects with the store's message (for a rejected form,
// its first field error). Also used by js/product.js.
async function api(url, body) {
  const json = body !== undefined && !(body instanceof FormData)
  const res = await fetch(url, {
    method: body === undefined ? 'GET' : 'POST',
    headers: {
      Accept: 'application/json',
      'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
      ...(json ? { 'Content-Type': 'application/json' } : {}),
    },
    body: json ? JSON.stringify(body) : body,
    credentials: 'same-origin',
  })
  const data = await res.json().catch(() => ({}))
  if (!res.ok) {
    const first = data.errors && Object.values(data.errors)[0]
    throw new Error((first && first[0]) || data.message || 'Something went wrong. Please try again.')
  }
  return data
}
window.shopApi = api
const cart = { items: [], coupon: false, note: '' }
try {
  const saved = JSON.parse(localStorage.getItem(CART_KEY))
  if (saved && Array.isArray(saved.items)) Object.assign(cart, saved)
} catch {}
// Every change is saved and announced (cart:change) so the drawer and the cart page stay in step.
const saveCart = () => {
  try { localStorage.setItem(CART_KEY, JSON.stringify(cart)) } catch {}
  document.dispatchEvent(new Event('cart:change'))
}
const formatRupees = (value) => `₹${Math.round(value).toLocaleString('en-IN')}`
const cartCount = () => cart.items.reduce((sum, item) => sum + item.qty, 0)
const cartTotal = () => cart.items.reduce((sum, item) => sum + item.price * item.qty, 0)
// A cart item for a js/products.js product (null when the catalogue isn't loaded or lacks it).
function catalogueItem(id) {
  const p = window.PRODUCTS && window.PRODUCTS[id]
  return p ? { id, name: p.title, price: Number(p.price.replace(/[^\d.]/g, '')), image: p.gallery[0] } : null
}
// Saved carts follow the store's catalogue (js/products.js, loaded by the time the page is ready):
// names and prices are today's, and products no longer sold drop out, so the cart, drawer and
// checkout show what the store will charge. Announced (cart:change) only when something changed.
document.addEventListener('DOMContentLoaded', () => {
  if (!window.PRODUCTS) return
  const before = JSON.stringify(cart.items)
  cart.items = cart.items.filter((item) => window.PRODUCTS[item.id]).map((item) => {
    const fresh = catalogueItem(item.id)
    return { ...item, name: fresh.name, price: fresh.price }
  })
  if (!cart.items.length) cart.coupon = false
  if (JSON.stringify(cart.items) !== before) saveCart()
})
// Count badge on the header bag button (hidden at 0).
function updateCartBadge() {
  const badge = document.querySelector('[data-cart-badge]')
  if (!badge) return
  const count = cartCount()
  badge.textContent = count > 99 ? '99+' : String(count)
  badge.hidden = count === 0
  const bag = badge.closest('button')
  if (bag) bag.setAttribute('aria-label', `Shopping bag, ${count} ${count === 1 ? 'item' : 'items'}`)
}

function addToCart(product) {
  const existing = cart.items.find((item) => (product.id && item.id === product.id) || item.name === product.name)
  if (existing) existing.qty += 1
  else cart.items.push({ ...product, qty: 1 })
  saveCart()
  updateCartBadge()
}

function initCart(button, panel) {
  const drawer = panel.querySelector('.cart-drawer')
  const list = panel.querySelector('[data-cart-list]')
  const empty = panel.querySelector('[data-cart-empty]')
  const extras = panel.querySelector('[data-cart-extras]')
  const deals = panel.querySelector('[data-cart-deals]')
  const note = panel.querySelector('[data-cart-note]')
  const noteToggle = panel.querySelector('[data-cart-note-toggle]')
  const couponApply = panel.querySelector('[data-coupon-apply]')
  const checkout = panel.querySelector('[data-cart-checkout]')
  const icon = (d) => `<svg viewBox="0 0 24 24" aria-hidden="true"><path d="${d}"/></svg>`
  const PLUS = 'M12 5v14M5 12h14'
  const MINUS = 'M5 12h14'
  const TRASH = 'M4 7h16M10 11v6M14 11v6M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2l1-12M9 7V4h6v3'
  const CLOSE_MS = 450 // matches the .cart-drawer transition
  let closeTimer = null
  let lastFocus = null
  const set = (selector, text) => panel.querySelectorAll(selector).forEach((el) => { el.textContent = text })

  function render() {
    const count = cartCount()
    const total = cartTotal()
    const discount = cart.coupon ? Math.round(total * COUPON.rate) : 0
    const items = `${count} ${count === 1 ? 'item' : 'items'}`

    list.innerHTML = cart.items.map((item, i) => `
      <li class="cart-item">
        <img class="cart-item__photo" src="${item.image}" alt="">
        <p class="cart-item__name" title="${item.name}">${item.name}</p>
        <p class="cart-item__price">${formatRupees(item.price * item.qty)}</p>
        <div class="cart-item__controls">
          <button class="cart-item__remove" type="button" aria-label="Remove ${item.name}" data-cart-remove="${i}">${icon(TRASH)}</button>
          <div class="cart-qty">
            <button type="button" aria-label="Decrease quantity of ${item.name}" data-cart-dec="${i}">${icon(MINUS)}</button>
            <span aria-label="Quantity">${item.qty}</span>
            <button type="button" aria-label="Increase quantity of ${item.name}" data-cart-inc="${i}">${icon(PLUS)}</button>
          </div>
        </div>
      </li>`).join('')
    empty.hidden = count > 0
    list.hidden = count === 0
    extras.hidden = count === 0

    set('[data-cart-count]', `(${items})`)
    set('[data-cart-items]', items)
    set('[data-cart-subtotal]', formatRupees(total))
    set('[data-cart-total]', formatRupees(total - discount))
    set('[data-coupon-saving]', formatRupees(Math.round(total * COUPON.rate)))
    set('[data-cart-discount]', `−${formatRupees(discount)}`)
    panel.querySelector('[data-cart-discount-row]').hidden = !cart.coupon
    panel.querySelector('[data-coupon]').classList.toggle('is-applied', cart.coupon)
    couponApply.textContent = cart.coupon ? 'Remove' : 'Apply'
    couponApply.setAttribute('aria-pressed', String(cart.coupon))
    checkout.setAttribute('aria-disabled', String(count === 0))

    // Top deals: catalogue products that aren't in the cart yet.
    const catalogue = window.PRODUCTS ? Object.entries(window.PRODUCTS) : []
    const picks = catalogue.filter(([id]) => !cart.items.some((item) => item.id === id)).slice(0, 6)
    deals.closest('.cart-deals').hidden = picks.length === 0
    deals.innerHTML = picks.map(([id, p]) => `
      <li class="cart-deal">
        <a class="cart-deal__photo" href="product.html?p=${id}"><img src="${p.gallery[0]}" alt="" loading="lazy"></a>
        <button class="cart-deal__add" type="button" aria-label="Add ${p.title} to cart" data-deal="${id}">${icon(PLUS)}</button>
        <a class="cart-deal__name" href="product.html?p=${id}">${p.title}</a>
        <p class="cart-deal__price">${formatRupees(Number(p.price.replace(/[^\d.]/g, '')))}</p>
      </li>`).join('')
    updateCartBadge()
  }

  list.addEventListener('click', (e) => {
    const btn = e.target.closest('button')
    if (!btn) return
    const { cartInc, cartDec, cartRemove } = btn.dataset
    if (cartInc !== undefined) cart.items[cartInc].qty += 1
    else if (cartDec !== undefined) {
      if (cart.items[cartDec].qty > 1) cart.items[cartDec].qty -= 1
      else cart.items.splice(cartDec, 1) // stepping below 1 removes the item
    } else if (cartRemove !== undefined) cart.items.splice(cartRemove, 1)
    if (!cart.items.length) cart.coupon = false
    saveCart()
    render()
  })
  deals.addEventListener('click', (e) => {
    const btn = e.target.closest('[data-deal]')
    if (!btn) return
    const p = window.PRODUCTS[btn.dataset.deal]
    addToCart(catalogueItem(btn.dataset.deal))
    render()
  })
  couponApply.addEventListener('click', () => {
    if (!COUPON.code) return
    cart.coupon = !cart.coupon
    saveCart()
    render()
  })
  noteToggle.addEventListener('click', () => {
    const show = note.hidden
    note.hidden = !show
    noteToggle.setAttribute('aria-expanded', String(show))
    if (show) note.focus()
  })
  note.value = cart.note
  note.addEventListener('input', () => { cart.note = note.value; saveCart() })
  panel.querySelector('[data-cart-view-details]').addEventListener('click', () => {
    panel.querySelector('[data-cart-bill]').scrollIntoView({ behavior: 'smooth', block: 'nearest' })
  })

  function open() {
    clearTimeout(closeTimer)
    render()
    if (!panel.classList.contains('is-open')) lastFocus = document.activeElement
    panel.hidden = false
    panel.offsetWidth // start the slide from the closed state
    panel.classList.add('is-open')
    document.documentElement.classList.add('cart-locked')
    button.setAttribute('aria-expanded', 'true')
    drawer.focus({ preventScroll: true })
  }
  function close() {
    if (!panel.classList.contains('is-open')) return
    panel.classList.remove('is-open')
    document.documentElement.classList.remove('cart-locked')
    button.setAttribute('aria-expanded', 'false')
    closeTimer = setTimeout(() => { panel.hidden = true }, CLOSE_MS)
    ;(lastFocus || button).focus({ preventScroll: true })
  }

  button.addEventListener('click', open)
  panel.querySelectorAll('[data-cart-close]').forEach((el) => el.addEventListener('click', close))
  document.addEventListener('keydown', (e) => { if (e.key === 'Escape') close() })
  updateCartBadge()
  return { open }
}

const cartButton = document.querySelector('.site-actions__bag')
const cartPanel = document.getElementById('cart-panel')
const cartDrawer = cartButton && cartPanel ? initCart(cartButton, cartPanel) : null

// Cart page (cart.html, Figma "Cart" 281:2253): a row per cart item with − / + quantity
// (− stops at 1, as in the design's greyed minus) and a bin to remove it; the subtotal follows.
// An empty cart shows the empty state (the design's four sample sarees stay in the HTML only, for
// when the script doesn't run: they aren't in the store's catalogue, so they can't be ordered).
// "₹ 2,480.00", the page's price style (the drawer uses the shorter formatRupees).
const formatPrice = (value) => `₹ ${value.toLocaleString('en-IN', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`

function initCartPage(page) {
  const table = page.querySelector('[data-cart-page-table]')
  const rows = page.querySelector('[data-cart-page-rows]')
  const subtotal = page.querySelector('[data-cart-page-subtotal]')
  const empty = page.querySelector('[data-cart-page-empty]')

  function render() {
    rows.innerHTML = cart.items.map((item, i) => {
      const name = window.PRODUCTS && window.PRODUCTS[item.id]
        ? `<a href="product.html?p=${item.id}">${item.name}</a>`
        : item.name
      return `
      <li class="cart-row">
        <div class="cart-row__product">
          <span class="cart-row__photo"><img src="${item.image}" alt=""></span>
          <p class="cart-row__name">${name}</p>
        </div>
        <p class="cart-row__price"><span class="cart-row__label">Price</span>${formatPrice(item.price)}</p>
        <div class="cart-row__qty">
          <button type="button" aria-label="Decrease quantity of ${item.name}" data-cart-dec="${i}"${item.qty <= 1 ? ' disabled' : ''}><img src="assets/cart/minus.svg" alt=""></button>
          <span aria-label="Quantity">${item.qty}</span>
          <button type="button" aria-label="Increase quantity of ${item.name}" data-cart-inc="${i}"><img src="assets/cart/plus.svg" alt=""></button>
        </div>
        <p class="cart-row__total">${formatPrice(item.price * item.qty)}</p>
        <button class="cart-row__remove" type="button" aria-label="Remove ${item.name}" data-cart-remove="${i}"><img src="assets/cart/delete.svg" alt=""></button>
        <img class="cart-row__rule" src="assets/cart/row-rule.svg" alt="">
      </li>`
    }).join('')
    subtotal.textContent = formatPrice(cartTotal())
    table.hidden = cart.items.length === 0
    empty.hidden = cart.items.length > 0
    updateCartBadge()
  }

  rows.addEventListener('click', (e) => {
    const btn = e.target.closest('button')
    if (!btn) return
    const { cartInc, cartDec, cartRemove } = btn.dataset
    if (cartInc !== undefined) cart.items[cartInc].qty += 1
    else if (cartDec !== undefined) cart.items[cartDec].qty = Math.max(1, cart.items[cartDec].qty - 1)
    else if (cartRemove !== undefined) cart.items.splice(cartRemove, 1)
    if (!cart.items.length) cart.coupon = false
    saveCart() // re-renders through cart:change
  })
  document.addEventListener('cart:change', render)
  render()
}

const cartPage = document.querySelector('[data-cart-page]')
if (cartPage) initCartPage(cartPage)

// Checkout page (checkout.html; no Figma frame, built in the cart page's style): the order summary
// lists the saved cart, or with ?buy=<id> (a Buy Now button) just that product; standard shipping
// is free from ₹1,999 (after the coupon), else ₹99, and express is ₹250 (the store's rates, from
// window.SHOP). The coupon is the drawer's (kept to this order for Buy Now). Card fields show (and
// are required) only for card payment. Place Order sends the order to the store, which prices it
// from its catalogue; once taken, the cart empties (Buy Now: left alone) and the order opens.
const SHIPPING = (window.SHOP && window.SHOP.shipping) || { freeFrom: 1999, standard: 99, express: 250 }
const BUY_NOW_KEY = 'mighty-silks-buy-now'

// Placed orders (newest first, the last 20) in localStorage, for order-details.html.
const ORDERS_KEY = 'mighty-silks-orders'
function loadOrders() {
  try { return JSON.parse(localStorage.getItem(ORDERS_KEY)) || [] } catch { return [] }
}
function saveOrderRecord(record) {
  try {
    localStorage.setItem(ORDERS_KEY, JSON.stringify([record, ...loadOrders()].slice(0, 20)))
    return true
  } catch { return false }
}

// The Buy Now product for checkout.html?buy=<id>: the clicked card's details, else the catalogue's.
function buyNowItem() {
  const id = new URLSearchParams(location.search).get('buy')
  if (!id) return null
  let saved = null
  try { saved = JSON.parse(sessionStorage.getItem(BUY_NOW_KEY)) } catch {}
  if (saved && saved.id === id) return saved
  const item = catalogueItem(id)
  return item ? { ...item, qty: 1 } : null
}

function initCheckout(page) {
  const form = page.querySelector('[data-checkout-form]')
  const items = page.querySelector('[data-checkout-items]')
  const card = page.querySelector('[data-checkout-card]')
  const coupon = page.querySelector('[data-checkout-coupon]')
  const couponInput = page.querySelector('[data-checkout-coupon-input]')
  const couponStatus = page.querySelector('[data-checkout-coupon-status]')
  const empty = document.querySelector('[data-checkout-empty]')
  const done = document.querySelector('[data-checkout-done]')
  const set = (sel, text) => { page.querySelector(sel).textContent = text }
  const buyNow = buyNowItem()
  const order = buyNow ? { items: [buyNow], coupon: false } : cart
  const saveOrder = () => (order === cart ? saveCart() : render())

  if (buyNow) {
    const back = page.querySelector('.checkout__back')
    back.textContent = '‹ Back to product'
    back.href = window.PRODUCTS && window.PRODUCTS[buyNow.id] ? `product.html?p=${buyNow.id}` : 'our-shop.html'
  }

  function totals() {
    const subtotal = order.items.reduce((sum, item) => sum + item.price * item.qty, 0)
    const discount = order.coupon ? Math.round(subtotal * COUPON.rate) : 0
    const standard = subtotal - discount >= SHIPPING.freeFrom ? 0 : SHIPPING.standard
    const shipping = form.elements.shipping.value === 'express' ? SHIPPING.express : standard
    return { subtotal, discount, standard, shipping, total: subtotal - discount + shipping }
  }

  function render() {
    if (!done.hidden) return
    items.innerHTML = order.items.map((item) => `
      <li class="checkout-item">
        <span class="checkout-item__photo"><img src="${item.image}" alt=""><span class="checkout-item__qty">${item.qty}</span></span>
        <p class="checkout-item__name">${item.name}</p>
        <p class="checkout-item__price">${formatPrice(item.price * item.qty)}</p>
      </li>`).join('')
    const { subtotal, discount, standard, shipping, total } = totals()
    set('[data-shipping-standard]', standard ? formatPrice(standard) : 'Free')
    set('[data-checkout-subtotal]', formatPrice(subtotal))
    set('[data-checkout-discount]', `− ${formatPrice(discount)}`)
    page.querySelector('[data-checkout-discount-row]').hidden = !order.coupon
    set('[data-checkout-shipping]', shipping ? formatPrice(shipping) : 'Free')
    set('[data-checkout-total]', formatPrice(total))
    couponInput.value = order.coupon ? COUPON.code : couponInput.value
    coupon.classList.toggle('is-applied', order.coupon)
    page.hidden = order.items.length === 0
    empty.hidden = order.items.length > 0
    updateCartBadge()
  }

  function updatePayment() {
    const byCard = form.elements.payment.value === 'card'
    card.hidden = !byCard
    card.querySelectorAll('input').forEach((input) => { input.required = byCard })
  }

  form.addEventListener('change', (e) => {
    if (e.target.name === 'payment') updatePayment()
    if (e.target.name === 'shipping') render()
  })

  coupon.addEventListener('submit', (e) => {
    e.preventDefault()
    if (order.coupon) {
      order.coupon = false
      couponInput.value = ''
      couponStatus.textContent = 'Discount removed.'
    } else if (COUPON.code && couponInput.value.trim().toUpperCase() === COUPON.code) {
      order.coupon = true
      couponStatus.textContent = `${COUPON.code} applied: 10% off.`
    } else {
      couponStatus.textContent = 'That code isn\'t valid.'
      return
    }
    coupon.querySelector('[data-checkout-coupon-apply]').textContent = order.coupon ? 'Remove' : 'Apply'
    saveOrder() // the cart re-renders through cart:change
  })
  coupon.querySelector('[data-checkout-coupon-apply]').textContent = order.coupon ? 'Remove' : 'Apply'

  // The order as the store takes it: product ids and quantities (it prices them itself), the
  // coupon code, contact, address and the chosen options. Of a card only the last 4 digits go.
  function orderRequest() {
    const f = form.elements
    const value = (name) => f[name].value.trim()
    const chosen = (name) => form.querySelector(`input[name="${name}"]:checked`).closest('.checkout-option').querySelector('strong').textContent
    return {
      items: order.items.map(({ id, qty }) => ({ id, qty })),
      coupon: order.coupon ? COUPON.code : null,
      email: value('email'),
      phone: value('phone'),
      first_name: value('first-name'),
      last_name: value('last-name'),
      address: value('address'),
      address_2: value('address-2'),
      city: value('city'),
      state: value('state'),
      postal_code: value('postal-code'),
      country: value('country'),
      shipping: value('shipping'),
      shipping_label: chosen('shipping'),
      payment: value('payment'),
      payment_label: chosen('payment'),
      card_last4: value('payment') === 'card' ? value('card-number').replace(/\D/g, '').slice(-4) : null,
      note: order === cart ? cart.note : '',
    }
  }

  // Runs only once the browser's own validation passes. The store answers with the placed order,
  // which is kept in this browser too and its details page opened; if it can't be kept, the
  // thank-you message here is shown instead. A refusal (stock, coupon, a field) is shown above.
  const status = page.querySelector('[data-checkout-status]')
  const submit = form.querySelector('[type="submit"]')
  form.addEventListener('submit', async (e) => {
    e.preventDefault()
    if (submit.disabled) return
    submit.disabled = true
    status.textContent = ''
    let record
    try {
      record = (await api('api/orders', orderRequest())).order
    } catch (err) {
      status.textContent = err.message
      submit.disabled = false
      return
    }
    const { number } = record
    const saved = saveOrderRecord(record)
    if (!saved) {
      done.querySelector('[data-checkout-order-number]').textContent = `#${number}`
      done.querySelector('[data-checkout-order-email]').textContent = form.elements.email.value
      page.hidden = true
      done.hidden = false
    }
    if (buyNow) {
      try { sessionStorage.removeItem(BUY_NOW_KEY) } catch {}
    } else {
      cart.items = []
      cart.coupon = false
      cart.note = ''
      saveCart()
      updateCartBadge()
    }
    if (saved) {
      location.href = `order-details.html?order=${number}`
      return
    }
    done.focus({ preventScroll: true })
    window.scrollTo({ top: 0, behavior: 'smooth' })
  })

  document.addEventListener('cart:change', render)
  updatePayment()
  render()
}

const checkoutPage = document.querySelector('[data-checkout]')
if (checkoutPage) initCheckout(checkoutPage)

// Order details page (order-details.html?order=<number>, opened after Place Order; no number:
// the latest order). Shows the order: confirmation, delivery progress (placed today; delivery
// expected in 7 days, or 3 by express), items, totals, contact, address and payment. The store's
// copy comes first (it shows an order to the shopper who placed it), else the one saved here.
// Text the shopper typed is escaped before it goes into the page.
const escapeHtml = (text) => String(text).replace(/[&<>"']/g, (c) => `&#${c.charCodeAt(0)};`)
const formatDate = (date) => date.toLocaleDateString('en-IN', { day: 'numeric', month: 'short', year: 'numeric' })

async function initOrderPage(page) {
  const number = new URLSearchParams(location.search).get('order')
  const orders = loadOrders()
  let record = null
  if (number) {
    try { record = (await api(`api/orders/${encodeURIComponent(number)}`)).order } catch {}
  }
  // The PDF invoice comes from the store, so it's offered only for an order the store showed.
  const fromStore = Boolean(record)
  record = record || (number ? orders.find((o) => o.number === number) : orders[0])
  const missing = document.querySelector('[data-order-missing]')
  if (!record) {
    page.hidden = true
    missing.hidden = false
    return
  }
  const set = (sel, text) => { page.querySelector(sel).textContent = text }
  const placed = new Date(record.date)
  const arrives = new Date(placed)
  arrives.setDate(arrives.getDate() + (record.shippingMethod === 'express' ? 3 : 7))
  const a = record.address

  set('[data-order-greeting]', `Thank you, ${a.name.split(' ')[0]}!`)
  set('[data-order-number]', `#${record.number}`)
  set('[data-order-date]', formatDate(placed))
  set('[data-order-email]', record.contact.email)
  set('[data-order-placed]', formatDate(placed))
  set('[data-order-arrives]', `Expected by ${formatDate(arrives)}`)
  page.querySelector('[data-order-items]').innerHTML = record.items.map((item) => `
    <li class="checkout-item">
      <span class="checkout-item__photo"><img src="${escapeHtml(item.image)}" alt=""><span class="checkout-item__qty">${item.qty}</span></span>
      <p class="checkout-item__name">${escapeHtml(item.name)}<span class="order-item__unit">${formatPrice(item.price)} × ${item.qty}</span></p>
      <p class="checkout-item__price">${formatPrice(item.price * item.qty)}</p>
    </li>`).join('')
  set('[data-order-subtotal]', formatPrice(record.subtotal))
  page.querySelector('[data-order-discount-row]').hidden = !record.discount
  set('[data-order-discount-label]', `Discount (${record.coupon})`)
  set('[data-order-discount]', `− ${formatPrice(record.discount)}`)
  set('[data-order-shipping]', record.shipping ? formatPrice(record.shipping) : 'Free')
  set('[data-order-total]', formatPrice(record.total))
  page.querySelector('[data-order-contact]').innerHTML = `${escapeHtml(record.contact.email)}<br>${escapeHtml(record.contact.phone)}`
  page.querySelector('[data-order-address]').innerHTML = [a.name, a.line1, a.line2, `${a.city}, ${a.state} ${a.postalCode}`, a.country]
    .filter(Boolean).map(escapeHtml).join('<br>')
  set('[data-order-shipping-method]', record.shippingLabel)
  set('[data-order-payment]', record.payment)
  document.title = `Mighty Silks — Order #${record.number}`

  page.querySelector('[data-order-print]').addEventListener('click', () => window.print())
  const invoice = page.querySelector('[data-order-invoice]')
  invoice.hidden = !fromStore
  invoice.href = `orders/${encodeURIComponent(record.number)}/invoice`
}

const orderPage = document.querySelector('[data-order-page]')
if (orderPage) initOrderPage(orderPage)

// Track your order (track-order.html): the store finds the order by its number (with or without
// #, any case) and the email or phone used at checkout, and its progress shows. Progress is the
// order's status as the store team sets it (Admin › Orders); an order without one follows its
// date: packed after a day, shipped after two, delivered by the expected date (3 days express, 7
// standard; as order-details.html). Recent orders placed in this browser are offered as shortcuts.
// done: days after ordering the step is complete (null: the expected delivery day). status: the
// heading while this step is the next one to happen.
const TRACK_STEPS = [
  { name: 'Order Placed', status: 'Order placed', done: 0 },
  { name: 'Packed', status: 'Being packed', done: 1 },
  { name: 'Shipped', status: 'Packed and ready to ship', done: 2 },
  { name: 'Delivered', status: 'On its way', done: null },
]
// How many of TRACK_STEPS each store status has completed.
const STATUS_STEPS = { placed: 1, packed: 2, shipped: 3, delivered: 4, cancelled: 1 }

function initTrackOrder(form) {
  const status = form.querySelector('[data-track-status]')
  const result = document.querySelector('[data-track-result]')
  const set = (sel, text) => { result.querySelector(sel).textContent = text }

  function show(record) {
    const placed = new Date(record.date)
    const days = Math.floor((Date.now() - placed) / 86400000)
    const total = record.shippingMethod === 'express' ? 3 : 7
    const arrives = new Date(placed)
    arrives.setDate(arrives.getDate() + total)
    const steps = STATUS_STEPS[record.status]
    const isDone = (step, i) => (steps === undefined ? days >= (step.done ?? total) : i < steps)
    const current = TRACK_STEPS.findIndex((step, i) => !isDone(step, i)) // -1: delivered
    const cancelled = record.status === 'cancelled'

    set('[data-track-number]', `#${record.number}`)
    set('[data-track-status-title]', cancelled ? 'Cancelled' : current === -1 ? 'Delivered' : TRACK_STEPS[current].status)
    set('[data-track-eta]', cancelled ? 'This order was cancelled. Any payment will be refunded.' : current === -1 ? `Delivered on ${formatDate(arrives)}` : `Expected by ${formatDate(arrives)}`)
    result.querySelector('[data-track-details]').href = `order-details.html?order=${encodeURIComponent(record.number)}`
    result.querySelector('[data-track-steps]').innerHTML = TRACK_STEPS.map((step, i) => {
      const when = i === 0 ? formatDate(placed) : step.done === null ? formatDate(arrives) : ''
      const state = isDone(step, i) ? ' is-done' : i === current && !cancelled ? ' is-current' : ''
      return `<li class="order-step${state}"${i === current ? ' aria-current="step"' : ''}><span class="order-step__dot" aria-hidden="true"></span><strong>${step.name}</strong><small>${when}</small></li>`
    }).join('')
    const count = record.items.reduce((sum, item) => sum + item.qty, 0)
    result.querySelector('[data-track-items]').innerHTML = record.items.slice(0, 4)
      .map((item) => `<img src="${escapeHtml(item.image)}" alt="${escapeHtml(item.name)}">`).join('') +
      `<span>${count} item${count === 1 ? '' : 's'}</span>`
    set('[data-track-shipping]', record.shippingLabel)
    set('[data-track-address]', `${record.address.name}, ${record.address.city}, ${record.address.state}`)
    result.hidden = false
    result.focus({ preventScroll: true })
    result.scrollIntoView({ behavior: window.matchMedia('(prefers-reduced-motion: reduce)').matches ? 'auto' : 'smooth', block: 'start' })
  }

  form.addEventListener('submit', async (e) => {
    e.preventDefault()
    const { order, contact } = form.elements
    status.textContent = ''
    if (!order.value.trim()) { status.textContent = 'Enter your order number.'; order.focus(); return }
    if (!contact.value.trim()) { status.textContent = 'Enter the email or phone number used for the order.'; contact.focus(); return }
    let record
    try {
      record = (await api('api/orders/track', { order: order.value.trim(), contact: contact.value.trim() })).order
    } catch (err) {
      result.hidden = true
      status.textContent = err.message
      return
    }
    show(record)
  })

  // Recent orders on this device: one click fills the form and tracks (with the store's status).
  const recent = loadOrders().slice(0, 3)
  if (recent.length) {
    document.querySelector('[data-track-recent]').hidden = false
    const list = document.querySelector('[data-track-recent-list]')
    list.innerHTML = recent.map((o, i) => `<button class="track__chip" type="button" data-i="${i}">#${escapeHtml(o.number)}<small>${formatDate(new Date(o.date))}</small></button>`).join('')
    list.addEventListener('click', (e) => {
      const chip = e.target.closest('[data-i]')
      if (!chip) return
      const o = recent[chip.dataset.i]
      form.elements.order.value = o.number
      form.elements.contact.value = o.contact.email
      form.requestSubmit()
    })
  }
}

const trackForm = document.querySelector('[data-track-form]')
if (trackForm) initTrackOrder(trackForm)

// Login page (login.html). Two ways in, chosen by the tabs: email + password, or phone number +
// one-time code (Send Code, then Verify & Log In). The store checks either and signs the shopper
// in (Remember me keeps them signed in), then goes home (an admin: to the admin panel). With no
// SMS provider set up, the store writes the code to its log (and, in debug mode, says it here).

// Password eye buttons (login.html, signup.html): show or hide the password beside them.
document.querySelectorAll('[data-login-show]').forEach((show) => {
  const password = show.closest('.login__password').querySelector('input')
  show.addEventListener('click', () => {
    const visible = password.type === 'password'
    password.type = visible ? 'text' : 'password'
    show.setAttribute('aria-label', visible ? 'Hide password' : 'Show password')
    show.setAttribute('aria-pressed', String(visible)) // CSS swaps the eye icon
  })
})

function initLogin(page) {
  const form = page.querySelector('[data-login-form]')
  const password = page.querySelector('[data-login-password]')
  const status = page.querySelector('[data-login-status]')
  const submit = page.querySelector('[data-login-submit]')
  const otpBox = page.querySelector('[data-login-otp]')
  let mode = 'email'

  const say = (text, ok = false) => {
    status.textContent = text
    status.classList.toggle('is-success', ok)
  }
  const fail = (text, field) => { say(text); field.focus() }

  function setMode(next) {
    mode = next
    page.querySelectorAll('[data-login-tab]').forEach((tab) => {
      tab.setAttribute('aria-selected', String(tab.dataset.loginTab === mode))
    })
    page.querySelectorAll('[data-login-panel]').forEach((panel) => { panel.hidden = panel.dataset.loginPanel !== mode })
    page.querySelector('[data-login-forgot]').hidden = mode !== 'email'
    otpBox.hidden = true
    submit.textContent = mode === 'email' ? 'Log In' : 'Send Code'
    say('')
  }
  page.querySelectorAll('[data-login-tab]').forEach((tab) => {
    tab.addEventListener('click', () => setMode(tab.dataset.loginTab))
  })

  // A new number needs a new code.
  form.elements.phone.addEventListener('input', () => {
    if (otpBox.hidden) return
    otpBox.hidden = true
    submit.textContent = 'Send Code'
  })

  const fullPhone = () => `${form.elements['country-code'].value} ${form.elements.phone.value.trim()}`

  async function sendCode() {
    const { phone } = form.elements
    phone.value = phone.value.trim()
    if (!phone.value || !phone.validity.valid) return fail('Enter a valid phone number.', phone)
    let sent
    try {
      sent = await api('api/login/code', { phone: fullPhone() })
    } catch (err) {
      return fail(err.message, phone)
    }
    otpBox.hidden = false
    form.elements.otp.value = ''
    form.elements.otp.focus()
    submit.textContent = 'Verify & Log In'
    say(`We've sent a 6-digit code to ${fullPhone()}.${sent.debug_code ? ` (Test mode: ${sent.debug_code})` : ''}`, true)
  }
  page.querySelector('[data-login-resend]').addEventListener('click', sendCode)


  // Google / Apple sign-in need a provider account set up; until then, say so.
  page.querySelectorAll('[data-login-social]').forEach((btn) => {
    btn.addEventListener('click', () => {
      say(`${btn.dataset.loginSocial} sign-in isn't available yet. Please log in with your email or phone.`)
    })
  })

  form.addEventListener('submit', async (e) => {
    e.preventDefault()
    const { email, otp, remember } = form.elements
    let request
    if (mode === 'email') {
      if (!email.value.trim() || !email.validity.valid) return fail('Enter a valid email address.', email)
      if (!password.value || !password.validity.valid) return fail('Enter your password (at least 6 characters).', password)
      request = api('api/login', { email: email.value.trim(), password: password.value, remember: remember.checked })
    } else {
      if (otpBox.hidden) return sendCode()
      if (!/^\d{6}$/.test(otp.value.trim())) return fail('Enter the 6-digit code we sent you.', otp)
      request = api('api/login/verify', { phone: fullPhone(), otp: otp.value.trim(), remember: remember.checked })
    }
    submit.disabled = true
    let signedIn
    try {
      signedIn = await request
    } catch (err) {
      submit.disabled = false
      return fail(err.message, mode === 'email' ? password : otp)
    }
    say(`Logged in. Taking you to ${signedIn.admin ? 'the admin panel' : 'the home page'}…`, true)
    setTimeout(() => { location.href = signedIn.redirect }, 800)
  })
}

const loginPage = document.querySelector('[data-login]')
if (loginPage) initLogin(loginPage)

// Create account page (signup.html), in two steps. 1: checks the fields (passwords match, terms
// accepted) and the store emails a 6-digit code; no account exists yet. 2: the shopper enters the
// code (Resend code sends a new one) and only then the store creates the account (newsletter
// ticked: subscribes too), signs the shopper in, and it goes home. Editing a field after the code
// was sent starts again from step 1.
function initSignup(page) {
  const form = page.querySelector('[data-signup-form]')
  const status = page.querySelector('[data-login-status]')
  const submit = page.querySelector('[data-signup-submit]')
  const otpBox = page.querySelector('[data-signup-otp]')
  const f = form.elements
  const value = (name) => f[name].value.trim()
  const say = (text, ok = false) => {
    status.textContent = text
    status.classList.toggle('is-success', ok)
  }
  const fail = (text, field) => { say(text); field.focus() }

  page.querySelectorAll('[data-login-social]').forEach((btn) => {
    btn.addEventListener('click', () => {
      say(`${btn.dataset.loginSocial} sign-up isn't available yet. Please fill in the form.`)
    })
  })

  const reset = () => {
    if (otpBox.hidden) return
    otpBox.hidden = true
    submit.textContent = 'Create Account'
    say('')
  }
  form.querySelectorAll('input:not([name="otp"]), select').forEach((field) => {
    field.addEventListener('input', reset)
    field.addEventListener('change', reset)
  })

  async function sendCode() {
    if (!value('first-name')) return fail('Enter your first name.', f['first-name'])
    if (!value('last-name')) return fail('Enter your last name.', f['last-name'])
    if (!value('email') || !f.email.validity.valid) return fail('Enter a valid email address.', f.email)
    if (!value('phone') || !f.phone.validity.valid) return fail('Enter a valid phone number.', f.phone)
    if (!f.password.value || !f.password.validity.valid) return fail('Choose a password of at least 6 characters.', f.password)
    if (f['password-confirm'].value !== f.password.value) return fail('The passwords don\'t match.', f['password-confirm'])
    if (!f.terms.checked) return fail('Please accept the Terms & Conditions and Privacy Policy.', f.terms)
    submit.disabled = true
    say('Sending your verification code…', true)
    let sent
    try {
      sent = await api('api/register', {
        first_name: value('first-name'),
        last_name: value('last-name'),
        email: value('email'),
        phone: `${f['country-code'].value} ${value('phone')}`,
        password: f.password.value,
        newsletter: f.newsletter.checked,
      })
    } catch (err) {
      return say(err.message)
    } finally {
      submit.disabled = false
    }
    otpBox.hidden = false
    f.otp.value = ''
    f.otp.focus()
    submit.textContent = 'Verify & Create Account'
    say(`We've emailed a 6-digit code to ${value('email')}. Enter it to finish creating your account.${sent.debug_code ? ` (Test mode: ${sent.debug_code})` : ''}`, true)
  }
  page.querySelector('[data-signup-resend]').addEventListener('click', sendCode)

  form.addEventListener('submit', async (e) => {
    e.preventDefault()
    if (otpBox.hidden) return sendCode()
    if (!/^\d{6}$/.test(value('otp'))) return fail('Enter the 6-digit code we emailed you.', f.otp)
    submit.disabled = true
    try {
      await api('api/register/verify', { email: value('email'), otp: value('otp') })
    } catch (err) {
      submit.disabled = false
      return fail(err.message, f.otp)
    }
    say(`Welcome, ${value('first-name')}! Your account is ready. Taking you to the home page…`, true)
    setTimeout(() => { location.href = 'index.html' }, 1200)
  })
}

const signupPage = document.querySelector('[data-signup]')
if (signupPage) initSignup(signupPage)

// Career details page (career-details.html?job=<slug>): fills the write-up, overview card and title
// from js/jobs.js (no slug: the first role), chooses the role in the form and lists the others.
// A slug that isn't there shows "This role has closed" and hides the form.
function initJobPage(page) {
  const jobs = window.JOBS || {}
  const slugs = Object.keys(jobs)
  const slug = new URLSearchParams(location.search).get('job') || slugs[0]
  const job = jobs[slug]
  const set = (sel, text) => { page.querySelector(sel).textContent = text }
  const list = (sel, items) => {
    page.querySelector(sel).innerHTML = items.map((item) => `<li>${escapeHtml(item)}</li>`).join('')
  }

  if (!job) {
    page.querySelector('[data-job-content]').hidden = true
    page.querySelector('[data-job-missing]').hidden = false
    set('[data-job-crumb]', 'Closed role')
    document.querySelector('[data-job-apply]').hidden = true
  } else {
    set('[data-job-crumb]', job.title)
    set('[data-job-title]', job.title)
    list('[data-job-tags]', [job.department, job.location, job.type, job.experience])
    set('[data-job-summary]', job.summary)
    list('[data-job-responsibilities]', job.responsibilities)
    list('[data-job-requirements]', job.requirements)
    list('[data-job-offer]', job.offer || window.JOB_OFFER || [])
    set('[data-job-department]', job.department)
    set('[data-job-location]', job.location)
    set('[data-job-type]', job.type)
    set('[data-job-experience]', job.experience)
    page.querySelector('[data-careers-apply]').dataset.careersApply = job.title
    const position = document.querySelector('[data-careers-position]')
    if (position) position.value = job.title
    document.title = `Mighty Silks — ${job.title}`
  }

  const others = slugs.filter((s) => s !== slug)
  document.querySelector('[data-job-others-section]').hidden = others.length === 0
  document.querySelector('[data-job-others]').innerHTML = others.map((s) => {
    const o = jobs[s]
    return `
      <li><a class="job-other" href="career-details.html?job=${encodeURIComponent(s)}">
        <span class="job-other__title">${escapeHtml(o.title)}</span>
        <span class="job-other__meta">${escapeHtml(o.location)} · ${escapeHtml(o.type)}</span>
        <span class="job-other__more">View Details <span aria-hidden="true">→</span></span>
      </a></li>`
  }).join('')
}

const jobPage = document.querySelector('[data-job-page]')
if (jobPage) initJobPage(jobPage)

// Careers page (careers.html). A role's Apply Now picks that role in the form and moves to it; the
// form checks its fields and the CV (PDF or Word, up to 5 MB), sends the application (with the CV)
// to the store, then thanks the applicant and resets.
const CV_MAX_BYTES = 5 * 1024 * 1024

function initCareers(form) {
  const section = form.closest('.careers-apply')
  const position = form.querySelector('[data-careers-position]')
  const status = form.querySelector('[data-careers-status]')
  const say = (text, ok = false) => {
    status.textContent = text
    status.classList.toggle('is-success', ok)
  }
  const fail = (text, field) => { say(text); field.focus() }

  document.querySelectorAll('[data-careers-apply]').forEach((btn) => {
    btn.addEventListener('click', () => {
      position.value = btn.dataset.careersApply
      say('')
      section.scrollIntoView({ behavior: window.matchMedia('(prefers-reduced-motion: reduce)').matches ? 'auto' : 'smooth' })
      form.elements.name.focus({ preventScroll: true })
    })
  })

  form.addEventListener('submit', async (e) => {
    e.preventDefault()
    const f = form.elements
    if (!f.name.value.trim()) return fail('Enter your full name.', f.name)
    if (!f.email.value.trim() || !f.email.validity.valid) return fail('Enter a valid email address.', f.email)
    if (!f.phone.value.trim() || !f.phone.validity.valid) return fail('Enter a valid phone number.', f.phone)
    if (!position.value) return fail('Choose the position you\'re applying for.', position)
    const cv = f.cv.files[0]
    if (!cv) return fail('Attach your CV.', f.cv)
    if (!/\.(pdf|docx?)$/i.test(cv.name)) return fail('Your CV should be a PDF or Word file.', f.cv)
    if (cv.size > CV_MAX_BYTES) return fail('Your CV is larger than 5 MB. Please attach a smaller file.', f.cv)
    say('Sending your application…', true)
    try {
      await api('api/careers', new FormData(form))
    } catch (err) {
      return say(err.message)
    }
    const first = f.name.value.trim().split(/\s+/)[0]
    form.reset()
    say(`Thank you, ${first}! We've received your application and will be in touch.`, true)
  })
}

const careersForm = document.querySelector('[data-careers-form]')
if (careersForm) initCareers(careersForm)

// Corporate & bulk enquiry (corporate-bulk.html): checks the fields (at least 10 pieces), sends
// the enquiry to the store (Admin › Enquiries), then thanks the sender and resets.
function initBulkEnquiry(form) {
  const status = form.querySelector('[data-bulk-status]')
  const say = (text, ok = false) => {
    status.textContent = text
    status.classList.toggle('is-success', ok)
  }
  const fail = (text, field) => { say(text); field.focus() }

  form.addEventListener('submit', async (e) => {
    e.preventDefault()
    const f = form.elements
    if (!f.name.value.trim()) return fail('Enter your full name.', f.name)
    if (!f.email.value.trim() || !f.email.validity.valid) return fail('Enter a valid email address.', f.email)
    if (!f.phone.value.trim() || !f.phone.validity.valid) return fail('Enter a valid phone number.', f.phone)
    if (!f.type.value) return fail('Choose the type of order.', f.type)
    if (!f.quantity.value || !f.quantity.validity.valid) return fail('Enter a quantity of at least 10 pieces.', f.quantity)
    try {
      await api('api/enquiries', Object.fromEntries(new FormData(form)))
    } catch (err) {
      return say(err.message)
    }
    const first = f.name.value.trim().split(/\s+/)[0]
    form.reset()
    say(`Thank you, ${first}! We've received your enquiry and our corporate team will be in touch with a quote.`, true)
  })
}

const bulkForm = document.querySelector('[data-bulk-form]')
if (bulkForm) initBulkEnquiry(bulkForm)

// Contact form (contact.html): checks the fields, sends the message to the store (Admin ›
// Enquiries), then opens the thank-you page.
function initContact(form) {
  const status = form.querySelector('[data-contact-status]')
  const say = (text, ok = false) => {
    status.textContent = text
    status.classList.toggle('is-success', ok)
  }
  const fail = (text, field) => { say(text); field.focus() }

  form.addEventListener('submit', async (e) => {
    e.preventDefault()
    const f = form.elements
    if (!f.name.value.trim()) return fail('Enter your full name.', f.name)
    if (!f.email.value.trim() || !f.email.validity.valid) return fail('Enter a valid email address.', f.email)
    if (f.phone.value.trim() && !f.phone.validity.valid) return fail('Enter a valid phone number.', f.phone)
    if (!f.subject.value) return fail('Choose what your message is about.', f.subject)
    if (!f.message.value.trim()) return fail('Write your message.', f.message)
    say('Sending your message…', true)
    try {
      await api('api/contact', Object.fromEntries(new FormData(form)))
    } catch (err) {
      return say(err.message)
    }
    location.href = 'thank-you.html'
  })
}

const contactForm = document.querySelector('[data-contact-form]')
if (contactForm) initContact(contactForm)

// Blog details page (blog-details.html?post=<slug>): fills the article from js/blogs.js (no slug:
// the first post), its Shop the Look link, share links, previous / next stories and up to three
// related stories (same category first). A slug that isn't there shows "Story not found".
const MONTHS = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
const postDate = (iso) => { // "15 Sep 2026", as blog.html writes them (en-IN would give "Sept")
  const [y, m, d] = iso.split('-').map(Number)
  return `${d} ${MONTHS[m - 1]} ${y}`
}
const blogCard = (slug, post) => `
  <article class="blog-post">
    <a class="blog-post__media" href="blog-details.html?post=${encodeURIComponent(slug)}" tabindex="-1" aria-hidden="true"><img src="${escapeHtml(post.image)}" alt=""></a>
    <span class="blog-card__tag">${escapeHtml(post.tag)}</span>
    <p class="blog-post__meta"><time datetime="${post.date}">${postDate(post.date)}</time> · ${escapeHtml(post.readTime)}</p>
    <h3 class="blog-post__title"><a href="blog-details.html?post=${encodeURIComponent(slug)}">${escapeHtml(post.title)}</a></h3>
    <p class="blog-post__excerpt">${escapeHtml(post.excerpt)}</p>
    <a class="blog-post__more" href="blog-details.html?post=${encodeURIComponent(slug)}">Read More <span aria-hidden="true">→</span></a>
  </article>`

function initPostPage(page) {
  const posts = window.BLOGS || {}
  const slugs = Object.keys(posts)
  const slug = new URLSearchParams(location.search).get('post') || slugs[0]
  const post = posts[slug]
  const related = document.querySelector('[data-post-related-section]')

  if (!post) {
    page.querySelector('[data-post-content]').hidden = true
    page.querySelector('[data-post-missing]').hidden = false
    related.querySelector('[data-post-related]').innerHTML = slugs.slice(0, 3).map((s) => blogCard(s, posts[s])).join('')
    return
  }

  const set = (sel, text) => { page.querySelector(sel).textContent = text }
  set('[data-post-crumb]', post.tag)
  set('[data-post-tag]', post.tag)
  set('[data-post-title]', post.title)
  set('[data-post-read]', post.readTime)
  const date = page.querySelector('[data-post-date]')
  date.dateTime = post.date
  date.textContent = postDate(post.date)
  const image = page.querySelector('[data-post-image]')
  image.src = post.image
  image.alt = post.alt
  page.querySelector('[data-post-body]').innerHTML = post.body.map((block) => {
    if (block.h) return `<h2>${escapeHtml(block.h)}</h2>`
    if (block.list) return `<ul>${block.list.map((item) => `<li>${escapeHtml(item)}</li>`).join('')}</ul>`
    if (block.quote) return `<blockquote><p>“${escapeHtml(block.quote)}”</p></blockquote>`
    return `<p>${escapeHtml(block.p)}</p>`
  }).join('')
  const shop = page.querySelector('[data-post-shop]')
  if (post.shop) {
    shop.href = post.shop.href
    shop.textContent = post.shop.label
  }
  document.title = `Mighty Silks — ${post.title}`

  // Share: WhatsApp / Facebook / Pinterest share pages for this URL; the last button copies it.
  const url = encodeURIComponent(location.href)
  const text = encodeURIComponent(post.title)
  const shareUrls = {
    whatsapp: `https://wa.me/?text=${text}%20${url}`,
    facebook: `https://www.facebook.com/sharer/sharer.php?u=${url}`,
    pinterest: `https://www.pinterest.com/pin/create/button/?url=${url}&description=${text}`,
  }
  page.querySelectorAll('[data-share]').forEach((a) => { a.href = shareUrls[a.dataset.share] })
  const shareStatus = page.querySelector('[data-share-status]')
  page.querySelector('[data-share-copy]').addEventListener('click', async () => {
    try {
      await navigator.clipboard.writeText(location.href)
      shareStatus.textContent = 'Link copied!'
    } catch {
      shareStatus.textContent = 'Couldn\'t copy. Please copy the link from the address bar.'
    }
  })

  // Previous / next in the posts' order; the ends have only one.
  const i = slugs.indexOf(slug)
  const pager = (sel, s) => {
    const link = page.querySelector(sel)
    link.hidden = !s
    if (!s) return
    link.href = `blog-details.html?post=${encodeURIComponent(s)}`
    link.querySelector('.post__pager-title').textContent = posts[s].title
  }
  pager('[data-post-prev]', slugs[i - 1])
  pager('[data-post-next]', slugs[i + 1])

  // Related: every other post, same category first, in the home page's looping carousel (three
  // in view) when there are more than fit; reduced motion keeps the plain grid.
  const shares = (s) => posts[s].category.split(' ').some((c) => post.category.split(' ').includes(c))
  const others = slugs.filter((s) => s !== slug)
  const picks = [...others.filter(shares), ...others.filter((s) => !shares(s))]
  related.hidden = picks.length === 0
  const list = related.querySelector('[data-post-related]')
  list.innerHTML = picks.map((s) => blogCard(s, posts[s])).join('')
  if (picks.length > 3 && !window.matchMedia('(prefers-reduced-motion: reduce)').matches) initBlogCarousel(list)
}

const postPage = document.querySelector('[data-post-page]')
if (postPage) initPostPage(postPage)

// Blog page (blog.html): the category chips show only the posts tagged with that category
// (data-category, space-separated); All shows every post.
function initBlogFilters(group) {
  const posts = [...document.querySelectorAll('[data-blog-list] .blog-post')]
  const empty = document.querySelector('[data-blog-empty]')
  group.addEventListener('click', (e) => {
    const chip = e.target.closest('[data-blog-filter]')
    if (!chip) return
    const pick = chip.dataset.blogFilter
    group.querySelectorAll('[data-blog-filter]').forEach((c) => c.setAttribute('aria-pressed', String(c === chip)))
    let shown = 0
    posts.forEach((post) => {
      post.hidden = pick !== 'all' && !post.dataset.category.split(' ').includes(pick)
      if (!post.hidden) shown++
    })
    empty.hidden = shown > 0
  })
}

const blogFilters = document.querySelector('[data-blog-filters]')
if (blogFilters) initBlogFilters(blogFilters)

// Help center (help-center.html): the search box and topic cards filter the FAQs together. A
// question shows when it's in the chosen topic (or no topic is chosen) and contains every word
// typed; topics with nothing left are hidden. A search opens the matching answers.
function initHelpCenter(search) {
  const query = search.querySelector('[data-help-query]')
  const topics = [...document.querySelectorAll('[data-help-topic]')]
  const groups = [...document.querySelectorAll('[data-help-group]')]
  const empty = document.querySelector('[data-help-empty]')
  const clear = document.querySelector('[data-help-clear]')
  let topic = null

  function apply() {
    const words = query.value.toLowerCase().split(/\s+/).filter(Boolean)
    let shown = 0
    groups.forEach((group) => {
      let inGroup = 0
      group.querySelectorAll('.help-faq').forEach((faq) => {
        const text = faq.textContent.toLowerCase()
        const match = (!topic || group.dataset.helpGroup === topic) && words.every((w) => text.includes(w))
        faq.hidden = !match
        faq.open = match && words.length > 0
        if (match) inGroup++
      })
      group.hidden = inGroup === 0
      shown += inGroup
    })
    empty.hidden = shown > 0
    clear.hidden = !topic && words.length === 0
  }

  topics.forEach((card) => card.addEventListener('click', () => {
    topic = topic === card.dataset.helpTopic ? null : card.dataset.helpTopic // a second click shows all
    topics.forEach((c) => c.setAttribute('aria-pressed', String(c.dataset.helpTopic === topic)))
    apply()
    if (topic) document.querySelector('.help-faqs').scrollIntoView({ behavior: window.matchMedia('(prefers-reduced-motion: reduce)').matches ? 'auto' : 'smooth' })
  }))
  query.addEventListener('input', apply)
  search.addEventListener('submit', (e) => {
    e.preventDefault()
    document.querySelector('.help-faqs').scrollIntoView()
  })
  clear.addEventListener('click', () => {
    topic = null
    query.value = ''
    topics.forEach((c) => c.setAttribute('aria-pressed', 'false'))
    apply()
  })
}

const helpSearch = document.querySelector('[data-help-search]')
if (helpSearch) initHelpCenter(helpSearch)

// Policy pages (privacy-policy.html): the contents list marks the section being read (the last one
// whose heading has passed the top third of the screen).
function initPolicyToc(policy) {
  const links = [...policy.querySelectorAll('.policy__toc-list a')]
  const sections = links.map((a) => document.getElementById(a.hash.slice(1))).filter(Boolean)
  const mark = () => {
    const line = window.innerHeight / 3
    let current = sections[0]
    sections.forEach((s) => { if (s.getBoundingClientRect().top <= line) current = s })
    // At the very bottom the last sections may never reach the line: mark the last one.
    if (window.innerHeight + window.scrollY >= document.documentElement.scrollHeight - 2) current = sections[sections.length - 1]
    links.forEach((a) => a.setAttribute('aria-current', String(a.hash === `#${current.id}`)))
  }
  window.addEventListener('scroll', mark, { passive: true })
  window.addEventListener('resize', mark)
  mark()
}

const policy = document.querySelector('[data-policy]')
if (policy) initPolicyToc(policy)

// Newsletter sign-up (blog.html): checks the email, adds it to the store's subscribers (Admin ›
// Subscribers) and says thanks.
document.querySelectorAll('[data-newsletter-form]').forEach((form) => {
  const status = form.parentElement.querySelector('[data-newsletter-status]')
  form.addEventListener('submit', async (e) => {
    e.preventDefault()
    const { email } = form.elements
    if (!email.value.trim() || !email.validity.valid) {
      status.textContent = 'Please enter a valid email address.'
      email.focus()
      return
    }
    try {
      await api('api/subscribe', { email: email.value.trim(), source: 'blog' })
    } catch (err) {
      status.textContent = err.message
      return
    }
    form.reset()
    status.textContent = 'Thank you for subscribing! Look out for our next story in your inbox.'
  })
})

// Add to Cart / Buy Now (product cards' .btn-cart and Buy Now, the product page's [data-add-to-cart]).
// Add to Cart adds the product (or one more of it): the product page's then goes to the cart page
// (cart.html), the cards' slide the cart in. Buy Now leaves the cart alone and checks out just
// that product: the card's own name, price and shown photo are handed to checkout.html?buy=<id>
// (through sessionStorage). The product is identified by its catalogue id (the card's
// product.html?p= link, or the product page's own); without the catalogue the card's text and
// shown (captioned) photo are used.
const BUY_NOW = '[data-buy-now], .product__quick button'

function productFromCard(card) {
  const link = card.querySelector('.product__title a')
  const id = link ? new URLSearchParams(link.search).get('p') : new URLSearchParams(location.search).get('p') || 'na-3'
  const photo = card.querySelector('.pdp__photo, .product__photo:not(.product__photo--hover):not([alt=""])') || card.querySelector('.product__photo')
  return {
    id,
    name: card.querySelector('.product__title, .pdp__title').textContent.trim(),
    price: Number(card.querySelector('.product__price, .pdp__price').textContent.replace(/[^\d.]/g, '')),
    image: photo.getAttribute('src'),
  }
}

document.querySelectorAll(`.btn-cart, [data-add-to-cart], ${BUY_NOW}`).forEach((btn) => btn.addEventListener('click', () => {
  const product = productFromCard(btn.closest('.product, [data-product]'))
  if (btn.matches(BUY_NOW)) {
    try { sessionStorage.setItem(BUY_NOW_KEY, JSON.stringify({ ...product, qty: 1 })) } catch {}
    location.href = `checkout.html?buy=${encodeURIComponent(product.id)}`
    return
  }
  addToCart(catalogueItem(product.id) || product)
  if (btn.matches('[data-add-to-cart]')) location.href = 'cart.html'
  else if (cartDrawer) cartDrawer.open()
}))

// Hearts (product wishlist buttons and the header wishlist): clicking toggles a filled red heart
// (aria-pressed tracks the state) with a small pop.
const HEART_ICONS = [
  { outline: 'assets/icons/heart.svg', filled: 'assets/icons/heart-filled.svg' },
  { outline: 'assets/icons/nav-heart.svg', filled: 'assets/icons/nav-heart-filled.svg' },
  { outline: 'assets/icons/nav-heart-dark.svg', filled: 'assets/icons/nav-heart-filled.svg' },
  { outline: 'assets/product-detail/heart.svg', filled: 'assets/icons/heart-filled.svg' },
]
document.querySelectorAll('.btn-wish, .icon-btn[aria-label="Wishlist"], [data-wishlist]').forEach((btn) => {
  const img = btn.querySelector('img')
  const icon = HEART_ICONS.find((h) => img.getAttribute('src') === h.outline)
  if (!icon) return
  btn.setAttribute('aria-pressed', 'false')
  btn.addEventListener('click', () => {
    const on = btn.getAttribute('aria-pressed') !== 'true'
    btn.setAttribute('aria-pressed', String(on))
    img.src = on ? icon.filled : icon.outline
    if (on && !window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
      img.animate([{ transform: 'scale(1)' }, { transform: 'scale(1.35)' }, { transform: 'scale(1)' }], { duration: 350, easing: 'ease-out' })
    }
  })
})

// Product cards: a click on the photo (not on its buttons) opens the product, like the title link.
document.querySelectorAll('.product__media').forEach((media) => media.addEventListener('click', (e) => {
  if (e.target.closest('button, a')) return
  const link = media.closest('.product').querySelector('.product__title a')
  if (link && link.getAttribute('href') !== '#') location.href = link.href
}))

const sareeCarousel = document.querySelector('[data-carousel]')
if (sareeCarousel) initSareeCarousel(sareeCarousel)

// .pattern: product cards carry a data-pattern filter value too.
const patternCarousel = document.querySelector('.pattern[data-pattern]')
if (patternCarousel) initPatternCarousel(patternCarousel)
})()

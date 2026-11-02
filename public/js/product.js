// Product page (/product): the thumbnails switch the main photo, and the offer coupon copies
// its code. Classic script (loaded after js/main.js) so the page also works from file://.
(() => {

// Which product: /product?p=<id> (js/products.js), as linked from every product card. Without
// (or with an unknown) id the page keeps the organza saree it is written for. Runs first so the
// gallery and sliders below pick up the new photos and cards.
const productId = new URLSearchParams(location.search).get('p')
const product = window.PRODUCTS && window.PRODUCTS[productId]
if (product) renderProduct(product)
// The product itself isn't suggested under You May Also Like.
document.querySelectorAll('.slider--related .product').forEach((card) => {
  const link = card.querySelector('.product__title a')
  if (link && new URLSearchParams(link.search).get('p') === (product ? productId : 'na-3')) card.remove()
})

function renderProduct(item) {
  // "zari-brocade stripes" -> "Zari Brocade, Stripes"
  const label = (value) => value.split(' ').map((word) => word.split('-').map((w) => w[0].toUpperCase() + w.slice(1)).join(' ')).join(', ')
  const CATEGORY = { saree: 'Saree', 'ready-to-wear': 'Ready to Wear Saree', lacha: 'Lacha', dhawani: 'Dhawani Set', gown: 'Gown' }

  document.title = `Mighty Silks — ${item.title}`
  document.querySelector('[data-product-title]').textContent = item.title
  document.querySelector('[data-product-price]').textContent = item.price
  const sku = document.querySelector('[data-product-sku]')
  sku.hidden = !item.sku
  if (item.sku) sku.textContent = `SKU: ${item.sku}`

  // Gallery: the main photo fills its frame; one thumbnail per photo, the first selected.
  const main = document.querySelector('[data-gallery-main]')
  main.src = item.gallery[0]
  main.alt = item.alt
  main.removeAttribute('style')
  main.style.objectPosition = '50% 0'
  document.querySelector('[data-gallery-thumbs]').innerHTML = item.gallery.map((src, i) => `
    <button class="pdp__thumb${i === 0 ? ' is-active' : ''}" type="button" aria-label="Photo ${i + 1}" aria-pressed="${i === 0}" data-full="${src}"><img src="${src}" alt="" style="object-position:50% 0"></button>`).join('')

  // The admin's own text for a section, else one written from the shop filters.
  const detail = (key, text) => { document.querySelector(`[data-product-detail="${key}"]`).textContent = (item.details && item.details[key]) || text }
  detail('product', `${CATEGORY[item.category] || label(item.category)} in ${label(item.fabric).replace(/, /g, ' and ')}. Colour: ${label(item.color)}.${item.blouse === 'yes' ? ' Comes with a blouse piece.' : ''}`)
  detail('design', `Pattern: ${label(item.pattern)}. Ideal for ${label(item.occasion).toLowerCase().replace(/, /g, ' and ')} occasions.`)
  detail('care', `Fabric: ${label(item.fabric)}. Dry clean only. Store folded in a muslin cloth, away from direct sunlight.`)

  document.querySelector('[data-review-photo]').src = item.gallery[0]
  document.querySelector('[data-review-product]').textContent = item.title
}

// Gallery: the chosen thumbnail loses its white veil and its photo fades into the main frame.
// Thumbnails can carry the design crop for the main frame (data-x/y/w/h); the others fill it.
const gallery = document.querySelector('[data-gallery]')
if (gallery) {
  const main = gallery.querySelector('[data-gallery-main]')
  const thumbs = [...gallery.querySelectorAll('.pdp__thumb')]
  const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches
  const FADE_MS = 300 // matches the .pdp__photo transition

  function show(thumb) {
    thumbs.forEach((t) => {
      t.classList.toggle('is-active', t === thumb)
      t.setAttribute('aria-pressed', String(t === thumb))
    })
    const swap = () => {
      main.src = thumb.dataset.full
      for (const key of ['x', 'y', 'w', 'h']) {
        if (thumb.dataset[key]) main.style.setProperty(`--${key}`, thumb.dataset[key])
        else main.style.removeProperty(`--${key}`)
      }
      main.classList.remove('is-swapping')
    }
    if (reduceMotion) { swap(); return }
    main.classList.add('is-swapping')
    setTimeout(swap, FADE_MS)
  }

  thumbs.forEach((thumb) => thumb.addEventListener('click', () => {
    if (!thumb.classList.contains('is-active')) show(thumb)
  }))
}

// Card sliders (You May Also Like, testimonials): the arrows scroll the track to the previous /
// next card (snapped by CSS) and fade out at either end. Positions are measured on the cards
// themselves so the steps stay right on the zoomed desktop frame and the fluid layouts alike.
function initSlider(slider) {
  const track = slider.querySelector('[data-slider-track]')
  const prev = slider.querySelector('[data-slider-prev]')
  const next = slider.querySelector('[data-slider-next]')
  const cards = [...track.children]
  const offsetOf = (card) => card.offsetLeft - cards[0].offsetLeft

  // Index of the card at (or just past) the left edge of the track.
  function currentIndex() {
    const left = track.scrollLeft
    let index = 0
    cards.forEach((card, i) => { if (offsetOf(card) <= left + 2) index = i })
    return index
  }
  function update() {
    const max = track.scrollWidth - track.clientWidth
    prev.disabled = track.scrollLeft <= 2
    next.disabled = track.scrollLeft >= max - 2
  }
  function go(step) {
    const target = cards[Math.max(0, Math.min(cards.length - 1, currentIndex() + step))]
    track.scrollTo({ left: offsetOf(target) })
  }

  // Auto-slide every AUTO_MS while on screen, pausing while hovered/focused or while the tab is
  // hidden; from the last card it glides back to the first. Arrows restart the timer.
  const AUTO_MS = 3500
  const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches
  let timer = null
  let paused = false
  let onScreen = false
  new IntersectionObserver(([entry]) => { onScreen = entry.isIntersecting }, { threshold: 0.4 }).observe(slider)
  const atEnd = () => track.scrollLeft >= track.scrollWidth - track.clientWidth - 2
  const restart = () => {
    clearInterval(timer)
    if (reduceMotion) return
    timer = setInterval(() => {
      if (paused || !onScreen || document.hidden) return
      if (atEnd()) track.scrollTo({ left: 0 })
      else go(1)
    }, AUTO_MS)
  }
  slider.addEventListener('pointerenter', () => { paused = true })
  slider.addEventListener('pointerleave', () => { paused = false })
  slider.addEventListener('focusin', () => { paused = true })
  slider.addEventListener('focusout', () => { paused = false })

  prev.addEventListener('click', () => { go(-1); restart() })
  next.addEventListener('click', () => { go(1); restart() })
  track.addEventListener('scroll', update, { passive: true })
  window.addEventListener('resize', update)
  update()
  restart()
}
document.querySelectorAll('[data-slider]').forEach(initSlider)

// Review pop-up: Write a Review opens it (fresh each time). Hovering the stars previews a rating;
// choosing one fills the stars up to it and shows the comment fields. Sending checks the
// rating, review and name, sends the review to the store (it shows once approved in Admin ›
// Reviews), then shows the thank-you note.
const reviewDialog = document.getElementById('review-dialog')
const reviewButton = document.querySelector('[data-write-review]')
if (reviewDialog && reviewButton) {
  const form = reviewDialog.querySelector('[data-review-form]')
  const fields = reviewDialog.querySelector('[data-review-fields]')
  const thanks = reviewDialog.querySelector('[data-review-thanks]')
  const error = reviewDialog.querySelector('[data-review-error]')
  const stars = [...reviewDialog.querySelectorAll('.review-star')]
  const rating = () => Number(form.elements.rating.value) || 0
  const paint = (value) => stars.forEach((star, i) => star.classList.toggle('is-on', i < value))

  function open() {
    form.reset()
    paint(0)
    fields.hidden = true
    form.hidden = false
    thanks.hidden = true
    error.textContent = ''
    reviewDialog.showModal()
    document.documentElement.classList.add('review-locked')
  }

  stars.forEach((star, i) => {
    star.addEventListener('pointerenter', () => paint(i + 1))
    star.addEventListener('pointerleave', () => paint(rating()))
  })
  form.addEventListener('change', (e) => {
    if (e.target.name !== 'rating') return
    paint(rating())
    if (fields.hidden) {
      fields.hidden = false
      fields.scrollIntoView({ behavior: 'smooth', block: 'nearest' })
    }
  })
  form.addEventListener('submit', async (e) => {
    e.preventDefault()
    const missing = !rating() ? 'Please choose a star rating.'
      : !form.elements.review.value.trim() ? 'Please write a few words about the product.'
      : !form.elements.name.value.trim() ? 'Please add your name.'
      : ''
    error.textContent = missing
    if (missing) return
    try {
      await window.shopApi('api/reviews', {
        product: product ? productId : 'na-3',
        rating: rating(),
        title: form.elements.title.value.trim(),
        review: form.elements.review.value.trim(),
        name: form.elements.name.value.trim(),
      })
    } catch (err) {
      error.textContent = err.message
      return
    }
    form.hidden = true
    thanks.hidden = false
    thanks.querySelector('button').focus()
  })

  reviewButton.addEventListener('click', open)
  reviewDialog.querySelectorAll('[data-review-close]').forEach((btn) => btn.addEventListener('click', () => reviewDialog.close()))
  // A click on the backdrop (outside the dialog box) closes it.
  reviewDialog.addEventListener('click', (e) => {
    const r = reviewDialog.getBoundingClientRect()
    if (e.target === reviewDialog && (e.clientX < r.left || e.clientX > r.right || e.clientY < r.top || e.clientY > r.bottom)) reviewDialog.close()
  })
  reviewDialog.addEventListener('close', () => {
    document.documentElement.classList.remove('review-locked')
    reviewButton.focus({ preventScroll: true })
  })
}

// Offer coupon: copies the code and says so next to the coupon for a moment.
document.querySelectorAll('[data-copy-code]').forEach((btn) => {
  const status = btn.querySelector('[data-copy-status]')
  let timer = null
  btn.addEventListener('click', async () => {
    const code = btn.dataset.copyCode
    try {
      await navigator.clipboard.writeText(code)
      status.textContent = `Code ${code} copied`
    } catch {
      status.textContent = `Use code ${code} at checkout`
    }
    clearTimeout(timer)
    timer = setTimeout(() => { status.textContent = '' }, 2500)
  })
})

})()

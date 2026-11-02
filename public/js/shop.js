// Our Shop (/our-shop), New Arrivals (/new-arrivals, the same page with only the cards
// marked data-new), Bridal (/bridal, only the wedding / bridal cards, gowns first) and Sarees
// (/sarees, the saree and ready-to-wear cards), Mighty Signature (/mighty-signature, the
// Kalyan Signature collection, ks-1 – ks-12) and Gowns (/gown, the Mahalekshmi Bridal Gowns
// collection: mg-1 – mg-11 plus bg-1 – bg-4), Lahanga (/lahanga, the Mahalekshmi Bridal
// Lehengas collection, ml-1 – ml-6) and Ready to Wear (/ready-to-wear, the Mahalekshmi Ready to
// Wear Sarees collection: mr-1 – mr-35 plus rtw-1 – rtw-4) and Christmas Collections
// (/christmas, the first 12 of the Kalyan Christmas collection, kc-1 – kc-12) and Diwali
// Collections (/diwali, the first 12 of the Kalyan Diwali Sarees collection, kd-1 – kd-12) and
// Dussehra Collections (/dussehra, the first 12 of the Kalyan Dussera collection: du-1 – du-9
// plus kc-8, ks-4, kd-11) and Navaratri Collections (/navaratri, the first 12 of the Kalyan
// Navratri Sarees collection: nv-1 – nv-10 plus kc-4, kc-6) and Brocade Sarees (/pattern, the
// Kalyan Brocade Art Silk Sarees collection: kb-1 – kb-18 plus du-2, nv-5, kd-1, kd-3, kd-6, kd-8) and
// Kanchipuram Silk Sarees (/kanchipuram-silk-sarees, the Mahalekshmi collection: mk-1 – mk-40) and
// Semi Silk Sarees (/semi-silk-sarees, the Mahalekshmi collection: mss-1 – mss-8) and Kerala
// Sarees (/kerala-sarees, the Mahalekshmi collection: mke-1 – mke-36) and Pure Silk Sarees
// (/pure-silk-sarees, the Mahalekshmi Silk Saree collection: mps-1 – mps-40) and Unstitched
// Salwar Suits (/unstitched-salwar-suits, the Mahalekshmi collection: mus-1 – mus-18) and Organza
// Sarees (/organza-sarees, the Mahalekshmi collection: mor-1 – mor-40) and Dhawani Collection
// (/dhawani-collection, the site's dhavani sets dh-1 – dh-4) and Designer Sarees
// (/designer-sarees, the Mahalekshmi collection: mds-1 – mds-4) and Frocks Collection
// (/frocks-collection, the Mahalekshmi Frocks collection: mfr-1) and Banarasi Georgette Sarees
// (/banarasi-georgette-sarees, the Mahalekshmi collection: mbg-1 – mbg-50) and Fancy Sarees
// (/fancy-sarees, the Mahalekshmi collection: mfs-1 – mfs-13) and Semi Banarasi Sarees
// (/semi-banarasi-sarees, the Mahalekshmi collection: msb-1 – msb-6) and Bridal Sarees
// (/bridal-sarees, the Mahalekshmi collection: mbs-1 – mbs-40):
// the Price / Color / Pattern drop-downs
// and the Filters drawer filter the
// product grid, and Featured sorts it. Classic script (loaded after js/main.js) so the page also
// works from file://.
(() => {

const toolbar = document.querySelector('[data-shop-toolbar]')
const grid = document.querySelector('[data-shop-grid]')
const filterPanel = document.getElementById('filter-panel')
if (!toolbar || !grid || !filterPanel) return

const products = [...grid.querySelectorAll('.product')]
const empty = document.querySelector('[data-shop-empty]')
const dropdowns = [...toolbar.querySelectorAll('[data-dropdown]')]
const priceOf = (card) => Number(card.querySelector('.product__price').textContent.replace(/[^\d.]/g, ''))
const titleOf = (card) => card.querySelector('.product__title').textContent.trim()
const featuredOrder = new Map(products.map((card, i) => [card, i]))

// Hover photos whose file isn't there (yet) are dropped, so the card keeps its main photo on
// hover instead of showing a broken image.
grid.querySelectorAll('.product__photo--hover').forEach((img) => {
  if (img.complete && img.naturalWidth === 0 && img.currentSrc) img.remove()
  else img.addEventListener('error', () => img.remove())
})

// The drawer's Price / Color / Pattern sections are copies of the drop-down contents.
filterPanel.querySelectorAll('[data-filter-copy]').forEach((section) => {
  const source = document.getElementById(section.dataset.filterCopy)
  ;[...source.children].filter((el) => el.tagName !== 'LEGEND').forEach((el) => section.append(el.cloneNode(true)))
})

// Price range (drop-down and drawer copy share it): 0 up to the highest product price. The
// slider moves live; the From / To fields apply when you leave them or press Enter.
const PRICE_LIMIT = Math.ceil(Math.max(...products.map(priceOf)))
const price = { min: 0, max: PRICE_LIMIT }
const priceActive = () => price.min > 0 || price.max < PRICE_LIMIT
const priceWidgets = [...document.querySelectorAll('[data-price-range]')]
function renderPrice() {
  for (const widget of priceWidgets) {
    widget.querySelectorAll('[data-price-thumb]').forEach((thumb) => {
      thumb.max = PRICE_LIMIT
      thumb.value = price[thumb.dataset.priceThumb]
    })
    // The upper thumb sits on top; when both are at the top end, raise the lower one so it can
    // still be dragged back down.
    widget.querySelector('[data-price-thumb="min"]').style.zIndex = price.min >= PRICE_LIMIT ? '1' : ''
    widget.querySelectorAll('[data-price-field]').forEach((field) => {
      field.max = PRICE_LIMIT
      if (document.activeElement !== field) field.value = price[field.dataset.priceField]
    })
    const slider = widget.querySelector('.price-range__slider')
    slider.style.setProperty('--from', `${(price.min / PRICE_LIMIT) * 100}%`)
    slider.style.setProperty('--to', `${(price.max / PRICE_LIMIT) * 100}%`)
  }
}
// Set one end of the range, clamped to the limits and to the other end.
function setPrice(end, value) {
  const n = Math.round(Number(value))
  if (!Number.isFinite(n)) return
  price[end] = end === 'min' ? Math.min(Math.max(n, 0), price.max) : Math.max(Math.min(n, PRICE_LIMIT), price.min)
  renderPrice()
  apply()
}
for (const widget of priceWidgets) {
  widget.querySelectorAll('[data-price-thumb]').forEach((thumb) => {
    thumb.addEventListener('input', () => setPrice(thumb.dataset.priceThumb, thumb.value))
  })
  widget.querySelectorAll('[data-price-field]').forEach((field) => {
    field.addEventListener('change', () => setPrice(field.dataset.priceField, field.value))
    field.addEventListener('keydown', (e) => { if (e.key === 'Enter') field.blur() })
  })
  widget.querySelector('[data-price-reset]').addEventListener('click', () => {
    price.min = 0
    price.max = PRICE_LIMIT
    renderPrice()
    apply()
  })
}
renderPrice()

// Drop-downs: one open at a time; a click outside or Esc closes it.
function setOpen(dropdown, open) {
  dropdown.querySelector('.shop-dropdown__btn').setAttribute('aria-expanded', String(open))
  dropdown.querySelector('.shop-dropdown__panel').hidden = !open
}
const closeAll = () => dropdowns.forEach((dd) => setOpen(dd, false))
dropdowns.forEach((dd) => {
  const button = dd.querySelector('.shop-dropdown__btn')
  button.addEventListener('click', (e) => {
    e.stopPropagation()
    const open = button.getAttribute('aria-expanded') !== 'true'
    closeAll()
    setOpen(dd, open)
  })
})
document.addEventListener('click', (e) => { if (!toolbar.contains(e.target)) closeAll() })
document.addEventListener('keydown', (e) => {
  if (e.key !== 'Escape') return
  const open = dropdowns.find((dd) => dd.querySelector('.shop-dropdown__btn').getAttribute('aria-expanded') === 'true')
  if (open) { setOpen(open, false); open.querySelector('.shop-dropdown__btn').focus() }
})

// Filters drawer: the Filters button slides it in from the left; Esc, the close button, the
// backdrop or "Show N Products" closes it and returns focus to the button.
const filterButton = toolbar.querySelector('[data-filter-open]')
const CLOSE_MS = 450 // matches the .filter-drawer transition
let closeTimer = null
function openDrawer() {
  clearTimeout(closeTimer)
  closeAll()
  filterPanel.hidden = false
  filterPanel.offsetWidth // start the slide from the closed state
  filterPanel.classList.add('is-open')
  document.documentElement.classList.add('filter-locked')
  filterButton.setAttribute('aria-expanded', 'true')
  filterPanel.querySelector('.filter-drawer').focus({ preventScroll: true })
}
function closeDrawer() {
  if (!filterPanel.classList.contains('is-open')) return
  filterPanel.classList.remove('is-open')
  document.documentElement.classList.remove('filter-locked')
  filterButton.setAttribute('aria-expanded', 'false')
  closeTimer = setTimeout(() => { filterPanel.hidden = true }, CLOSE_MS)
  filterButton.focus({ preventScroll: true })
}
filterButton.addEventListener('click', (e) => { e.stopPropagation(); openDrawer() })
filterPanel.querySelectorAll('[data-filter-close]').forEach((el) => el.addEventListener('click', closeDrawer))
document.addEventListener('keydown', (e) => { if (e.key === 'Escape') closeDrawer() })

// Picked values of a filter (the same option can appear in a drop-down and in the drawer).
const checked = (name) => [...new Set([...document.querySelectorAll(`input[name="${name}"]:checked`)].map((input) => input.value))]

// Does a card match any of the picked values of a filter? Product data attributes may list several
// space-separated values (e.g. data-color="purple magenta").
const listMatch = (attr) => (card, values) => card.dataset[attr].split(' ').some((v) => values.includes(v))
const matchers = {
  category: listMatch('category'),
  price: (card) => priceOf(card) >= price.min && priceOf(card) <= price.max,
  color: listMatch('color'),
  fabric: listMatch('fabric'),
  blouse: listMatch('blouse'),
  pattern: listMatch('pattern'),
  occasion: listMatch('occasion'),
}

// Load more: the grid shows PAGE_SIZE matching products at first and PAGE_SIZE more per click of
// "Load more..." (hidden once everything is shown). Changing a filter or the sort starts over.
const PAGE_SIZE = 12
const loadMore = document.querySelector('.shop-more')
let limit = PAGE_SIZE

function apply(resetPage = true) {
  if (resetPage) limit = PAGE_SIZE
  const picked = Object.fromEntries(Object.keys(matchers).map((name) => [name, checked(name)]))
  picked.price = priceActive() ? ['range'] : [] // the range counts as one filter while narrowed
  const sort = checked('sort')[0]
  // A card passes when it matches every filter in use (optionally ignoring one of them).
  const passes = (card, ignore) => Object.entries(matchers)
    .every(([name, match]) => name === ignore || !picked[name].length || match(card, picked[name]))

  const matches = new Set(products.filter((card) => passes(card)))
  const shown = matches.size
  empty.hidden = shown > 0
  // Option counts: products the option would show, given the other filters in use.
  document.querySelectorAll('[data-count]').forEach((count) => {
    const input = count.closest('label').querySelector('input')
    const n = products.filter((card) => passes(card, input.name) && matchers[input.name](card, [input.value])).length
    count.textContent = `(${n})`
  })

  const compare = {
    featured: (a, b) => featuredOrder.get(a) - featuredOrder.get(b),
    // New arrivals (cards marked data-new) first, the rest after them in featured order.
    new: (a, b) => ('new' in b.dataset) - ('new' in a.dataset) || featuredOrder.get(a) - featuredOrder.get(b),
    'price-asc': (a, b) => priceOf(a) - priceOf(b) || featuredOrder.get(a) - featuredOrder.get(b),
    'price-desc': (a, b) => priceOf(b) - priceOf(a) || featuredOrder.get(a) - featuredOrder.get(b),
    name: (a, b) => titleOf(a).localeCompare(titleOf(b)),
  }[sort || 'featured']
  const sorted = [...products].sort(compare)
  grid.append(...sorted)
  // Show the first `limit` matching cards in sorted order.
  let rank = 0
  for (const card of sorted) {
    card.hidden = !matches.has(card) || rank >= limit
    if (matches.has(card)) rank += 1
  }
  loadMore.hidden = shown <= limit

  // Button labels: filter name plus the number of options picked; the sort button shows its choice.
  dropdowns.forEach((dd) => {
    const label = dd.querySelector('[data-label]')
    const inputs = [...dd.querySelectorAll('input:checked')]
    const count = dd.querySelector('[data-price-range]') ? picked.price.length : inputs.length
    if (dd.querySelector('input[type="radio"]')) label.textContent = inputs[0] ? inputs[0].parentElement.textContent.trim() : label.dataset.label
    else label.textContent = count ? `${label.dataset.label} (${count})` : label.dataset.label
  })
  const total = Object.values(picked).reduce((sum, values) => sum + values.length, 0)
  toolbar.querySelector('[data-filter-total]').textContent = total ? `Filters (${total})` : 'Filters'
  filterPanel.querySelector('[data-filter-show]').textContent = `Show ${shown} ${shown === 1 ? 'Product' : 'Products'}`
}

// Ticking an option in a drop-down ticks its copy in the drawer, and the other way round.
function onChange(e) {
  const input = e.target
  if (input.type === 'checkbox') {
    document.querySelectorAll(`input[name="${input.name}"][value="${input.value}"]`).forEach((other) => { other.checked = input.checked })
  }
  apply()
}
toolbar.addEventListener('change', onChange)
filterPanel.addEventListener('change', onChange)
document.querySelectorAll('[data-shop-clear]').forEach((button) => button.addEventListener('click', () => {
  document.querySelectorAll('[data-shop-toolbar] input[type="checkbox"], #filter-panel input[type="checkbox"]').forEach((input) => { input.checked = false })
  price.min = 0
  price.max = PRICE_LIMIT
  renderPrice()
  apply()
}))
loadMore.addEventListener('click', () => {
  limit += PAGE_SIZE
  apply(false)
})
apply() // fill the counts and show the first page

// Scroll reveal: each card slides in once it scrolls into view. Cards entering together go in
// reading order, STAGGER apart.
const STAGGER = 0.15
const revealer = new IntersectionObserver((entries) => {
  entries
    .filter((entry) => entry.isIntersecting)
    .sort((a, b) => a.boundingClientRect.top - b.boundingClientRect.top || a.boundingClientRect.left - b.boundingClientRect.left)
    .forEach((entry, i) => {
      entry.target.style.setProperty('--reveal-delay', `${i * STAGGER}s`)
      entry.target.classList.add('is-inview')
      revealer.unobserve(entry.target)
    })
}, { rootMargin: '0px 0px -10% 0px' })
products.forEach((card) => revealer.observe(card))
})()

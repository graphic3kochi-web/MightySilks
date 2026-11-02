<!-- 4 · hoop · 4: the 0 is an embroidery hoop with a half-stitched question mark and the needle
     still through the fabric; the 4s carry a stitched edge. Colour logo's gradient throughout.
     js-free: the hoop sways from its clamp and the question mark stitches itself in with CSS. -->
<svg class="not-found__art" viewBox="0 0 520 230" aria-hidden="true">
  <defs>
    <linearGradient id="nf-silk" gradientUnits="userSpaceOnUse" x1="20" y1="0" x2="500" y2="0">
      <stop offset="0" stop-color="#ce2546"/>
      <stop offset="0.55" stop-color="#7b4477"/>
      <stop offset="1" stop-color="#3460a2"/>
    </linearGradient>
    <!-- Reveals the stitches along the question mark as its stroke draws in. -->
    <mask id="nf-stitch-reveal" maskUnits="userSpaceOnUse" x="0" y="0" width="520" height="230">
      <path class="not-found__reveal" pathLength="1" fill="none" stroke="#fff" stroke-width="10" stroke-linecap="round"
            d="M238 102 C236 78 284 74 284 100 C284 120 260 118 260 140"/>
    </mask>
  </defs>

  <!-- The 4s, with a running stitch just inside their edges. -->
  <g class="not-found__digit">
    <text x="120" y="182" text-anchor="middle" fill="url(#nf-silk)">4</text>
    <text x="400" y="182" text-anchor="middle" fill="url(#nf-silk)">4</text>
  </g>
  <g class="not-found__digit not-found__digit--stitch">
    <text x="120" y="182" text-anchor="middle">4</text>
    <text x="400" y="182" text-anchor="middle">4</text>
  </g>

  <g class="not-found__hoop">
    <!-- Fabric, then the hoop's two rings and its clamp. -->
    <circle cx="260" cy="118" r="64" fill="url(#nf-silk)" opacity="0.08"/>
    <circle cx="260" cy="118" r="72" fill="none" stroke="url(#nf-silk)" stroke-width="9"/>
    <circle cx="260" cy="118" r="64" fill="none" stroke="url(#nf-silk)" stroke-width="3" opacity="0.5"/>
    <rect x="249" y="36" width="22" height="16" rx="4" fill="url(#nf-silk)"/>
    <rect x="254" y="26" width="12" height="12" rx="2" fill="url(#nf-silk)"/>

    <!-- The stitched question mark: running stitches, a cross-stitch for the dot. -->
    <path mask="url(#nf-stitch-reveal)" fill="none" stroke="url(#nf-silk)" stroke-width="3.2" stroke-linecap="round" stroke-dasharray="7 6"
          d="M238 102 C236 78 284 74 284 100 C284 120 260 118 260 140"/>
    <path class="not-found__dot" d="M254 152 L266 164 M266 152 L254 164" stroke="url(#nf-silk)" stroke-width="3.2" stroke-linecap="round"/>

    <!-- Thread from the last stitch to the needle, pushed through the fabric. -->
    <path class="not-found__thread" pathLength="1" fill="none" stroke="url(#nf-silk)" stroke-width="1.8" stroke-linecap="round"
          d="M260 140 C262 160 284 150 290 132"/>
    <g class="not-found__needle" transform="translate(290 132) rotate(-62)">
      <path d="M-8 -3.2 L44 -1.6 L62 0 L44 1.6 L-8 3.2 Q-12 0 -8 -3.2 Z" fill="url(#nf-silk)"/>
      <ellipse cx="0" cy="0" rx="5" ry="1.4" fill="#fff"/>
    </g>
  </g>
</svg>

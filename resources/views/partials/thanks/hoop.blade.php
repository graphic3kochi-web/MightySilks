<!-- The 404 page's embroidery hoop, here with a heart stitched into the fabric, in the colour logo's
     gradient. js-free: the heart stitches itself in, fills softly, then the thread and needle follow. -->
<svg class="thanks__art" viewBox="0 0 260 230" aria-hidden="true">
  <defs>
    <linearGradient id="ty-silk" gradientUnits="userSpaceOnUse" x1="40" y1="0" x2="220" y2="0">
      <stop offset="0" stop-color="#ce2546"/>
      <stop offset="0.55" stop-color="#7b4477"/>
      <stop offset="1" stop-color="#3460a2"/>
    </linearGradient>
    <!-- Reveals the heart's stitches as its stroke draws in. -->
    <mask id="ty-stitch-reveal" maskUnits="userSpaceOnUse" x="0" y="0" width="260" height="230">
      <path class="thanks__reveal" pathLength="1" fill="none" stroke="#fff" stroke-width="10" stroke-linecap="round"
            d="M130 160 C70 120 78 70 106 70 C120 70 128 80 130 92 C132 80 140 70 154 70 C182 70 190 120 130 160"/>
    </mask>
  </defs>

  <g class="thanks__hoop">
    <!-- Fabric, then the hoop's two rings and its clamp. -->
    <circle cx="130" cy="118" r="64" fill="url(#ty-silk)" opacity="0.08"/>
    <circle cx="130" cy="118" r="72" fill="none" stroke="url(#ty-silk)" stroke-width="9"/>
    <circle cx="130" cy="118" r="64" fill="none" stroke="url(#ty-silk)" stroke-width="3" opacity="0.5"/>
    <rect x="119" y="36" width="22" height="16" rx="4" fill="url(#ty-silk)"/>
    <rect x="124" y="26" width="12" height="12" rx="2" fill="url(#ty-silk)"/>

    <!-- The stitched heart, a soft fill behind it once it's sewn. -->
    <path class="thanks__fill" fill="url(#ty-silk)" d="M130 160 C70 120 78 70 106 70 C120 70 128 80 130 92 C132 80 140 70 154 70 C182 70 190 120 130 160 Z"/>
    <path mask="url(#ty-stitch-reveal)" fill="none" stroke="url(#ty-silk)" stroke-width="3.2" stroke-linecap="round" stroke-dasharray="7 6"
          d="M130 160 C70 120 78 70 106 70 C120 70 128 80 130 92 C132 80 140 70 154 70 C182 70 190 120 130 160"/>

    <!-- Thread from the last stitch to the needle, pushed through the fabric. -->
    <path class="thanks__thread" pathLength="1" fill="none" stroke="url(#ty-silk)" stroke-width="1.8" stroke-linecap="round"
          d="M130 160 C140 172 168 166 176 150"/>
    <g class="thanks__needle" transform="translate(176 150) rotate(-62)">
      <path d="M-8 -3.2 L44 -1.6 L62 0 L44 1.6 L-8 3.2 Q-12 0 -8 -3.2 Z" fill="url(#ty-silk)"/>
      <ellipse cx="0" cy="0" rx="5" ry="1.4" fill="#fff"/>
    </g>
  </g>
</svg>

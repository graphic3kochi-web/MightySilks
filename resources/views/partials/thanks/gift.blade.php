<!-- A gift box tied with a silk ribbon bow, a "Thank you" tag on a string and twinkling sparkles,
     in the colour logo's gradient. js-free: the ribbon tails draw in, the lid hops now and then,
     the tag swings and the sparkles twinkle, all with CSS. -->
<svg class="thanks__art thanks__art--gift" viewBox="0 0 260 230" aria-hidden="true">
  <defs>
    <linearGradient id="ty-silk" gradientUnits="userSpaceOnUse" x1="40" y1="0" x2="220" y2="0">
      <stop offset="0" stop-color="#ce2546"/>
      <stop offset="0.55" stop-color="#7b4477"/>
      <stop offset="1" stop-color="#3460a2"/>
    </linearGradient>
  </defs>

  <!-- Sparkles: four-point stars around the box. -->
  <g fill="url(#ty-silk)">
    <path class="thanks__spark" style="--d:0s" d="M44 58 Q46 66 54 68 Q46 70 44 78 Q42 70 34 68 Q42 66 44 58 Z"/>
    <path class="thanks__spark" style="--d:0.7s" d="M218 40 Q219.5 46 226 47.5 Q219.5 49 218 55 Q216.5 49 210 47.5 Q216.5 46 218 40 Z"/>
    <path class="thanks__spark" style="--d:1.4s" d="M30 150 Q31 155 36 156 Q31 157 30 162 Q29 157 24 156 Q29 155 30 150 Z"/>
    <path class="thanks__spark" style="--d:2.1s" d="M232 196 Q233.5 202 240 203.5 Q233.5 205 232 211 Q230.5 205 224 203.5 Q230.5 202 232 196 Z"/>
  </g>

  <g class="thanks__gift">
    <!-- Box and the ribbon down its front. -->
    <rect x="62" y="112" width="136" height="90" rx="6" fill="url(#ty-silk)" fill-opacity="0.12" stroke="url(#ty-silk)" stroke-width="3"/>
    <rect x="121" y="112" width="18" height="90" fill="url(#ty-silk)"/>

    <!-- Lid, its ribbon and the bow hop together. -->
    <g class="thanks__lid">
      <rect x="52" y="90" width="156" height="26" rx="6" fill="url(#ty-silk)"/>
      <rect x="121" y="90" width="18" height="26" fill="#fff" fill-opacity="0.35"/>
      <path class="thanks__tail" pathLength="1" fill="none" stroke="url(#ty-silk)" stroke-width="5" stroke-linecap="round" d="M126 90 C116 104 108 104 98 124"/>
      <path class="thanks__tail" pathLength="1" fill="none" stroke="url(#ty-silk)" stroke-width="5" stroke-linecap="round" d="M134 90 C144 104 152 104 162 124"/>
      <path d="M130 86 C104 56 76 68 94 88 C102 96 120 94 130 86 Z" fill="url(#ty-silk)"/>
      <path d="M130 86 C156 56 184 68 166 88 C158 96 140 94 130 86 Z" fill="url(#ty-silk)"/>
      <path d="M126 84 C110 70 96 72 102 84 M134 84 C150 70 164 72 158 84" fill="none" stroke="#fff" stroke-width="1.6" stroke-opacity="0.55" stroke-linecap="round"/>
      <circle cx="130" cy="87" r="8" fill="url(#ty-silk)" stroke="#fff" stroke-width="1.6" stroke-opacity="0.55"/>
    </g>

    <!-- Tag on a string from the box's corner. -->
    <g class="thanks__tag">
      <path d="M198 120 C206 126 210 132 212 140" fill="none" stroke="url(#ty-silk)" stroke-width="1.4"/>
      <g transform="rotate(12 212 140)">
        <path d="M200 146 L206 140 L244 140 Q247 140 247 143 L247 167 Q247 170 244 170 L206 170 L200 164 Z" fill="#fff" stroke="url(#ty-silk)" stroke-width="2"/>
        <circle cx="207" cy="155" r="2.2" fill="none" stroke="url(#ty-silk)" stroke-width="1.4"/>
        <text class="thanks__tag-text" x="227" y="159" text-anchor="middle" fill="url(#ty-silk)">Thank you</text>
      </g>
    </g>
  </g>
</svg>

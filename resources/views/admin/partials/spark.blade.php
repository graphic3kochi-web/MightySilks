{{-- Sparkline along the bottom of a stat card: $values, oldest first. --}}
@php
  $max = max(max($values), 1);
  $n = max(count($values) - 1, 1);
  $points = collect($values)->map(fn ($v, $i) => round($i / $n * 200, 1).','.round(36 - $v / $max * 30, 1))->implode(' ');
@endphp
<svg viewBox="0 0 200 40" preserveAspectRatio="none" aria-hidden="true">
  <polygon points="0,40 {{ $points }} 200,40" fill="currentColor" fill-opacity=".1"/>
  <polyline points="{{ $points }}" fill="none" stroke="currentColor" stroke-width="1.6" vector-effect="non-scaling-stroke" stroke-linejoin="round"/>
</svg>

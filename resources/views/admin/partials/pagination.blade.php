@if ($paginator->hasPages())
<nav class="adm-pages" aria-label="Pages">
  @if ($paginator->onFirstPage())
    <span class="is-disabled">‹</span>
  @else
    <a href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="Previous page">‹</a>
  @endif
  @foreach ($elements as $element)
    @if (is_string($element))
      <span class="is-disabled">{{ $element }}</span>
    @else
      @foreach ($element as $page => $url)
        @if ($page == $paginator->currentPage())
          <span class="is-current" aria-current="page">{{ $page }}</span>
        @else
          <a href="{{ $url }}">{{ $page }}</a>
        @endif
      @endforeach
    @endif
  @endforeach
  @if ($paginator->hasMorePages())
    <a href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="Next page">›</a>
  @else
    <span class="is-disabled">›</span>
  @endif
  <p>{{ $paginator->firstItem() }}–{{ $paginator->lastItem() }} of {{ $paginator->total() }}</p>
</nav>
@endif

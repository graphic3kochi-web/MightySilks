{{-- A labelled admin form field: input (any type), textarea or select ($options: value => label). --}}
@props(['name', 'label', 'type' => 'text', 'value' => null, 'options' => null, 'help' => null, 'wide' => false])
@php $id = 'f-'.str_replace(['[', ']'], '-', $name); $current = old($name, $value); @endphp
<div class="adm-field {{ $wide ? 'adm-field--wide' : '' }}">
  <label for="{{ $id }}">{{ $label }}</label>
  @if ($type === 'textarea')
    <textarea id="{{ $id }}" name="{{ $name }}" {{ $attributes->merge(['rows' => 4]) }}>{{ $current }}</textarea>
  @elseif ($options !== null)
    <select id="{{ $id }}" name="{{ $name }}" {{ $attributes }}>
      @foreach ($options as $optionValue => $optionLabel)
        <option value="{{ $optionValue }}" @selected((string) $current === (string) $optionValue)>{{ $optionLabel }}</option>
      @endforeach
    </select>
  @else
    <input id="{{ $id }}" type="{{ $type }}" name="{{ $name }}" @if ($type !== 'file') value="{{ $current }}" @endif {{ $attributes }}>
  @endif
  @if ($help)<small>{{ $help }}</small>@endif
  @error($name)<span class="adm-error">{{ $message }}</span>@enderror
</div>

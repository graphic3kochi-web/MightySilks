{{-- A yes/no switch that always submits (0 when unticked). --}}
@props(['name', 'label', 'checked' => false])
<label class="adm-check">
  <input type="hidden" name="{{ $name }}" value="0">
  <input type="checkbox" name="{{ $name }}" value="1" @checked(old($name, $checked))>
  {{ $label }}
</label>

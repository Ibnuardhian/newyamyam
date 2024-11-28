@props([
  'title' => 'Title',
  'subtitle' => 'Subtitle',
  'class' => ''
])

<div class="col-12 col-md-6">
  <div class="product-title">{{ $title }}</div>
  <div class="product-subtitle {{ $class }}">{{ $subtitle }}</div>
</div>
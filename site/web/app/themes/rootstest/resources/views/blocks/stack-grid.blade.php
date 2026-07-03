@php
  $items = $attributes['items'] ?? [];
@endphp

<section id="stack" class="mx-auto max-w-6xl px-6 py-8">
  <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
    @foreach ($items as $item)
      <div class="group rounded-2xl border border-slate-800 bg-slate-900/40 p-6 transition duration-200 hover:-translate-y-1 hover:border-slate-600 hover:bg-slate-900">
        <div class="text-3xl">{{ $item['icon'] ?? '' }}</div>
        <h3 class="mt-4 text-lg font-semibold text-white">{{ $item['title'] ?? '' }}</h3>
        <p class="mt-2 text-sm leading-relaxed text-slate-400">{{ $item['body'] ?? '' }}</p>
      </div>
    @endforeach
  </div>
</section>

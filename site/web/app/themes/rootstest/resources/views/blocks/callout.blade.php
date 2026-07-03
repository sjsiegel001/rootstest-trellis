@php
  // Literal class strings so Tailwind's source scanner picks them up.
  $borders = [
    'violet' => 'border-fuchsia-500/50',
    'emerald' => 'border-emerald-500/50',
    'amber' => 'border-amber-500/50',
  ];
  $dots = [
    'violet' => 'bg-fuchsia-400',
    'emerald' => 'bg-emerald-400',
    'amber' => 'bg-amber-400',
  ];

  $tone = $attributes['tone'] ?? 'violet';
  $border = $borders[$tone] ?? $borders['violet'];
  $dot = $dots[$tone] ?? $dots['violet'];
@endphp

<div class="my-8 rounded-2xl border {{ $border }} bg-slate-900 p-8">
  <span class="inline-flex h-2 w-2 rounded-full {{ $dot }}"></span>
  <h3 class="mt-4 text-2xl font-semibold text-white">{{ $attributes['heading'] ?? '' }}</h3>
  <p class="mt-3 leading-relaxed text-slate-300">{{ $attributes['body'] ?? '' }}</p>
</div>

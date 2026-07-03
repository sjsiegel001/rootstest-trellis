@extends('layouts.app')

@section('content')
  @php
    $stack = [
      [
        'icon' => '📦',
        'title' => 'Bedrock',
        'body' => 'WordPress structured as a Composer project — env-based config, sane folder layout, dependencies locked and versioned.',
      ],
      [
        'icon' => '🔧',
        'title' => 'Trellis',
        'body' => 'Ansible playbooks provision the Ubuntu 24.04 server (nginx, PHP 8.3, MariaDB) and ship zero-downtime deploys.',
      ],
      [
        'icon' => '🌱',
        'title' => 'Sage 11',
        'body' => 'This very theme: Blade templates and Acorn (Laravel) components, bundled by Vite and styled with Tailwind.',
      ],
      [
        'icon' => '☁️',
        'title' => 'AWS + Terraform',
        'body' => 'Every resource — VPC, EC2, IAM, S3, CloudFront — defined as code in Terraform and tagged for one-command teardown.',
      ],
      [
        'icon' => '🖼️',
        'title' => 'S3 + CloudFront',
        'body' => 'Media offloaded to a private S3 bucket and served worldwide through a CloudFront CDN at cdn.rootstest.de.',
      ],
      [
        'icon' => '⚡',
        'title' => 'Redis + HTTPS',
        'body' => 'A persistent Redis object cache keeps things fast, and Let\'s Encrypt handles automatic, auto-renewing TLS.',
      ],
    ];
  @endphp

  {{-- Hero --}}
  <section class="relative overflow-hidden">
    <div class="pointer-events-none absolute inset-0 -z-10" aria-hidden="true">
      <div class="absolute left-1/2 top-[-15%] h-[520px] w-[900px] max-w-full -translate-x-1/2 rounded-full bg-gradient-to-tr from-fuchsia-600/30 via-indigo-600/20 to-cyan-500/20 blur-3xl"></div>
    </div>

    <div class="mx-auto max-w-5xl px-6 pt-24 pb-16 text-center">
      <span class="inline-flex items-center gap-2 rounded-full border border-slate-800 bg-slate-900/60 px-4 py-1.5 text-sm text-slate-400">
        <span class="h-2 w-2 animate-pulse rounded-full bg-emerald-400"></span>
        Live on AWS &middot; deployed with Trellis
      </span>

      <h1 class="mt-6 text-5xl font-semibold tracking-tight text-white sm:text-6xl">
        The
        <span class="bg-gradient-to-r from-fuchsia-400 via-indigo-400 to-cyan-300 bg-clip-text text-transparent">Roots</span>
        stack,<br class="hidden sm:block"> shipped to production.
      </h1>

      <p class="mx-auto mt-6 max-w-2xl text-lg leading-relaxed text-slate-400">
        {{ get_bloginfo('name') }} is a WordPress site built on Bedrock, provisioned with Trellis,
        and themed with Sage&nbsp;11. Infrastructure lives in Terraform; media rides a CloudFront CDN.
        This whole page is a Blade template compiled by Vite.
      </p>

      <div class="mt-8 flex flex-wrap items-center justify-center gap-4">
        <a href="https://roots.io" class="rounded-lg bg-white px-5 py-3 text-sm font-medium text-slate-900 transition hover:bg-slate-200">
          Explore Roots
        </a>
        <a href="#stack" class="rounded-lg border border-slate-700 px-5 py-3 text-sm font-medium text-slate-200 transition hover:bg-slate-900">
          See the stack &darr;
        </a>
      </div>
    </div>
  </section>

  {{-- Stack grid --}}
  <section id="stack" class="mx-auto max-w-6xl px-6 pb-24">
    <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
      @foreach ($stack as $item)
        <div class="group rounded-2xl border border-slate-800 bg-slate-900/40 p-6 transition duration-200 hover:-translate-y-1 hover:border-slate-600 hover:bg-slate-900">
          <div class="text-3xl">{{ $item['icon'] }}</div>
          <h3 class="mt-4 text-lg font-semibold text-white">{{ $item['title'] }}</h3>
          <p class="mt-2 text-sm leading-relaxed text-slate-400">{{ $item['body'] }}</p>
        </div>
      @endforeach
    </div>
  </section>
@endsection

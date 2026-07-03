<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

class MakeBlock extends Command
{
    protected $signature = 'make:block {name : Block class name, e.g. Feature}';

    protected $description = 'Scaffold a native, Blade-rendered Gutenberg block (no ACF)';

    public function handle(): int
    {
        $studly = Str::studly($this->argument('name'));
        $kebab = Str::kebab($studly);
        $root = dirname(__DIR__, 3);

        $classPath = "{$root}/app/Blocks/{$studly}.php";
        $viewPath = "{$root}/resources/views/blocks/{$kebab}.blade.php";

        if (file_exists($classPath)) {
            $this->error("Block already exists: app/Blocks/{$studly}.php");

            return self::FAILURE;
        }

        file_put_contents($classPath, $this->classStub($studly, $kebab));

        if (! is_dir(dirname($viewPath))) {
            mkdir(dirname($viewPath), 0755, true);
        }

        if (! file_exists($viewPath)) {
            file_put_contents($viewPath, $this->viewStub());
        }

        $this->info("Created app/Blocks/{$studly}.php");
        $this->info("Created resources/views/blocks/{$kebab}.blade.php");
        $this->line("Registered automatically as \"rootstest/{$kebab}\". No JS build needed — the editor reads the fields from PHP.");

        return self::SUCCESS;
    }

    protected function classStub(string $studly, string $kebab): string
    {
        $stub = <<<'STUB'
<?php

namespace App\Blocks;

class __STUDLY__ extends Block
{
    public string $name = 'rootstest/__KEBAB__';

    public string $title = '__STUDLY__';

    public string $icon = 'block-default';

    public string $view = 'blocks.__KEBAB__';

    public array $fields = [
        'heading' => ['type' => 'text', 'label' => 'Heading', 'default' => '__STUDLY__ heading'],
        'body' => ['type' => 'textarea', 'label' => 'Body', 'default' => ''],
    ];
}

STUB;

        return str_replace(['__STUDLY__', '__KEBAB__'], [$studly, $kebab], $stub);
    }

    protected function viewStub(): string
    {
        return <<<'STUB'
@php
  $heading = $attributes['heading'] ?? '';
  $body = $attributes['body'] ?? '';
@endphp

<section class="mx-auto max-w-3xl px-6 py-12">
  @if ($heading)
    <h2 class="text-2xl font-semibold tracking-tight text-white">{{ $heading }}</h2>
  @endif
  @if ($body)
    <p class="mt-3 leading-relaxed text-slate-300">{{ $body }}</p>
  @endif
</section>

STUB;
    }
}

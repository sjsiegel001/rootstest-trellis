<?php

namespace App\Providers;

use App\Blocks\Block;
use App\Console\Commands\MakeBlock;
use Illuminate\Support\ServiceProvider;
use ReflectionClass;

class BlockServiceProvider extends ServiceProvider
{
    /**
     * Register the make:block console command.
     */
    public function register(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([MakeBlock::class]);
        }
    }

    /**
     * Register every Block on init and hand their field configs to the editor.
     */
    public function boot(): void
    {
        $blocks = $this->blocks();

        add_action('init', function () use ($blocks) {
            foreach ($blocks as $block) {
                $block->register();
            }
        });

        add_action('enqueue_block_editor_assets', function () use ($blocks) {
            $configs = array_map(fn (Block $block) => $block->editorConfig(), $blocks);

            wp_print_inline_script_tag('window.__rootstestBlocks = ' . wp_json_encode($configs) . ';');
        });
    }

    /**
     * Instantiate every concrete Block subclass in app/Blocks.
     *
     * @return array<int, Block>
     */
    protected function blocks(): array
    {
        $blocks = [];

        foreach (glob(dirname(__DIR__) . '/Blocks/*.php') as $file) {
            $class = 'App\\Blocks\\' . basename($file, '.php');

            if (! class_exists($class)) {
                continue;
            }

            $reflection = new ReflectionClass($class);

            if ($reflection->isAbstract() || ! $reflection->isSubclassOf(Block::class)) {
                continue;
            }

            $blocks[] = new $class();
        }

        return $blocks;
    }
}

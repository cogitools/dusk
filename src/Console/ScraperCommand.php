<?php

namespace Laravel\Dusk\Console;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Artisan;

class ScraperCommand extends GeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'dusk:scraper {name : The name of the class} {--with-job}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new Scraper class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Scraper';

    /**
     * Handle the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $result = parent::handle();
        if ($this->option('with-job')) {
            Artisan::call('dusk:scraper-job', [
                'name' => $this->argument('name').'Job', 
                'scraper' => $this->argument('name')
            ]);
        }
        return $result;
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__.'/stubs/scraper.stub';
    }

    /**
     * Get the destination class path.
     *
     * @param  string  $name
     * @return string
     */
    protected function getPath($name)
    {
        $name = Str::replaceFirst($this->rootNamespace(), '', $name);

        return $this->laravel->basePath().'/app'.str_replace('\\', '/', $name).'.php';
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace.'\Scrapers';
    }

    /**
     * Get the root namespace for the class.
     *
     * @return string
     */
    protected function rootNamespace()
    {
        return 'App';
    }
}

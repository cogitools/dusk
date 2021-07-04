<?php

namespace Laravel\Dusk\Console;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;

class ScraperJobCommand extends GeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'dusk:scraper-job {name : The name of the job} {scraper : The name of the scraper}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new ScraperJob class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'ScraperJob';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__.'/stubs/scraper_job.stub';
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
    protected function getScraper()
    {
        return trim($this->argument('scraper'));
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getScraperNamespace()
    {
        return $this->rootNamespace().'\Jobs';
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace.'\Jobs';
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

    /**
     * Replace to replace the scraper and the class.
     *
     * @param  string  $stub
     * @param  string  $name
     * @return string
     */
    protected function replaceClass($stub, $name)
    {
        $scraper = $this->getScraper();
        $scraper_namespaced = $this->getScraperNamespace().'\\'.$scraper;
        $replaced = str_replace(['ScraperClass', '{{ scraper }}', '{{scraper}}'], $scraper, $stub);
        $replaced = str_replace(['ScraperNamespaced', '{{ scraper_namespaced }}', '{{scraper_namespaced}}'], $scraper_namespaced, $replaced);
        return parent::replaceClass($replaced, $name);
    }
}

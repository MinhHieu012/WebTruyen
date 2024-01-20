<?php

namespace App\Console\Commands\Repository;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;

class RepositoryMake extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:repository {name} {--controller} {--service}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    protected $files;
    protected $repo_name = '';
    protected $create_controller = false;
    protected $create_service = false;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->files = new Filesystem();
    }

    function getStubs()
    {
        $stubs = [
            'RepositoryInterface' => __DIR__ . '/stubs/repositoryInterface.stub',
            'Repository'          => __DIR__ . '/stubs/repository.stub',
        ];
        if ($this->create_controller) {
            $stubs['Controller'] = __DIR__ . '/stubs/controller.stub';
        }
        if ($this->create_service) {
            $stubs['Service'] = __DIR__ . '/stubs/service.stub';
        }

        return $stubs;
    }

    function applyServiceProvider($name)
    {
        $string_search  = '//#replace#';
        $string_replace = '
        $this->app->singleton(
            \\App\\Repositories\\' . $name . '\\' . $name . 'RepositoryInterface::class,
            \\App\\Repositories\\' . $name . '\\' . $name . 'Repository::class
        );
        ' . $string_search;
        $file           = $this->laravel['path'] . '/Repositories/RepositoriesServiceProvider.php';
        $content        = $this->files->get($file);

        if (Str::of($content)->contains($name . 'RepositoryInterface::class')) {
            $this->warn('# File RepositoriesServiceProvider.php đã có sẵn.');
            return;
        }

        $new_content = str_replace($string_search, $string_replace, $content);

        $this->files->put($file, $new_content);

        $this->info('# Cập nhật thành công file RepositoriesServiceProvider.php');
    }

    /**
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    function createFile($type, $stub_file): bool
    {
        if ($type == 'Controller') {
            $path = $this->laravel['path'] . '/Http/Controllers';
        } else if ($type == 'Service') {
            $path = $this->laravel['path'] . '/Services';
        } else {
            $path = $this->laravel['path'] . '/Repositories/' . $this->repo_name;
        }

        $new_file = $path . '/' . $this->repo_name . $type . '.php';
        if ($this->files->exists($new_file)) {
            $this->warn('# File ' . $this->repo_name . $type . '.php đã có.');
            return false;
        }
        if (!$this->files->isDirectory($path)) {
            $this->files->makeDirectory($path);
        }

        $search   = ['{{modelName}}'];
        $replaces = [$this->repo_name];
        $content  = str_replace($search, $replaces, $this->files->get($stub_file));
        $this->files->put($new_file, $content);
        $this->info('# Tạo thành công file ' . $this->repo_name . $type . '.php');

        return true;
    }

    /**
     * Execute the console command.
     *
     * @return int
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function handle()
    {
        $this->repo_name         = $this->argument('name');
        $this->create_controller = $this->option('controller');
        $this->create_service    = $this->option('service');
        $stubs                   = $this->getStubs();

        $this->info('# Tạo file');
        foreach ($stubs as $type => $stub_file) {
            $this->createFile($type, $stub_file);
        }
        $this->newLine();
        $this->info('# Cập nhật ServiceProvider');
        $this->applyServiceProvider($this->repo_name);
        return 1;
    }
}

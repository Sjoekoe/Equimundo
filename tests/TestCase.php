<?php

use EQM\Core\Factories\BuildModels;
use EQM\Core\Factories\ModelFactory;
use EQM\Core\Testing\CreatesModels;
use Illuminate\Http\Response;

class TestCase extends Illuminate\Foundation\Testing\TestCase
{
    use BuildModels, CreatesModels;

    protected $baseUrl = 'http://localhost';

    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $app = require __DIR__.'/../bootstrap/app.php';

        $app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();
        $this->modelFactory = $app->make(ModelFactory::class);

        return $app;
    }

    public function setup()
    {
        parent::setUp();

        $this->artisan('migrate');
    }

    public function assertNoContent()
    {
        return $this->assertResponseStatus(Response::HTTP_NO_CONTENT);
    }
}

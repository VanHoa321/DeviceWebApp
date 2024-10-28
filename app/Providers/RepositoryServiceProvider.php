<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Building\BuildingInterface;
use App\Repositories\Building\BuildingRepository;
use App\Repositories\Branch\BranchInterface;
use App\Repositories\Branch\BranchRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(BuildingInterface::class, BuildingRepository::class);
        $this->app->bind(BranchInterface::class, BranchRepository::class);
    }

    public function boot(): void
    {
        //
    }
}

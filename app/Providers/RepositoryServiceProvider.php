<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Building\BuildingInterface;
use App\Repositories\Building\BuildingRepository;
use App\Repositories\Branch\BranchInterface;
use App\Repositories\Branch\BranchRepository;
use App\Repositories\DeviceType\DeviceTypeInterface;
use App\Repositories\DeviceType\DeviceTypeRepository;
use App\Repositories\Room\RoomInterface;
use App\Repositories\Room\RoomRepository;
use App\Repositories\Device\DeviceInterface;
use App\Repositories\Device\DeviceRepository;
use App\Repositories\WorkUnit\WorkUnitInterface;
use App\Repositories\WorkUnit\WorkUnitRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(BuildingInterface::class, BuildingRepository::class);
        $this->app->bind(BranchInterface::class, BranchRepository::class);
        $this->app->bind(DeviceTypeInterface::class, DeviceTypeRepository::class);
        $this->app->bind(RoomInterface::class, RoomRepository::class);
        $this->app->bind(DeviceInterface::class, DeviceRepository::class);
        $this->app->bind(WorkUnitInterface::class, WorkUnitRepository::class);
    }

    public function boot(): void
    {
        
    }
}

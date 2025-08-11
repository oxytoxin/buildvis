<?php

namespace App\Filament\Clusters\UserManagement\Resources\CustomerResource\Pages;

use App\Filament\Clusters\UserManagement\Resources\CustomerResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateCustomer extends CreateRecord
{
    protected static string $resource = CustomerResource::class;
}

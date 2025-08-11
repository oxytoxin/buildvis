<?php

    namespace App\Filament\Clusters\UserManagement\Resources\CustomerResource\Pages;

    use App\Filament\Clusters\UserManagement\Resources\CustomerResource;
    use Filament\Resources\Pages\ListRecords;

    class ListCustomers extends ListRecords
    {
        protected static string $resource = CustomerResource::class;

        protected function getHeaderActions(): array
        {
            return [];
        }
    }

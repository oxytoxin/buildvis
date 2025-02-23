<?php

namespace App\Filament\Store\Pages;

use App\Models\CityMunicipality;
use App\Models\Province;
use App\Models\Region;
use App\Models\ShippingInformation;
use Auth;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Pages\Page;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;

class CustomerProfile extends Page implements HasTable, HasForms
{
    use InteractsWithTable, InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-user-circle';

    protected static string $view = 'filament.store.pages.customer-profile';

    protected static ?int $navigationSort = 2;


    public function table(Table $table)
    {
        return $table
            ->query(
                ShippingInformation::query()
                    ->where('customer_id', Auth::user()->customer->id)
            )
            ->columns([
                TextColumn::make('region.name')
                    ->label('Region'),
                TextColumn::make('province.name')
                    ->label('Province'),
                TextColumn::make('city_municipality.name')
                    ->label('City/Municipality'),
                TextColumn::make('address_line_1')
                    ->label('Address Line 1'),
                TextColumn::make('address_line_2')
                    ->label('Address Line 2'),
            ])
            ->actions([
                EditAction::make('edit')
                    ->form([
                        Select::make('region_code')
                            ->options(Region::pluck('name', 'code'))
                            ->label('Region')
                            ->reactive()
                            ->afterStateUpdated(fn($set) => $set('province_code', null))
                            ->required(),
                        Select::make('province_code')
                            ->options(fn($get) => Province::where('region_code', $get('region_code'))->pluck('name', 'code'))
                            ->label('Province')
                            ->disabled(fn($get) => !$get('region_code'))
                            ->afterStateUpdated(fn($set) => $set('city_municipality_code', null))
                            ->reactive()
                            ->required(),
                        Select::make('city_municipality_code')
                            ->options(fn($get) => CityMunicipality::where('province_code', $get('province_code'))->pluck('name', 'code'))
                            ->label('City/Municipality')
                            ->disabled(fn($get) => !$get('province_code'))
                            ->reactive()
                            ->required(),
                        TextInput::make('address_line_1')
                            ->required(),
                        TextInput::make('address_line_2'),
                    ]),
            ])
            ->headerActions([
                CreateAction::make('create')
                    ->mutateFormDataUsing(fn($data) => array_merge($data, [
                        'customer_id' => Auth::user()->customer->id,
                    ]))
                    ->form([
                        Select::make('region_code')
                            ->options(Region::pluck('name', 'code'))
                            ->label('Region')
                            ->reactive()
                            ->required(),
                        Select::make('province_code')
                            ->options(fn($get) => Province::where('region_code', $get('region_code'))->pluck('name', 'code'))
                            ->label('Province')
                            ->disabled(fn($get) => !$get('region_code'))
                            ->reactive()
                            ->required(),
                        Select::make('city_municipality_code')
                            ->options(fn($get) => CityMunicipality::where('province_code', $get('province_code'))->pluck('name', 'code'))
                            ->label('City/Municipality')
                            ->disabled(fn($get) => !$get('province_code'))
                            ->reactive()
                            ->required(),
                        TextInput::make('address_line_1')
                            ->required(),
                        TextInput::make('address_line_2'),
                    ])
                    ->label('Add Shipping Information')
                    ->icon('heroicon-o-plus-circle'),
            ]);
    }
}

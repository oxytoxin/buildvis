<?php

namespace App\Filament\Clusters\PSGC\Resources;

use App\Filament\Clusters\Addresses;
use App\Filament\Clusters\PSGC\Resources\CityMunicipalityResource\Pages\ManageCityMunicipalities;
use App\Filament\Resources\CityMunicipalityResource\Pages;
use App\Filament\Resources\CityMunicipalityResource\RelationManagers;
use App\Models\CityMunicipality;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CityMunicipalityResource extends Resource
{
    protected static ?string $model = CityMunicipality::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $cluster = Addresses::class;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('region.name')
                    ->label('Region')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('province.name')
                    ->label('Province')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('code')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('region_code')
                    ->relationship('region', 'name', fn(Builder $query) => $query->orderBy('id'))
                    ->label('Region')
                    ->placeholder('All Regions'),
                SelectFilter::make('province_code')
                    ->relationship('province', 'name', fn(Builder $query) => $query->orderBy('id'))
                    ->label('Province')
                    ->placeholder('All Provinces'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageCityMunicipalities::route('/'),
        ];
    }
}

<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HouseModelResource\Pages;
use App\Models\HouseModel;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class HouseModelResource extends Resource
{
    protected static ?string $model = HouseModel::class;

    protected static ?string $slug = 'house-models';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required(),
                TextInput::make('budget')
                    ->required()
                    ->numeric(),
                TextInput::make('floor_length')
                    ->required()
                    ->numeric(),
                TextInput::make('floor_width')
                    ->required()
                    ->numeric(),
                TextInput::make('number_of_stories')
                    ->required()
                    ->integer(),
                TextInput::make('number_of_rooms')
                    ->required()
                    ->integer(),
                Textarea::make('description')
                    ->columnSpanFull()
                    ->required(),
                FileUpload::make('model_url')
                    ->required()
                    ->directory('house-models')
                    ->disk('s3'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('budget'),
                TextColumn::make('floor_length'),
                TextColumn::make('floor_width'),
                TextColumn::make('number_of_stories'),
                TextColumn::make('number_of_rooms'),
            ])
            ->filters([
                //
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListHouseModels::route('/'),
            'create' => Pages\CreateHouseModel::route('/create'),
            'edit' => Pages\EditHouseModel::route('/{record}/edit'),
        ];
    }
}

<?php

namespace App\Filament\Resources\WorkCategoryResource\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ProductsRelationManager extends RelationManager
{
    protected static string $relationship = 'product_variations';

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('product_slug')
            ->columns([
                TextColumn::make('product_slug'),
                TextColumn::make('price'),
                TextColumn::make('product.unit'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\AttachAction::make()
                    ->multiple()
                    ->closeModalByClickingAway(false)
                    ->preloadRecordSelect(true),
            ])
            ->actions([
                Tables\Actions\DetachAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DetachBulkAction::make(),
                ]),
            ]);
    }
}

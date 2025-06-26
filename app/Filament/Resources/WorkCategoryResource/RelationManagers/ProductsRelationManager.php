<?php

namespace App\Filament\Resources\WorkCategoryResource\RelationManagers;

use App\Models\ProductVariation;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

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

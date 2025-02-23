<?php

namespace App\Filament\Store\Pages;

use App\Models\Product;
use Filament\Forms\Components\TextInput;
use Filament\Pages\Page;
use Filament\Tables\Table;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;

class StoreIndex extends Page implements HasForms, HasTable
{
    use InteractsWithForms, InteractsWithTable;

    protected static ?string $navigationIcon = 'heroicon-o-building-storefront';

    protected static string $view = 'filament.store.pages.store-index';

    protected ?string $heading = "";

    protected static ?string $navigationLabel = "Store";

    protected static ?int $navigationSort = 1;

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Product::query()
                    ->with('featured_image')
            )
            ->recordUrl(fn($record) => route('filament.admin.resources.products.edit', $record))
            ->columns([
                Stack::make([
                    SpatieMediaLibraryImageColumn::make('featured_image')
                        ->height(180)
                        ->defaultImageUrl(url('https://dummyimage.com/300x300/000/aaa'))
                        ->collection('images'),
                    TextColumn::make('name')->searchable()->extraAttributes(['class' => 'mt-4']),
                    TextColumn::make('price')->money('PHP')->sortable(),
                    TextColumn::make('stock_quantity')->size('xs')->sortable()->formatStateUsing(fn($state, $record) => $state . " " . str($record->unit)->plural() . " in stock"),
                ])
            ])
            ->filters([
                SelectFilter::make('category_id')
                    ->label('Category')
                    ->preload()
                    ->relationship('category', 'name')
                    ->multiple(),
                SelectFilter::make('supplier_id')
                    ->label('Supplier')
                    ->preload()
                    ->relationship('supplier', 'name')
                    ->multiple(),
            ])
            ->heading('All Products')
            ->filtersLayout(FiltersLayout::AboveContent)
            ->contentGrid([
                'md' => 3,
                'lg' => 4,
                'xl' => 6,
            ]);
    }
}

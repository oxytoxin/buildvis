<?php

namespace App\Filament\Resources\SupplierResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ProductsRelationManager extends RelationManager
{
    protected static string $relationship = 'products';

    protected static ?string $title = 'Supplier Products';

    protected static ?string $recordTitleAttribute = 'name';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Product Information')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(191),
                        Forms\Components\Select::make('category_id')
                            ->relationship('category', 'name')
                            ->required()
                            ->createOptionForm([
                                Forms\Components\TextInput::make('name')
                                    ->required()
                                    ->maxLength(191),
                                Forms\Components\TextInput::make('description')
                                    ->maxLength(191),
                                Forms\Components\TextInput::make('slug')
                                    ->required()
                                    ->maxLength(191),
                            ]),
                        Forms\Components\Textarea::make('description')
                            ->required()
                            ->rows(3),
                    ])->columns(2),

                Forms\Components\Section::make('Pricing & Inventory')
                    ->schema([
                        Forms\Components\TextInput::make('price')
                            ->numeric()
                            ->prefix('₱')
                            ->required(),
                        Forms\Components\TextInput::make('unit')
                            ->required()
                            ->maxLength(191),
                        Forms\Components\TextInput::make('stock_quantity')
                            ->numeric()
                            ->required()
                            ->minValue(0),
                        Forms\Components\TextInput::make('minimum_stock_quantity')
                            ->numeric()
                            ->required()
                            ->default(10)
                            ->minValue(1),
                        Forms\Components\TextInput::make('minimum_order_quantity')
                            ->numeric()
                            ->required()
                            ->default(1)
                            ->minValue(1),
                    ])->columns(2),

                Forms\Components\Section::make('Status')
                    ->schema([
                        Forms\Components\Select::make('status')
                            ->options([
                                'active' => 'Active',
                                'out_of_stock' => 'Out of Stock',
                                'discontinued' => 'Discontinued',
                            ])
                            ->required()
                            ->default('active'),
                    ]),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                Tables\Columns\TextColumn::make('category.name')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('price')
                    ->money('PHP')
                    ->sortable(),
                Tables\Columns\TextColumn::make('unit'),
                Tables\Columns\TextColumn::make('stock_quantity')
                    ->sortable()
                    ->label('Stock'),
                Tables\Columns\TextColumn::make('status')
                    ->colors([
                        'danger' => 'discontinued',
                        'warning' => 'out_of_stock',
                        'success' => 'active',
                    ])
                    ->badge(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'active' => 'Active',
                        'out_of_stock' => 'Out of Stock',
                        'discontinued' => 'Discontinued',
                    ]),
                Tables\Filters\SelectFilter::make('category')
                    ->relationship('category', 'name'),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\Action::make('edit')->url(fn($record) => route('filament.admin.resources.products.edit', ['record' => $record])),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('name');
    }
}

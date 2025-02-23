<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SupplierResource\Pages;
use App\Filament\Resources\SupplierResource\RelationManagers;
use App\Models\Supplier;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SupplierResource extends Resource
{
    protected static ?string $model = Supplier::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-storefront';

    protected static ?string $navigationGroup = 'Inventory Management';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Basic Information')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(191)
                            ->placeholder('Enter business name')
                            ->columnSpan(2),
                        Forms\Components\TextInput::make('email')
                            ->email()
                            ->required()
                            ->maxLength(191)
                            ->unique(ignoreRecord: true),
                        Forms\Components\TextInput::make('phone')
                            ->tel()
                            ->required()
                            ->maxLength(191),
                    ])->columns(2),

                Forms\Components\Section::make('Contact Details')
                    ->schema([
                        Forms\Components\TextInput::make('contact_person')
                            ->required()
                            ->maxLength(191)
                            ->placeholder('Full name of contact person'),
                        Forms\Components\Textarea::make('address')
                            ->required()
                            ->rows(3)
                            ->placeholder('Complete business address')
                            ->columnSpanFull(),
                    ]),

                Forms\Components\Section::make('Business Information')
                    ->schema([
                        Forms\Components\TextInput::make('business_permit_number')
                            ->label('Business Permit No.')
                            ->maxLength(191)
                            ->placeholder('Format: BP-YYYY-XXXX-XXXX'),
                        Forms\Components\Toggle::make('is_verified')
                            ->required()
                            ->inline(false)
                            ->onColor('success')
                            ->offColor('danger')
                            ->helperText('Verified suppliers can list products for sale'),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                Tables\Columns\TextColumn::make('email')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->copyMessage('Email address copied')
                    ->icon('heroicon-m-envelope'),
                Tables\Columns\TextColumn::make('contact_person')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('phone')
                    ->searchable()
                    ->copyable()
                    ->copyMessage('Phone number copied')
                    ->icon('heroicon-m-phone'),
                Tables\Columns\TextColumn::make('products_count')
                    ->counts('products')
                    ->sortable()
                    ->label('Products'),
                Tables\Columns\IconColumn::make('is_verified')
                    ->boolean()
                    ->sortable()
                    ->label('Verified')
                    ->trueIcon('heroicon-o-check-badge')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('name')
            ->filters([
                Tables\Filters\SelectFilter::make('is_verified')
                    ->options([
                        '1' => 'Verified',
                        '0' => 'Unverified',
                    ])
                    ->label('Verification Status'),
                Tables\Filters\Filter::make('has_products')
                    ->query(fn(Builder $query): Builder => $query->has('products'))
                    ->label('Has Products')
                    ->toggle(),
                Tables\Filters\Filter::make('created_at')
                    ->form([
                        Forms\Components\DatePicker::make('created_from'),
                        Forms\Components\DatePicker::make('created_until'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn(Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['created_until'],
                                fn(Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    })
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('verify')
                    ->icon('heroicon-m-check-badge')
                    ->color('success')
                    ->requiresConfirmation()
                    ->visible(fn(Supplier $record): bool => !$record->is_verified)
                    ->action(fn(Supplier $record) => $record->update(['is_verified' => true])),
                Tables\Actions\Action::make('unverify')
                    ->icon('heroicon-m-x-circle')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->visible(fn(Supplier $record): bool => $record->is_verified)
                    ->action(fn(Supplier $record) => $record->update(['is_verified' => false])),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\BulkAction::make('verify')
                        ->icon('heroicon-m-check-badge')
                        ->requiresConfirmation()
                        ->action(fn(Collection $records) => $records->each->update(['is_verified' => true])),
                    Tables\Actions\BulkAction::make('unverify')
                        ->icon('heroicon-m-x-circle')
                        ->requiresConfirmation()
                        ->action(fn(Collection $records) => $records->each->update(['is_verified' => false])),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\ProductsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSuppliers::route('/'),
            'create' => Pages\CreateSupplier::route('/create'),
            'edit' => Pages\EditSupplier::route('/{record}/edit'),
        ];
    }
}

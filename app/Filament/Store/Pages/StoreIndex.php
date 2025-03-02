<?php

namespace App\Filament\Store\Pages;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Auth;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Pages\Page;
use Filament\Tables\Table;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Notifications\Notification;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Validation\ValidationException;

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
            ->columns([
                Stack::make([
                    SpatieMediaLibraryImageColumn::make('featured_image')
                        ->height(180)
                        ->defaultImageUrl(url('https://dummyimage.com/300x300/000/aaa'))
                        ->collection('images'),
                    TextColumn::make('name')->searchable()->extraAttributes(['class' => 'mt-4']),
                    TextColumn::make('price')->money('PHP')->sortable(),
                    TextColumn::make('stock_quantity')->size('xs')->sortable()->formatStateUsing(fn($state, $record) => $state . " " . str($record->unit)->plural() . " in stock"),
                ]),

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
            ->actions([
                Action::make('view')
                    ->icon('heroicon-o-cube')
                    ->label('View 3D')
                    ->url(fn($record) => route('product.view', $record))
                    ->button()
                    ->outlined()
                    ->openUrlInNewTab(),
                Action::make('Add to Cart')
                    ->button()
                    ->icon('heroicon-o-shopping-cart')
                    ->form([
                        Select::make('order_id')
                            ->label('Order')
                            ->options(Order::whereCustomerId(Auth::user()->customer?->id)->pluck('name', 'id'))
                            ->default(Order::whereCustomerId(Auth::user()->customer?->id)->first()?->id),
                        Placeholder::make('product')
                            ->content(fn($record) => $record->name),
                        Placeholder::make('stock_remaining')
                            ->content(fn($record) => $record->stock_quantity),
                        Placeholder::make('in_cart')
                            ->content(fn($record) => OrderItem::query()->whereRelation('order', 'customer_id', Auth::user()->customer?->id)->where('product_id', $record->id)->sum('quantity')),
                        TextInput::make('quantity')
                            ->default(1)
                            ->rules(fn($record) => ['required', 'numeric', 'min:1', 'max:' . $record->stock_quantity])
                            ->validationMessages([
                                'required' => 'The quantity is required.',
                                'numeric' => 'The quantity must be a number.',
                                'min' => 'The quantity must be at least 1.',
                                'max' => 'The quantity must not exceed the stock remaining.',
                            ]),
                    ])
                    ->action(function ($data, Product $record) {
                        sleep(0.25);
                        $order = Order::find($data['order_id']);
                        $product = Product::find($record->id);
                        $existing = $order->items()->where('product_id', $record->id)->first();
                        if ($existing) {
                            if ($existing->quantity + $data['quantity'] > $record->stock_quantity) {
                                throw ValidationException::withMessages([
                                    'mountedTableActionsData.0.quantity' => 'The total quantity must not exceed the stock remaining.',
                                ]);
                            }
                            $existing->update([
                                'quantity' => $existing->quantity + $data['quantity'],
                            ]);
                        } else {
                            $order->items()->create([
                                'product_id' => $record->id,
                                'quantity' => $data['quantity'],
                                'unit_price' => $record->price,
                            ]);
                        }
                        Notification::make()
                            ->title('Product added to Cart')
                            ->success()
                            ->send();
                    }),

            ])
            ->heading('All Products')
            ->filtersLayout(FiltersLayout::AboveContent)
            ->contentGrid([
                'md' => 3,
                'lg' => 4,
                'xl' => 5,
            ]);
    }
}

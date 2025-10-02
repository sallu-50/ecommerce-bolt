<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Models\Order;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';

    protected static ?string $navigationGroup = 'Shop Management';

    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('Order Information')
                            ->schema([
                                Forms\Components\TextInput::make('id')
                                    ->label('Order ID')
                                    ->disabled(),
                                
                                Forms\Components\Select::make('user_id')
                                    ->relationship('user', 'name')
                                    ->searchable()
                                    ->preload(),
                                
                                Forms\Components\Select::make('status')
                                    ->options([
                                        'pending' => 'Pending',
                                        'processing' => 'Processing',
                                        'completed' => 'Completed',
                                        'cancelled' => 'Cancelled',
                                    ])
                                    ->required(),
                                
                                Forms\Components\Select::make('payment_status')
                                    ->options([
                                        'pending' => 'Pending',
                                        'paid' => 'Paid',
                                        'failed' => 'Failed',
                                        'refunded' => 'Refunded',
                                    ])
                                    ->required(),
                                
                                Forms\Components\TextInput::make('payment_method')
                                    ->maxLength(255),
                                
                                Forms\Components\TextInput::make('tracking_number')
                                    ->maxLength(255),
                            ])
                            ->columns(2),
                        
                        Forms\Components\Section::make('Order Items')
                            ->schema([
                                Forms\Components\Repeater::make('items')
                                    ->relationship()
                                    ->schema([
                                        Forms\Components\Select::make('product_id')
                                            ->label('Product')
                                            ->options(Product::query()->pluck('name', 'id'))
                                            ->searchable()
                                            ->required()
                                            ->reactive()
                                            ->afterStateUpdated(function ($state, callable $set) {
                                                if ($state) {
                                                    $product = Product::find($state);
                                                    if ($product) {
                                                        $set('price', $product->current_price);
                                                        $set('product_name', $product->name);
                                                    }
                                                }
                                            }),
                                        
                                        Forms\Components\TextInput::make('product_name')
                                            ->required()
                                            ->maxLength(255),
                                        
                                        Forms\Components\TextInput::make('quantity')
                                            ->numeric()
                                            ->required()
                                            ->default(1)
                                            ->minValue(1),
                                        
                                        Forms\Components\TextInput::make('price')
                                            ->label('Unit Price')
                                            ->numeric()
                                            ->required()
                                            ->prefix('$'),
                                    ])
                                    ->columns(2),
                            ]),
                    ])
                    ->columnSpan(2),
                
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('Order Summary')
                            ->schema([
                                Forms\Components\TextInput::make('shipping_cost')
                                    ->numeric()
                                    ->prefix('$')
                                    ->default(0),
                                
                                Forms\Components\TextInput::make('total_price')
                                    ->label('Total Amount')
                                    ->numeric()
                                    ->prefix('$')
                                    ->required(),
                                
                                Forms\Components\Textarea::make('notes')
                                    ->columnSpanFull(),
                            ]),
                        
                        Forms\Components\Section::make('Shipping Information')
                            ->schema([
                                Forms\Components\Select::make('shipping_method')
                                    ->options([
                                        'standard' => 'Standard Shipping',
                                        'express' => 'Express Shipping',
                                        'overnight' => 'Overnight Shipping',
                                    ]),
                                
                                Forms\Components\Select::make('shipping_address_id')
                                    ->label('Shipping Address')
                                    ->relationship('shippingAddress', 'address_line_1')
                                    ->searchable()
                                    ->preload()
                                    ->createOptionForm([
                                        Forms\Components\TextInput::make('first_name')
                                            ->required()
                                            ->maxLength(255),
                                        Forms\Components\TextInput::make('last_name')
                                            ->required()
                                            ->maxLength(255),
                                        Forms\Components\TextInput::make('address_line_1')
                                            ->required()
                                            ->maxLength(255),
                                        Forms\Components\TextInput::make('address_line_2')
                                            ->maxLength(255),
                                        Forms\Components\TextInput::make('city')
                                            ->required()
                                            ->maxLength(255),
                                        Forms\Components\TextInput::make('state')
                                            ->required()
                                            ->maxLength(255),
                                        Forms\Components\TextInput::make('postal_code')
                                            ->required()
                                            ->maxLength(255),
                                        Forms\Components\TextInput::make('country')
                                            ->required()
                                            ->maxLength(255),
                                        Forms\Components\TextInput::make('phone')
                                            ->tel()
                                            ->maxLength(255),
                                    ]),
                                
                                Forms\Components\Select::make('billing_address_id')
                                    ->label('Billing Address')
                                    ->relationship('billingAddress', 'address_line_1')
                                    ->searchable()
                                    ->preload()
                                    ->createOptionForm([
                                        Forms\Components\TextInput::make('first_name')
                                            ->required()
                                            ->maxLength(255),
                                        Forms\Components\TextInput::make('last_name')
                                            ->required()
                                            ->maxLength(255),
                                        Forms\Components\TextInput::make('address_line_1')
                                            ->required()
                                            ->maxLength(255),
                                        Forms\Components\TextInput::make('address_line_2')
                                            ->maxLength(255),
                                        Forms\Components\TextInput::make('city')
                                            ->required()
                                            ->maxLength(255),
                                        Forms\Components\TextInput::make('state')
                                            ->required()
                                            ->maxLength(255),
                                        Forms\Components\TextInput::make('postal_code')
                                            ->required()
                                            ->maxLength(255),
                                        Forms\Components\TextInput::make('country')
                                            ->required()
                                            ->maxLength(255),
                                        Forms\Components\TextInput::make('phone')
                                            ->tel()
                                            ->maxLength(255),
                                    ]),
                            ]),
                    ])
                    ->columnSpan(1),
            ])
            ->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('Order ID')
                    ->searchable(),
                
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Customer')
                    ->searchable()
                    ->sortable(),
                
                Tables\Columns\SelectColumn::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'processing' => 'Processing',
                        'completed' => 'Completed',
                        'cancelled' => 'Cancelled',
                    ])
                    ->sortable(),
                
                Tables\Columns\SelectColumn::make('payment_status')
                    ->options([
                        'pending' => 'Pending',
                        'paid' => 'Paid',
                        'failed' => 'Failed',
                        'refunded' => 'Refunded',
                    ])
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('total_price')
                    ->money('USD')
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'processing' => 'Processing',
                        'completed' => 'Completed',
                        'cancelled' => 'Cancelled',
                    ]),
                
                Tables\Filters\SelectFilter::make('payment_status')
                    ->options([
                        'pending' => 'Pending',
                        'paid' => 'Paid',
                        'failed' => 'Failed',
                        'refunded' => 'Refunded',
                    ]),
                
                Tables\Filters\Filter::make('created_at')
                    ->form([
                        Forms\Components\DatePicker::make('created_from'),
                        Forms\Components\DatePicker::make('created_until'),
                    ])
                    ->query(function ($query, array $data) {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn ($query) => $query->whereDate('created_at', '>=', $data['created_from']),
                            )
                            ->when(
                                $data['created_until'],
                                fn ($query) => $query->whereDate('created_at', '<=', $data['created_until']),
                            );
                    }),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\BulkAction::make('updateStatus')
                        ->label('Update Status')
                        ->icon('heroicon-o-truck')
                        ->requiresConfirmation()
                        ->form([
                            Forms\Components\Select::make('status')
                                ->options([
                                    'pending' => 'Pending',
                                    'processing' => 'Processing',
                                    'completed' => 'Completed',
                                    'cancelled' => 'Cancelled',
                                ])
                                ->required(),
                        ])
                        ->action(function ($records, $data) {
                            foreach ($records as $record) {
                                $record->status = $data['status'];
                                $record->save();
                            }
                        }),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}
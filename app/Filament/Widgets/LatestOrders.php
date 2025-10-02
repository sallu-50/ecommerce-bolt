<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestOrders extends BaseWidget
{
    protected static ?int $sort = 2;
    
    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Order::with(['user'])
                    ->latest()
                    ->limit(5)
            )
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('Order ID')
                    ->searchable(),
                    
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Customer'),
                    
                Tables\Columns\TextColumn::make('total_price')
                    ->money('USD')
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'completed' => 'success',
                        'processing' => 'info',
                        'pending' => 'warning',
                        'cancelled' => 'danger',
                    }),
                    
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime(),
            ])
            ->actions([
                Tables\Actions\Action::make('view')
                    ->url(fn (Order $record): string => route('filament.admin.resources.orders.edit', $record)),
            ]);
    }
}
<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Models\Category;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';

    protected static ?string $navigationGroup = 'Shop Management';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('Product Information')
                            ->schema([
                                Forms\Components\TextInput::make('name')
                                    ->required()
                                    ->maxLength(255)
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(fn (string $operation, $state, Forms\Set $set) => 
                                        $operation === 'create' ? $set('slug', Str::slug($state)) : null),
                                
                                Forms\Components\TextInput::make('slug')
                                    ->required()
                                    ->maxLength(255)
                                    ->unique(ignoreRecord: true),
                                
                                Forms\Components\Select::make('category_id')
                                    ->label('Category')
                                    ->options(Category::query()->pluck('name', 'id'))
                                    ->searchable(),
                                
                                Forms\Components\RichEditor::make('description')
                                    ->columnSpanFull(),
                            ])
                            ->columns(2),
                            
                        Forms\Components\Section::make('Pricing & Inventory')
                            ->schema([
                                Forms\Components\TextInput::make('price')
                                    ->numeric()
                                    ->required()
                                    ->prefix('$'),
                                    
                                Forms\Components\TextInput::make('sale_price')
                                    ->numeric()
                                    ->prefix('$')
                                    ->nullable(),
                                    
                                Forms\Components\TextInput::make('quantity')
                                    ->numeric()
                                    ->required()
                                    ->default(0),
                                    
                                Forms\Components\Select::make('status')
                                    ->options([
                                        'active' => 'Active',
                                        'inactive' => 'Inactive',
                                        'draft' => 'Draft'
                                    ])
                                    ->default('active')
                                    ->required(),
                            ])
                            ->columns(2),
                    ])
                    ->columnSpan(2),
                
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('Product Image')
                            ->schema([
                                Forms\Components\FileUpload::make('image')
                                    ->image()
                                    ->directory('product-images')
                                    ->preserveFilenames()
                                    ->maxSize(5120)
                                    ->imagePreviewHeight('250')
                                    ->loadingIndicatorPosition('left')
                                    ->panelAspectRatio('4:3')
                                    ->panelLayout('integrated')
                                    ->removeUploadedFileButtonPosition('right')
                                    ->uploadButtonPosition('left')
                                    ->uploadProgressIndicatorPosition('left'),
                            ]),
                            
                        Forms\Components\Section::make('Product Status')
                            ->schema([
                                Forms\Components\Toggle::make('featured')
                                    ->label('Featured Product')
                                    ->helperText('Featured products are displayed prominently on the homepage.')
                                    ->default(false),
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
                Tables\Columns\ImageColumn::make('image')
                    ->label('Image')
                    ->square(),
                    
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('category.name')
                    ->label('Category')
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('price')
                    ->money('USD')
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('sale_price')
                    ->money('USD')
                    ->label('Sale Price')
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('quantity')
                    ->sortable(),
                    
                Tables\Columns\IconColumn::make('featured')
                    ->boolean()
                    ->sortable(),
                    
                Tables\Columns\SelectColumn::make('status')
                    ->options([
                        'active' => 'Active',
                        'inactive' => 'Inactive',
                        'draft' => 'Draft'
                    ])
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'active' => 'Active',
                        'inactive' => 'Inactive',
                        'draft' => 'Draft'
                    ]),
                    
                Tables\Filters\SelectFilter::make('category_id')
                    ->label('Category')
                    ->options(Category::query()->pluck('name', 'id')),
                    
                Tables\Filters\Filter::make('featured')
                    ->query(fn (Builder $query): Builder => $query->where('featured', true))
                    ->toggle(),
                    
                Tables\Filters\Filter::make('low_stock')
                    ->query(fn (Builder $query): Builder => $query->where('quantity', '<', 10))
                    ->toggle(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\BulkAction::make('toggleFeatured')
                        ->label('Toggle Featured')
                        ->icon('heroicon-o-star')
                        ->action(function ($records) {
                            foreach ($records as $record) {
                                $record->featured = !$record->featured;
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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Filament\Resources\OrderResource\RelationManagers;
use App\Models\Order;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';
    
    protected static ?string $navigationLabel = 'Orders';
    
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Order Information')
                    ->schema([
                        Forms\Components\TextInput::make('order_number')
                            ->required()
                            ->disabled()
                            ->dehydrated(),
                        Forms\Components\Select::make('status')
                            ->required()
                            ->options([
                                'pending' => 'Pending',
                                'processing' => 'Processing',
                                'completed' => 'Completed',
                                'cancelled' => 'Cancelled',
                            ])
                            ->default('pending'),
                        Forms\Components\Select::make('payment_method')
                            ->required()
                            ->options([
                                'cash_on_delivery' => 'Cash on Delivery',
                                'online' => 'Online Payment',
                            ])
                            ->default('cash_on_delivery'),
                    ])->columns(3),
                
                Forms\Components\Section::make('Customer Information')
                    ->schema([
                        Forms\Components\TextInput::make('customer_name')
                            ->required(),
                        Forms\Components\TextInput::make('customer_email')
                            ->email()
                            ->required(),
                        Forms\Components\TextInput::make('customer_phone')
                            ->tel()
                            ->required(),
                        Forms\Components\Textarea::make('customer_address')
                            ->required()
                            ->rows(2)
                            ->columnSpanFull(),
                        Forms\Components\TextInput::make('customer_city')
                            ->required(),
                        Forms\Components\TextInput::make('customer_postal_code'),
                    ])->columns(2),
                
                Forms\Components\Section::make('Order Totals')
                    ->schema([
                        Forms\Components\TextInput::make('subtotal')
                            ->required()
                            ->numeric()
                            ->prefix('৳')
                            ->disabled()
                            ->dehydrated(),
                        Forms\Components\TextInput::make('tax')
                            ->required()
                            ->numeric()
                            ->prefix('৳')
                            ->default(0),
                        Forms\Components\TextInput::make('shipping')
                            ->required()
                            ->numeric()
                            ->prefix('৳')
                            ->default(0),
                        Forms\Components\TextInput::make('total')
                            ->required()
                            ->numeric()
                            ->prefix('৳')
                            ->disabled()
                            ->dehydrated(),
                    ])->columns(4),
                
                Forms\Components\Section::make('Additional Information')
                    ->schema([
                        Forms\Components\Textarea::make('notes')
                            ->rows(3)
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('order_number')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->label('Order #'),
                Tables\Columns\TextColumn::make('customer_name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('customer_email')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('customer_phone')
                    ->searchable(),
                Tables\Columns\TextColumn::make('total')
                    ->formatStateUsing(fn (string $state): string => '৳' . number_format($state))
                    ->sortable(),
                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'warning' => 'pending',
                        'primary' => 'processing',
                        'success' => 'completed',
                        'danger' => 'cancelled',
                    ])
                    ->sortable(),
                Tables\Columns\TextColumn::make('payment_method')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => ucwords(str_replace('_', ' ', $state)))
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->label('Order Date'),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'processing' => 'Processing',
                        'completed' => 'Completed',
                        'cancelled' => 'Cancelled',
                    ]),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\ItemsRelationManager::class,
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

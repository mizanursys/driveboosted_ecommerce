<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CouponResource\Pages;
use App\Models\Coupon;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class CouponResource extends Resource
{
    protected static ?string $model = Coupon::class;

    protected static ?string $navigationIcon = 'heroicon-o-ticket';
    protected static ?string $navigationGroup = 'Shop Management';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Card::make()
                    ->schema([
                        Forms\Components\TextInput::make('code')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->uppercase(),
                        Forms\Components\Select::make('type')
                            ->options([
                                'fixed' => 'Fixed Amount',
                                'percentage' => 'Percentage',
                            ])
                            ->required(),
                        Forms\Components\TextInput::make('value')
                            ->numeric()
                            ->required(),
                        Forms\Components\DateTimePicker::make('starts_at'),
                        Forms\Components\DateTimePicker::make('expires_at'),
                        Forms\Components\TextInput::make('usage_limit')
                            ->numeric()
                            ->helperText('Null for unlimited'),
                        Forms\Components\Toggle::make('is_active')
                            ->default(true),
                    ])->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('code')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\BadgeColumn::make('type')
                    ->colors([
                        'primary' => 'fixed',
                        'success' => 'percentage',
                    ]),
                Tables\Columns\TextColumn::make('value')
                    ->formatStateUsing(fn ($state, $record) => $record->type === 'percentage' ? $state . '%' : '৳' . number_format($state)),
                Tables\Columns\TextColumn::make('expires_at')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('used_count')
                    ->label('Usage')
                    ->formatStateUsing(fn ($state, $record) => $state . ($record->usage_limit ? ' / ' . $record->usage_limit : '')),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean(),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCoupons::route('/'),
            'create' => Pages\CreateCoupon::route('/create'),
            'edit' => Pages\EditCoupon::route('/{record}/edit'),
        ];
    }
}

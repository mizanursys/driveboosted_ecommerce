<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AppointmentResource\Pages;
use App\Filament\Resources\AppointmentResource\RelationManagers;
use App\Models\Appointment;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AppointmentResource extends Resource
{
    protected static ?string $model = Appointment::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Customer Information')
                    ->schema([
                        Forms\Components\TextInput::make('customer_name')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('customer_phone')
                            ->tel()
                            ->required()
                            ->maxLength(255),
                    ])->columns(2),

                Forms\Components\Section::make('Vehicle Information')
                    ->schema([
                        Forms\Components\TextInput::make('vehicle_make')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('vehicle_model')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('vehicle_type')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('licence_plate')
                            ->maxLength(255),
                    ])->columns(2),

                Forms\Components\Section::make('Schedule & Services')
                    ->schema([
                        Forms\Components\Select::make('services')
                            ->multiple()
                            ->relationship('services', 'name')
                            ->required()
                            ->searchable()
                            ->preload(),
                        Forms\Components\DateTimePicker::make('appointment_date')
                            ->required()
                            ->native(false),
                        Forms\Components\Select::make('status')
                            ->options([
                                'pending' => 'Pending',
                                'confirmed' => 'Confirmed',
                                'completed' => 'Completed',
                                'cancelled' => 'Cancelled',
                            ])
                            ->required()
                            ->default('pending'),
                        Forms\Components\Textarea::make('notes')
                            ->maxLength(65535)
                            ->columnSpanFull(),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('services.name')
                    ->label('Services')
                    ->badge()
                    ->searchable(),
                Tables\Columns\TextColumn::make('customer_name')
                    ->searchable()
                    ->description(fn (Appointment $record): string => $record->customer_phone),
                Tables\Columns\TextColumn::make('vehicle_make')
                    ->label('Make')
                    ->searchable(),
                Tables\Columns\TextColumn::make('vehicle_model')
                    ->label('Model')
                    ->searchable(),
                Tables\Columns\TextColumn::make('licence_plate')
                    ->label('Plate')
                    ->searchable(),
                Tables\Columns\TextColumn::make('appointment_date')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                        'confirmed' => 'success',
                        'completed' => 'info',
                        'cancelled' => 'danger',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->with(['services']);
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
            'index' => Pages\ListAppointments::route('/'),
            'create' => Pages\CreateAppointment::route('/create'),
            'edit' => Pages\EditAppointment::route('/{record}/edit'),
        ];
    }
}

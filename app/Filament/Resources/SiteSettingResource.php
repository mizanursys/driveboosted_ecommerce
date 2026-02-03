<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SiteSettingResource\Pages;
use App\Filament\Resources\SiteSettingResource\RelationManagers;
use App\Models\SiteSetting;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SiteSettingResource extends Resource
{
    protected static ?string $model = SiteSetting::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Header & Footer')
                    ->schema([
                        Forms\Components\TextInput::make('announcement_text')
                            ->label('Top Bar Announcement')
                            ->columnSpanFull(),
                        Forms\Components\Textarea::make('marquee_text')
                            ->label('Scrolling Marquee (Bar below Hero)'),
                        Forms\Components\Textarea::make('footer_description')
                            ->columnSpanFull(),
                    ]),

                Forms\Components\Section::make('Homepage Showcase')
                    ->description('The split section with Image and "Engineered Precision" text')
                    ->schema([
                        Forms\Components\FileUpload::make('showcase_image')
                            ->image()
                            ->columnSpanFull(),
                        Forms\Components\TextInput::make('showcase_title'),
                        Forms\Components\Textarea::make('showcase_description')
                            ->columnSpanFull(),
                        Forms\Components\TextInput::make('showcase_btn_text'),
                        Forms\Components\TextInput::make('showcase_btn_link'),
                    ])->columns(2),

                Forms\Components\Section::make('Homepage Stats')
                    ->schema([
                        Forms\Components\TextInput::make('stats_1_value')->label('Stat 1 Value'),
                        Forms\Components\TextInput::make('stats_1_label')->label('Stat 1 Label'),
                        Forms\Components\TextInput::make('stats_2_value')->label('Stat 2 Value'),
                        Forms\Components\TextInput::make('stats_2_label')->label('Stat 2 Label'),
                        Forms\Components\TextInput::make('stats_3_value')->label('Stat 3 Value'),
                        Forms\Components\TextInput::make('stats_3_label')->label('Stat 3 Label'),
                        Forms\Components\TextInput::make('stats_4_value')->label('Stat 4 Value'),
                        Forms\Components\TextInput::make('stats_4_label')->label('Stat 4 Label'),
                    ])->columns(2),

                Forms\Components\Section::make('Contact & Social')
                    ->schema([
                        Forms\Components\TextInput::make('contact_phone'),
                        Forms\Components\TextInput::make('contact_email'),
                        Forms\Components\TextInput::make('social_facebook'),
                        Forms\Components\TextInput::make('social_instagram'),
                        Forms\Components\TextInput::make('social_youtube'),
                        Forms\Components\TextInput::make('social_tiktok'),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('announcement_text')->limit(30),
                Tables\Columns\TextColumn::make('contact_email'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                // Limit creation/deletion to prevent accidents
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
            'index' => Pages\ListSiteSettings::route('/'),
            'create' => Pages\CreateSiteSetting::route('/create'),
            'edit' => Pages\EditSiteSetting::route('/{record}/edit'),
        ];
    }
}

<?php

namespace App\Filament\User\Resources;

use App\Filament\User\Resources\TeleReportResource\Pages;
use App\Filament\User\Resources\TeleReportResource\RelationManagers;
use App\Models\TeleReport;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TeleReportResource extends Resource
{
    protected static ?string $model = TeleReport::class;

    protected static ?string $navigationIcon = 'heroicon-o-computer-desktop';

    protected static bool $shouldRegisterNavigation = false;

    protected static ?string $modelLabel = 'Telecommuting Report';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
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

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTeleReports::route('/'),
            'create' => Pages\CreateTeleReport::route('/create'),
            'edit' => Pages\EditTeleReport::route('/{record}/edit'),
        ];
    }
}

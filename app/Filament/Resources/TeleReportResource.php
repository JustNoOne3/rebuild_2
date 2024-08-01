<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TeleReportResource\Pages;
use App\Filament\Resources\TeleReportResource\RelationManagers;
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

    protected static ?string $navigationIcon = 'heroicon-o-newspaper';

    protected static ?string $modelLabel = 'Telecommuting Report';

    protected static ?string $navigationLabel = 'Telecommuting Reports';

    protected static ?string $navigationGroup = 'Reports';

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
            ])
            ->emptyStateHeading('Empty')
            ->emptyStateDescription('There is no Report Data yet')
            ->emptyStateIcon('heroicon-o-bookmark');
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

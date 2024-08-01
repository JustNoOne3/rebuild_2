<?php

namespace App\Filament\Resources;

use App\Filament\Resources\WairResource\Pages;
use App\Filament\Resources\WairResource\RelationManagers;
use App\Models\Wair;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class WairResource extends Resource
{
    protected static ?string $model = Wair::class;

    protected static ?string $navigationIcon = 'heroicon-o-shield-exclamation';

    protected static ?string $modelLabel = 'Workplace Accident / Illness Report';

    protected static ?string $navigationLabel = 'Workplace Accident / Illness Reports';

    protected static ?string $navigationGroup = 'Reports';

    protected static bool $shouldRegisterNavigation = true;

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
            'index' => Pages\ListWairs::route('/'),
            'create' => Pages\CreateWair::route('/create'),
            'edit' => Pages\EditWair::route('/{record}/edit'),
        ];
    }
}

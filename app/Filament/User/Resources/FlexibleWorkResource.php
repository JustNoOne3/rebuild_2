<?php

namespace App\Filament\User\Resources;

use App\Filament\User\Resources\FlexibleWorkResource\Pages;
use App\Filament\User\Resources\FlexibleWorkResource\RelationManagers;
use App\Models\FlexibleWork;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class FlexibleWorkResource extends Resource
{
    protected static ?string $model = FlexibleWork::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static bool $shouldRegisterNavigation = false;

    protected static ?string $modelLabel = 'Flexible Work Arrangement / Alternative Work Scheme';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Forms\Components\DatePicker::make('fwa_startDate'),
                // Forms\Components\DatePicker::make('fwa_endDate'),
                // Forms\Components\TextInput::make('fwa_type')
                //     ->maxLength(255),
                // Forms\Components\TextInput::make('fwa_typeSpecify')
                //     ->maxLength(255),
                // Forms\Components\TextInput::make('fwa_reason')
                //     ->maxLength(255),
                // Forms\Components\TextInput::make('fwa_reasonSpecify')
                //     ->maxLength(255),
                // Forms\Components\TextInput::make('fwa_affectedWorkers'),
                // Forms\Components\TextInput::make('fwa_agreement')
                //     ->maxLength(255),
                // Forms\Components\TextInput::make('fwa_owner')
                //     ->maxLength(255),
                // Forms\Components\TextInput::make('fwa_designation')
                //     ->maxLength(255),
                // Forms\Components\TextInput::make('fwa_contact')
                //     ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('fwa_startDate')
                    ->date()
                    ->label('Effectivity Date')
                    ->sortable(),
                Tables\Columns\TextColumn::make('fwa_endDate')
                    ->date()
                    ->label('End Date')
                    ->sortable(),
                Tables\Columns\TextColumn::make('fwa_type')
                    ->label('Type of FWA / AWS')
                    ->searchable(),
                Tables\Columns\TextColumn::make('fwa_reason')
                    ->label('Cause')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
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
            'index' => Pages\ListFlexibleWorks::route('/'),
            'create' => Pages\CreateFlexibleWork::route('/create'),
            'edit' => Pages\EditFlexibleWork::route('/{record}/edit'),
        ];
    }
}

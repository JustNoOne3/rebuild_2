<?php

namespace App\Filament\User\Resources;

use App\Filament\User\Resources\WairResource\Pages;
use App\Filament\User\Resources\WairResource\RelationManagers;
use App\Models\Wair;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\TextColumn;
use Filament\Support\Enums\FontWeight;
use Illuminate\Support\Facades\Auth;

class WairResource extends Resource
{
    protected static ?string $model = Wair::class;

    protected static ?string $navigationIcon = 'heroicon-o-shield-exclamation';

    protected static ?string $modelLabel = 'Workplace Accident / Illness Report';

    protected static bool $shouldRegisterNavigation = false;

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
            ->query(fn (Wair $wair) => $wair
                ->where('wairs_estabId', Auth::user()->est_id)
            )
            ->columns([
                TextColumn::make('wairs_reportType')
                    ->label('Report Submitted')
                    ->weight(FontWeight::Bold)
                    ->color(fn (string $state): string => match ($state) {
                        'Accident Report' => 'warning',
                        'Illness Report' => 'primary',
                        'Accident and Illness Report' => 'danger',
                        'No Incident of Illness/Accident Report' => 'success',
                    }),
                TextColumn::make('created_at')
                    ->label('Date Submitted'),
                // TextColumn::make('wairs_affectedWorkers'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\Action::make('form-1')
                    ->color('primary')
                    ->label('View Form 1')
                    ->button()
                    // ->action(function (Get $get){
                    //     $temp = Temp::query()->where('id', $get('wair_reportTypeId'))->pluck(['ar_owner', 'ar_nationality', 'ar_dateTime', 'created_at']);
                    //     try{

                    //     }catch(Exceptioon $e){

                    //     }
                    //     return ;
                    // })
                    ,
                Tables\Actions\Action::make('form-2')
                    ->color('success')
                    ->label('View Form 2')
                    ->button()
                    ->action(function (){
                        return ;
                    }),
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
            'index' => Pages\ListWairs::route('/'),
        ];
    }
}

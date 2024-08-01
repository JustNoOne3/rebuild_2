<?php

namespace App\Filament\User\Resources;

use App\Filament\User\Resources\Month13thResource\Pages;
use App\Filament\User\Resources\Month13thResource\RelationManagers;
use App\Models\Month13th;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Section;
use App\Models\Establishment;
use App\Models\Geocode;
use Filament\Forms\Components\Wizard;
use Illuminate\Support\HtmlString;
use Filament\Forms\Set;
use Filament\Forms\Get;
use Illuminate\Support\Facades\Blade;

use Filament\Tables\Columns\TextColumn;

class Month13thResource extends Resource
{
    protected static ?string $model = Month13th::class;

    protected static ?string $navigationIcon = 'heroicon-o-gift';

    protected static bool $shouldRegisterNavigation = false;

    protected static ?string $modelLabel = '13th Month Report';

    public static function table(Table $table): Table
    {
        return $table
            ->query(fn (Month13th $month13th) => $month13th
                    ->where('month13th_estabId', Auth::user()->est_id)
                )
            ->columns([
                TextColumn::make('month13th_yearCovered')
                    ->label('Year Covered'),
                TextColumn::make('month13th_numWorkers')
                    ->label('Total Workers Benefitted'),
                TextColumn::make('month13th_amount')
                    ->label('Total Amount Granted'),
                TextColumn::make('created_at')
                    ->label('Date Submitted'),
            ])
            ->filters([
                //
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->query()
            ->schema([
                Wizard::make([
                    Wizard\Step::make('Report Details')
                        ->schema([
                            Section::make()
                                ->columns(3)
                                ->schema([
                                    Forms\Components\Select::make('month13th_yearCovered')
                                        ->label('Year Covered by Report')
                                        ->placeholder('Select a year covered by this report.')
                                        ->options(function (){
                                            $currentYear = now()->year;
                                            $years = range(2019, $currentYear);
                                            return $years;
                                        })
                                        ->native(false)
                                        ->columnSpan(1)
                                        
                                        ->required(),
                                    Forms\Components\TextInput::make('month13th_numWorkers')
                                        ->label('Total Number of Workers Benifited')
                                        ->columnSpan(1)
                                        ->live()
                                        ->afterStateUpdated(function (Set $set){
                                            $estab = Establishment::query()->where('est_id', Auth::user()->est_id)->first();
                                            $set('estabName', $estab->est_name);
                                            $set('street', $estab->est_street);
                                            $set('region', Geocode::query()->where('geo_id', $estab->region_id)->value('geo_name'));
                                            $set('province', Geocode::query()->where('geo_id', $estab->province_id)->value('geo_name'));
                                            $set('city', Geocode::query()->where('geo_id', $estab->city_id)->value('geo_name'));
                                            $set('barangay', Geocode::query()->where('geo_id', $estab->barangay_id)->value('geo_name'));
                                            $set('natureBusiness', $estab->est_nature);
                                            $set('maleWorkers', $estab->est_numworkMale);
                                            $set('femaleWorkers', $estab->est_numworkFemale);
                                            $set('managerial', $estab->est_numworkManager);
                                            $set('supervisory', $estab->est_numworkSupervisor);
                                            $set('rankFile', $estab->est_numworkRanks);
                                            $set('totalEmployees', $estab->est_numworkTotal);
                                        })
                                        ->required(),
                                    Forms\Components\TextInput::make('month13th_amount')
                                        ->label('Total Amount of Benefits Granted')
                                        ->columnSpan(1)
                                        ->required(),
                                    Forms\Components\TextInput::make('month13th_ownRep')
                                        ->label('Name of Employer\'s Representative')
                                        ->columnSpan(1)
                                        ->required(),
                                    Forms\Components\TextInput::make('month13th_designation')
                                        ->label('Designation ')
                                        ->columnSpan(1)
                                        ->required(),
                                    Forms\Components\TextInput::make('month13th_contact')
                                        ->label('Contact Number')
                                        ->columnSpan(1)
                                        ->required(),
                                ]),
                        ]),
                    Wizard\Step::make('Amount range and Number of Workers')
                        ->schema([
                            Section::make()
                                ->columns(2)
                                ->schema([
                                    Section::make()
                                        ->columnSpan(1)
                                        ->schema([
                                            Forms\Components\TextInput::make('month13th_lessFive')
                                                ->label('< Php 5,000.00')
                                                ->integer()
                                                ->default(0)
                                                ->inlineLabel(),
                                            Forms\Components\TextInput::make('month13th_fiveTen')
                                                ->label('Php 5,001.00 - Php 10,000.00')
                                                ->integer()
                                                ->default(0)
                                                ->inlineLabel(),
                                            Forms\Components\TextInput::make('month13th_tenTwenty')
                                                ->label('Php 10,001.00 - Php 20,000.00')
                                                ->integer()
                                                ->default(0)
                                                ->inlineLabel(),
                                            Forms\Components\TextInput::make('month13th_twentyThirty')
                                                ->label('Php 20,001.00 - Php 30,000.00 ')
                                                ->integer()
                                                ->default(0)
                                                ->inlineLabel(),
                                            Forms\Components\TextInput::make('month13th_thirtyForty')
                                                ->label('Php 30,001.00 - Php 40,000.00 ')
                                                ->integer()
                                                ->default(0)
                                                ->inlineLabel(),
                                            Forms\Components\TextInput::make('month13th_fortyFifty')
                                                ->label('Php 40,001.00 - Php 50,000.00')
                                                ->integer()
                                                ->default(0)
                                                ->required()
                                                ->inlineLabel(),
                                        ]),
                                    Section::make()
                                        ->columnSpan(1)
                                        ->schema([
                                            Forms\Components\TextInput::make('month13th_fiftySixty')
                                                ->label('Php 50,001.00 - Php 60,000.00')
                                                ->integer()
                                                ->default(0)
                                                ->required()
                                                ->inlineLabel(),
                                            Forms\Components\TextInput::make('month13th_sixtySeventy')
                                                ->label('Php 60,001.00 - Php 70,000.00 ')
                                                ->integer()
                                                ->default(0)
                                                ->required()
                                                ->inlineLabel(),
                                            Forms\Components\TextInput::make('month13th_seventyEighty')
                                                ->label('Php 70,001.00 - Php 80,000.00 ')
                                                ->integer()
                                                ->default(0)
                                                ->required()
                                                ->inlineLabel(),
                                            Forms\Components\TextInput::make('month13th_eightyNinety')
                                                ->label('Php 80,001.00 - Php 90,000.00')
                                                ->integer()
                                                ->default(0)
                                                ->required()
                                                ->inlineLabel(),
                                            Forms\Components\TextInput::make('month13th_ninetyHundred')
                                                ->label('Php 90,001.00 - Php 100,000.00')
                                                ->integer()
                                                ->default(0)
                                                ->required()
                                                ->inlineLabel(),
                                            Forms\Components\TextInput::make('month13th_moreHundred')
                                                ->label('> Php 100,001.00')
                                                ->integer()
                                                ->default(0)
                                                ->required()
                                                ->inlineLabel(),
                                        ]),
                                ])
                        ]),
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////// R E V I E W ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////// R E V I E W //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////// R E V I E W /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////// R E V I E W /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////// R E V I E W ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////// R E V I E W ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////// R E V I E W ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

                    Wizard\Step::make('Review')
                        ->schema([
                            Section::make('Report Details')
                                ->columns(3)
                                ->schema([
                                    Forms\Components\TextInput::make('month13th_yearCovered')
                                        ->readOnly(),
                                    Forms\Components\TextInput::make('month13th_numWorkers')
                                        ->readOnly(),
                                    Forms\Components\TextInput::make('month13th_amount')
                                        ->readOnly(),
                                    Forms\Components\TextInput::make('month13th_ownRep')
                                        ->readOnly(),
                                    Forms\Components\TextInput::make('month13th_designation')
                                        ->readOnly(),
                                    Forms\Components\TextInput::make('month13th_contact')
                                        ->readOnly(),
                                ]),
                            Section::make('Affect Workers')
                                ->columns(2)
                                ->schema([
                                    Section::make()
                                        ->columnSpan(1)
                                        ->schema([
                                            Forms\Components\TextInput::make('month13th_lessFive')
                                                ->readOnly()
                                                ->inlineLabel()
                                                ->label('< Php 5,000.00'),
                                            Forms\Components\TextInput::make('month13th_fiveTen')
                                                ->readOnly()
                                                ->inlineLabel()
                                                ->label('Php 5,001.00 - Php 10,000.00'),
                                            Forms\Components\TextInput::make('month13th_tenTwenty')
                                                ->readOnly()
                                                ->inlineLabel()
                                                ->label('Php 10,001.00 - Php 20,000.00'),
                                            Forms\Components\TextInput::make('month13th_twentyThirty')
                                                ->readOnly()
                                                ->inlineLabel()
                                                ->label('Php 20,001.00 - Php 30,000.00'),
                                            Forms\Components\TextInput::make('month13th_thirtyForty')
                                                ->readOnly()
                                                ->inlineLabel()
                                                ->label('Php 30,001.00 - Php 40,000.00'),
                                            Forms\Components\TextInput::make('month13th_fortyFifty')
                                                ->readOnly()
                                                ->inlineLabel()
                                                ->label('Php 40,001.00 - Php 50,000.00'),
                                        ]),
                                    Section::make()
                                        ->columnSpan(1)
                                        ->schema([
                                            Forms\Components\TextInput::make('month13th_fiftySixty')
                                                ->readOnly()
                                                ->inlineLabel()
                                                ->label('Php 50,001.00 - Php 60,000.00'),
                                            Forms\Components\TextInput::make('month13th_sixtySeventy')
                                                ->readOnly()
                                                ->inlineLabel()
                                                ->label('Php 60,001.00 - Php 70,000.00'),
                                            Forms\Components\TextInput::make('month13th_seventyEighty')
                                                ->readOnly()
                                                ->inlineLabel()
                                                ->label('Php 70,001.00 - Php 80,000.00'),
                                            Forms\Components\TextInput::make('month13th_eightyNinety')
                                                ->readOnly()
                                                ->inlineLabel()
                                                ->label('Php 80,001.00 - Php 90,000.00'),
                                            Forms\Components\TextInput::make('month13th_ninetyHundred')
                                                ->readOnly()
                                                ->inlineLabel()
                                                ->label('Php 90,001.00 - Php 100,000.00'),
                                            Forms\Components\TextInput::make('month13th_moreHundred')
                                                ->readOnly()
                                                ->inlineLabel()
                                                ->label('> Php 100,001.00'),
                                        ]),
                                ]),
                            Section::make()
                                ->schema([
                                    Forms\Components\TextInput::make('estabName')
                                        ->label('Establishment Name')
                                        ->readOnly(),
                                        ]),
                            Section::make('Location')
                                ->columns(2)
                                ->schema([
                                    Forms\Components\TextInput::make('street')
                                        ->readOnly()
                                        ->label("Floor / Bldg. No. / Street / Subdivision"),
                                    Forms\Components\TextInput::make('region')
                                        ->readOnly()
                                        ->label("Region"),
                                    Forms\Components\TextInput::make('province')
                                        ->readOnly()
                                        ->label("Province"),
                                    Forms\Components\TextInput::make('city')
                                        ->readOnly()
                                        ->label("Municipality / City"),
                                    Forms\Components\TextInput::make('barangay')
                                        ->readOnly()
                                        ->label("Barangay"),
                                    
                                ]),
                            Section::make()
                                ->schema([
                                    Forms\Components\TextInput::make('natureBusiness')
                                        ->readOnly()
                                        ->label("Nature of Business"),
                                ]),
                            Section::make('Current Workers')
                                ->columns(2)
                                ->schema([
                                    Section::make()
                                        ->columnSpan(1)
                                        ->schema([
                                            Forms\Components\TextInput::make('maleWorkers')
                                                ->label('Male Workers')
                                                ->readOnly(),
                                            Forms\Components\TextInput::make('femaleWorkers')
                                                ->label('Female Workers')
                                                ->readOnly(),
                                        ]),
                                    Section::make()
                                        ->columnSpan(1)
                                        ->schema([
                                            Forms\Components\TextInput::make('managerial')
                                                ->label('Managerial Position')
                                                ->readOnly(),
                                            Forms\Components\TextInput::make('supervisory')
                                                ->label('Supervisorial Position')
                                                ->readOnly(),
                                            Forms\Components\TextInput::make('rankFile')
                                                ->label('Rank and File')
                                                ->readOnly(),
                                        ]),
                                    Section::make()
                                        ->columnSpan(2)
                                        ->schema([
                                            Forms\Components\TextInput::make('totalEmployees')
                                            ->label('Total Employees')
                                            ->readOnly(),
                                        ]),
                                    Section::make()
                                        ->description('By clicking submit, you are agreeing to the Terms and Conditions.')
                                        ->schema([
                                            Forms\Components\Checkbox::make('Terms')
                                                ->label('I hereby certify that the data provided by me for this online registration is true, accurate and correct to the latest business data.
                                                I further understand that any false statements may result in the denial of application for registration.')
                                                ->accepted()
                                        ]),
                                ]),
                        ]),
                ])
                ->columnSpanFull()
                ->submitAction(new HtmlString(Blade::render(<<<BLADE
                    <x-filament::button color="success" icon="heroicon-o-check" tag="button" type="submit" size="lg" >
                        Submit
                        <svg fill="none" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" class="animate-spin fi-btn-icon transition duration-75 h-5 w-5 text-white" wire:loading.delay.default="" wire:target="dispatchFormEvent">
                            <path clip-rule="evenodd" d="M12 19C15.866 19 19 15.866 19 12C19 8.13401 15.866 5 12 5C8.13401 5 5 8.13401 5 12C5 15.866 8.13401 19 12 19ZM12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z" fill-rule="evenodd" fill="currentColor" opacity="0.2"></path>
                            <path d="M2 12C2 6.47715 6.47715 2 12 2V5C8.13401 5 5 8.13401 5 12H2Z" fill="currentColor"></path>
                        </svg>
                    </x-filament::button>
                BLADE))),
                
                
            ])
            
            ;
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
            'index' => Pages\ListMonth13ths::route('/'),
            'create' => Pages\CreateMonth13th::route('/create'),
            'edit' => Pages\EditMonth13th::route('/{record}/edit'),
            // 'submit' => Pages\Month13thSubmit::route('/'),
        ];
    }
}

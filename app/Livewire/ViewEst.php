<?php

namespace App\Livewire;

use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Infolists\Concerns\InteractsWithInfolists;
use Filament\Infolists\Contracts\HasInfolists;
use Filament\Infolists\Infolist;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Establishment;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\Grid;
use App\Models\Geocode;


class ViewEst extends Component implements HasForms, HasInfolists
{
    use InteractsWithInfolists;
    use InteractsWithForms;

    public function render()
    {
        return view('livewire.view-est');
    }

    public function estInfolist(Infolist $infolist): Infolist
    {
        if(Auth::user()->est_id === null){
            echo' <script>window.location.href = "register-est"</script>';
        }
        $this->record = Establishment::query()->where('est_id', Auth::user()->est_id)->first();
        return $infolist
            ->record($this->record)
            ->schema([
                Grid::make(2)
                ->schema([
                    Section::make('')
                        ->columnSpan(1)
                        ->schema([
                            TextEntry::make('est_name')
                                ->color('warning')
                                ->label('Establishment Name'),
                        ]),
                    Section::make('')
                        ->columnSpan(1)
                        ->columns(2)
                        ->heading('Establishment Address')
                        ->schema([
                            TextEntry::make('est_street')
                                ->color('warning')
                                ->label('Street'),
                            TextEntry::make('region_id')
                                ->color('warning')
                                ->label('Region')
                                ->state(function (Establishment $record) {
                                    $num = intval($record->region_id);
                                    return Geocode::query()
                                                ->where('geo_id', $num)
                                                ->value('geo_name');
                                }),
                            TextEntry::make('province_id')
                                ->color('warning')
                                ->label('Province')
                                ->state(function (Establishment $record) {
                                    $num = intval($record->province_id);
                                    return Geocode::query()
                                                ->where('geo_id', $num)
                                                ->value('geo_name');
                                }),
                            TextEntry::make('city_id')
                                ->color('warning')
                                ->label('City / Municipality')
                                ->state(function (Establishment $record) {
                                    $num = intval($record->city_id);
                                    return Geocode::query()
                                                ->where('geo_id', $num)
                                                ->value('geo_name');
                                }),
                            TextEntry::make('barangay_id')
                                ->color('warning')
                                ->label('Barrangay')
                                ->state(function (Establishment $record) {
                                    $num = intval($record->barangay_id);
                                    return Geocode::query()
                                                ->where('geo_id', $num)
                                                ->value('geo_name');
                                }),
                        ]),
                    Section::make('')
                        ->heading('Business Details')
                        ->schema([
                            TextEntry::make('est_nature')
                                ->color('warning')
                                ->label('Nature of Business'),
                            TextEntry::make('est_products')
                                ->color('warning')
                                ->label('Products'),
                            TextEntry::make('est_class')
                                ->color('warning')
                                ->label('Business Classification'),
                        ]),
                    Section::make('')
                        ->heading('Other Details')
                        ->schema([
                            TextEntry::make('est_tin')
                                ->color('warning')
                                ->label('Company TIN'),
                            TextEntry::make('est_sss')
                                ->color('warning')
                                ->label('Company SSS'),
                            Section::make('')
                                ->schema([
                                    TextEntry::make('est_payment')
                                        ->color('warning')
                                        ->label('Method of Payment to Employees'),
                                    TextEntry::make('est_yearImplemented')
                                        ->color('warning')
                                        ->label('Year the Payment Method was Implemented'),
                                ]),
                        ]),
                    Section::make('')
                        ->heading('Number of Employees')
                        ->columns(2)
                        ->schema([
                            Section::make('')
                                ->columnSpan(1)
                                ->schema([
                                    TextEntry::make('est_numworkMale')
                                        ->color('warning')
                                        ->label('Total Male Workers/Employees'),
                                    TextEntry::make('est_numworkFemale')
                                        ->color('warning')
                                        ->label('Total Female Workers/Employees'),
                                ]),
                            Section::make('')
                                ->columnSpan(1)
                                ->schema([
                                    TextEntry::make('est_numworkManager')
                                        ->color('warning')
                                        ->label('Managerial Positions'),
                                    TextEntry::make('est_numworkSupervisor')
                                        ->color('warning')
                                        ->label('Supervisorial Positions'),
                                    TextEntry::make('est_numworkRanks')
                                        ->color('warning')
                                        ->label('Ranks and File'),
                                ]),
                            TextEntry::make('est_numworkTotal')
                                ->color('warning')
                                ->label('Total Number of Workers'),
                        ]),
                    Section::make('')
                        ->heading('Business Owner / Representative')
                        ->schema([
                            TextEntry::make('est_owner')
                                ->color('warning')
                                ->label('Name of the Owner/Representative'),
                            TextEntry::make('est_designation')
                                ->color('warning')
                                ->label('Designation'),
                            TextEntry::make('est_fax')
                                ->color('warning')
                                ->label('Fax Number'),
                            TextEntry::make('est_contactNum')
                                ->color('warning')
                                ->label('Contact Number'),
                            TextEntry::make('est_email')
                                ->color('warning')
                                ->label('Email Address'),
                        ]),
                ]),
                
            ]);
    }
}

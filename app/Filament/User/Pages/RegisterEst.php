<?php

namespace App\Filament\User\Pages;

use Filament\Pages\Page;
use App\Models\Establishment;
use App\Models\Geocode;
use App\Models\User;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Section;
use Filament\Forms;  
use Filament\Forms\Get;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Set;
use Closure;
use Filament\Notifications\Notification;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\HtmlString;


class RegisterEst extends Page implements HasForms
{
    use InteractsWithForms;

    protected static bool $shouldRegisterNavigation = false;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected ?string $heading = 'Establishment Registration';

    protected static string $view = 'filament.user.pages.register-est';

    public ?array $data = [];
    
    public function mount(): void
    {
        $this->form->fill();
    }

    public function create()
    {
        // dd($this->form->getState());
        Establishment::create($this->form->getState());
        Notification::make()
            ->title('Establishment is successfully Registered')
            ->icon('heroicon-o-document-text')
            ->iconColor('success')
            ->send();
        return redirect('user');

        
    }

    function set (Set $set){
        $set('est_numworkTotal', getTotal());
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Wizard::make([
                    Wizard\Step::make('Details')
                        ->description('Fill up the Form to Complete your Registration.')
                        ->schema([
                            Section::make()
                                ->schema([
                                    Forms\Components\TextInput::make('est_name')
                                        ->required()
                                        ->label("Name of Establishment")
                                        ->maxLength(255),
                                        ]),
                            Section::make('Location')
                                ->columns(2)
                                ->schema([
                                    Forms\Components\TextInput::make('est_street')
                                        ->required()
                                        ->label("Floor / Bldg. No. / Street / Subdivision")
                                        ->maxLength(255),
                                    Forms\Components\Select::make('region_id')
                                        ->required()
                                        ->live()
                                        ->searchable()
                                        ->native(false)
                                        ->options([
                                            1300000000 => 'National Capital Region (NCR)',
                                            1400000000 => 'Cordillera Administrative Region (CAR)',
                                            100000000 => 'Region I (Ilocos Region)',
                                            200000000 => 'Region II (Cagayan Valley)',
                                            300000000 => 'Region III (Central Luzon)',
                                            400000000 => 'Region IV-A (CALABARZON)',
                                            1700000000 => 'MIMAROPA Region',
                                            500000000 => 'Region V (Bicol Region)',
                                            600000000 => 'Region VI (Western Visayas)',
                                            700000000 => 'Region VII (Central Visayas)',
                                            800000000 => 'Region VIII (Eastern Visayas)',
                                            900000000 => 'Region IX (Zamboanga Peninsula)',
                                            1000000000 => 'Region X (Northern Mindanao)',
                                            1100000000 => 'Region XI (Davao Region)',
                                            1200000000 => 'Region XII (SOCCSKSARGEN)',
                                            1600000000 => 'Region XIII (Caraga)',
                                            1900000000 => 'Bangsamoro Autonomous Region in Muslim Mindanao (BARMM)',
                                        ])
                                        ->label("Select Region"),
                                    Forms\Components\Select::make('province_id')
                                        ->required()
                                        ->live()
                                        ->searchable()
                                        ->native(false)
                                        ->options(function (Get $get){
                                            $num = intval($get('region_id'));
                                            $limit = $num + 100000000;
                                            return Geocode::query()
                                                        ->where('geo_id', '>', $num)
                                                        ->where('geo_id', '<', $limit)
                                                        ->whereRaw('MOD(geo_id, 100000) = 0')
                                                        ->pluck('geo_name', 'geo_id');
                                        })
                                        ->label("Select Province"),
                                    Forms\Components\Select::make('city_id')
                                        ->required()
                                        ->live()
                                        ->searchable()
                                        ->native(false)
                                        ->options(function (Get $get){
                                            $num = intval($get('province_id'));
                                            $limit = $num + 100000;
                                            if(Geocode::query()
                                            ->where('geo_id', '>', $num)
                                            ->where('geo_id', '<', $limit)
                                            ->whereRaw('MOD(geo_id, 1000) = 0')
                                            ->count()>1){
                                                return Geocode::query()
                                                        ->where('geo_id', '>', $num)
                                                        ->where('geo_id', '<', $limit)
                                                        ->whereRaw('MOD(geo_id, 1000) = 0')
                                                        ->pluck('geo_name', 'geo_id');
                                            }else{
                                                return [$num => 'N/A'];
                                            }
                                        })
                                        ->label("Select Municipality / City"),
                                    Forms\Components\Select::make('barangay_id')
                                        ->required()
                                        ->live()
                                        ->searchable()
                                        ->native(false)
                                        ->options(function (Get $get){
                                            $num = intval($get('city_id'));
                                            $limit = $num + 1000;
                                            return Geocode::query()
                                                        ->where('geo_id', '>', $num)
                                                        ->where('geo_id', '<', $limit)
                                                        ->pluck('geo_name', 'geo_id');
                                        })
                                        ->label("Select Barangay"),
                                ]),
                            Section::make()
                                ->columns(2)
                                ->schema([
                                    Forms\Components\Select::make('est_nature')
                                        ->required()
                                        ->native(false)
                                        ->searchable()
                                        ->label("Nature of Business")
                                        ->options([
                                            'H0000' => 'Transportation and Storage',
                                            'A0000' => 'Agriculture, Forestry, and Fishing',
                                            'S0000' => 'Other Services Actvities',
                                            'R0000' => 'Arts, Entertainment and Recreation',
                                            'Q0000' => 'Human Health and Social Work Activities',
                                            'P0000' => 'Education',
                                            'N0000' => 'Administrative and Support Service Activities',
                                            'M0000' => 'Professional, Scientific and Technical Activities',
                                            'L0000' => 'Real Estate Activities',
                                            'K0000' => 'Financial and Insurance Activities',
                                            'J0000' => 'Information and Communication',
                                            'I0000' => 'Accommodation and Food Service Activities',
                                            'G0000' => 'Wholesale and Retail Trade; Repair og Motor Vehicles and Motorcycles',
                                            'F0000' => 'Construction',
                                            'E0000' => 'Water Supply; Sewerage, Waste Management and Remediation',
                                            'D0000' => 'Electricity, Gas, Steam and Air Conditioning Supply',
                                            'C0000' => 'Manufaturing',
                                            'B0000' => 'Mining and Quarrying',
                                        ]),
                                    Forms\Components\TextInput::make('est_products')
                                        ->required()
                                        ->label("Major products/service/goods offered or sold")
                                        ->maxLength(255),
                                ]),
                            Section::make()
                                ->columns(2)
                                ->schema([
                                    Forms\Components\Select::make('est_class')
                                        ->required()
                                        ->native(false)
                                        ->label("Establishment Classification")
                                        ->options([
                                            1 => 'Head Office',
                                            2 => 'Branch',
                                            3 => 'Franchise',
                                        ]),
                                    Forms\Components\TextInput::make('est_tin')
                                        ->required()
                                        ->label("Company TIN")
                                        ->mask('999-999-999-999')
                                        ->placeholder('___-___-___-___'),
                                    Forms\Components\TextInput::make('est_sss')
                                        ->required()
                                        ->label("Company SSS")
                                        ->mask('99-9999999-9')
                                        ->placeholder('__-_______-_'),
                                    Forms\Components\Select::make('est_payment')
                                        ->required()
                                        ->native(false)
                                        ->label("Payment Method of Salary or other Benefits")
                                        ->options([
                                            'Banks' => 'Through Banks',
                                            'E-Money' => 'Through E-Money (e.g. Gcash, PayMaya, etc)',
                                            'Cash Agents' => 'Through Cash Agents (e.g. Remittance Centers, and other Retail Outlets',
                                            'Cash' => 'Through Cash',
                                            'Others' => 'Others'
                                        ]),
                                    Forms\Components\Select::make('est_yearImplemented')
                                        ->required()
                                        ->native(false)
                                        ->label("Year the payment method was implemented")
                                        ->options([
                                            'Since 2023' => 'Since 2023',
                                            'Since 2022' => 'Since 2022',
                                            'Since 2021' => 'Since 2021',
                                            'Since 2020' => 'Since 2020', 
                                            'Since 2019' => 'Since 2019',
                                            '2018 and prior years' => '2018 and prior years',
                                        ]),
                                ]),
                            Section::make('Number of Workers')
                                ->columns(2)
                                ->schema([
                                    Section::make()
                                        ->columnSpan(1)
                                        ->schema([
                                            Forms\Components\TextInput::make('est_numworkMale')
                                                ->required()
                                                ->columnSpan(1)
                                                ->label("Male")
                                                ->live()
                                                ->numeric(),
                                            Forms\Components\TextInput::make('est_numworkFemale')
                                                ->required()
                                                ->columnSpan(1)
                                                ->label("Female")
                                                ->live()
                                                ->numeric(),
                                            Forms\Components\Placeholder::make('est_subTotal1')
                                                ->content(function (Get $get): int {
                                                    return intval($get('est_numworkMale')) + intval($get('est_numworkFemale'));
                                                })
                                                ->label('Total'),
                                        ]),
                                    Section::make()
                                        ->columnSpan(1)
                                        ->schema([
                                            Forms\Components\TextInput::make('est_numworkManager')
                                                ->required()
                                                ->columnSpan(1)
                                                ->label("Managerial Employees")
                                                ->live()
                                                ->numeric(),
                                            Forms\Components\TextInput::make('est_numworkSupervisor')
                                                ->required()
                                                ->columnSpan(1)
                                                ->label("Supervisory")
                                                ->live()
                                                ->numeric(),
                                            Forms\Components\TextInput::make('est_numworkRanks')
                                                ->required()
                                                ->columnSpan(1)
                                                ->label("Rank and File")
                                                ->live()
                                                ->numeric(),
                                            Forms\Components\Placeholder::make('est_subTotal2')
                                                ->content(function (Get $get): int {
                                                    return intval($get('est_numworkManager')) + intval($get('est_numworkSupervisor')) + intval($get('est_numworkRanks'));
                                                })
                                                ->label('Total')
                                                ,
                                        ]),
                                    Section::make()
                                        ->columnSpan(2)
                                        ->schema([
                                            Forms\Components\Placeholder::make('est_numworkTotal')
                                                ->content(function (Get $get): int {
                                                    return intval($get('est_numworkMale')) + intval($get('est_numworkFemale'));
                                                })
                                                ->label('Total Employees'),
                                        ]),
                                    
                                ]),
                            Section::make()
                                ->description(fn():Htmlable => new HtmlString("
                                        <div style=\"color: gray; font-size: 12px;\">Max File Size: 10mb</div>
                                        <div style=\"color: gray; font-size: 12px;\">Accepted File Types</div>
                                        <div style=\"color: gray; font-size: 12px;\">&nbsp; - PDF</div>
                                        <div style=\"color: gray; font-size: 12px;\">&nbsp; - DOC/DOCX</div>
                                        <div style=\"color: gray; font-size: 12px;\">&nbsp; - JPEG</div>
                                        <div style=\"color: gray; font-size: 12px;\">&nbsp; - PNG</div>
                                    ")
                                )
                                ->columns(1)
                                ->schema([
                                    Forms\Components\FileUpload::make('est_permit')
                                        ->label("Business Permit")
                                        ->acceptedFileTypes(['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'image/jpeg', 'image/png'])
                                        ->required(),
                                    Forms\Components\FileUpload::make('est_govId')
                                        ->label("Government-Issued ID of Owner / Representative")
                                        ->acceptedFileTypes(['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'image/jpeg', 'image/png'])
                                        ->required(),
                                ]),
                        ]),
                    Wizard\Step::make('Certification')
                        ->description('This is to certify the accuracy of data provided in the registration form.')
                        ->schema([
                            Section::make()
                                ->columns(2)
                                ->schema([
                                    Forms\Components\TextInput::make('est_owner')
                                        ->required()
                                        ->label("Name of Owner or Representative")
                                        ->maxLength(255),
                                    Forms\Components\TextInput::make('est_designation')
                                        ->required()
                                        ->label('Designation / Position')
                                        ->maxLength(255),
                                ]),
                            Section::make()
                                ->columns(3)
                                ->schema([
                                    Forms\Components\TextInput::make('est_fax')
                                        ->maxLength(255)
                                        ->label('Telephone Number.'),
                                    Forms\Components\TextInput::make('est_contactNum')
                                        ->required()
                                        ->label('Contact No.')
                                        ->mask('0999-999-9999')
                                        ->placeholder('09XX-XXX-XXXX'),
                                    Forms\Components\TextInput::make('est_email')
                                        ->email()
                                        ->required()
                                        ->label('Email Address')
                                        ->maxLength(255),
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
                ])
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
            ->statePath('data')
            
            ;
    }

    
}

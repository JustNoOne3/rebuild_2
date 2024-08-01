<?php

namespace App\Filament\User\Resources\TeleReportResource\Pages;

use App\Filament\User\Resources\TeleReportResource;
use Filament\Resources\Pages\Page;
use App\Models\TeleReportBranch;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Illuminate\Contracts\View\View;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Section;
use Filament\Forms;  
use Filament\Forms\Get;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Set;
use Closure;
use Filament\Forms\Components\Livewire;
use App\Livewire\EmployeeTable;
use App\Livewire\EmployeeReviewTable;
use App\Models\TempEmp;
use App\Models\Employees;
use Filament\Notifications\Notification;

class TeleBranchCreate extends Page
{
    protected static string $resource = TeleReportResource::class;

    protected static string $view = 'filament.user.resources.tele-report-resource.pages.tele-branch-create';

    protected ?string $heading = 'Telecommuting report';

    protected static ?string $breadcrumb = 'Telecommuting';

    public ?array $data = [];
    
    public function mount(): void
    {
        $this->form->fill();
    }

    public function create()
    {
        TeleReportBranch::create($this->form->getState());

        Notification::make()
            ->title('Report Submitted')
            ->icon('heroicon-o-document-text')
            ->iconColor('success')
            ->send();
            
        return redirect('user');
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Wizard::make([
                    Wizard\Step::make('Principal Establishment')
                        ->description('Main Office')
                        ->schema([
                            Section::make()
                                ->columns(2)
                                ->schema([
                                    Section::make('Worker\'s Covered')
                                        ->columnSpan(1)
                                        ->columns(2)
                                        ->schema([
                                            Section::make('Managerial Employees')
                                                ->columns(2)
                                                ->schema([
                                                    Forms\Components\TextInput::make('teleBranch_manageMale')
                                                        // ->required()
                                                        ->label("Male")
                                                        ->maxLength(255)
                                                        ->live()
                                                        ->numeric(),
                                                    Forms\Components\TextInput::make('teleBranch_manageFemale')
                                                        // ->required()
                                                        ->label("Female")
                                                        ->maxLength(255)
                                                        ->live()
                                                        ->numeric(),
                                                ]),
                                            Section::make('Supervisory')
                                                ->columns(2)
                                                ->schema([
                                                    Forms\Components\TextInput::make('teleBranch_superMale')
                                                        // ->required()
                                                        ->label("Male")
                                                        ->maxLength(255)
                                                        ->live()
                                                        ->numeric(),
                                                    Forms\Components\TextInput::make('teleBranch_superFemale')
                                                        // ->required()
                                                        ->label("Female")
                                                        ->maxLength(255)
                                                        ->live()
                                                        ->numeric(),
                                                ]),
                                            Section::make('Rank and File')
                                                ->columns(2)
                                                ->schema([
                                                    Forms\Components\TextInput::make('teleBranch_rankMale')
                                                        // ->required()
                                                        ->label("Male")
                                                        ->maxLength(255)
                                                        ->live()
                                                        ->numeric(),
                                                    Forms\Components\TextInput::make('teleBranch_rankFemale')
                                                        // ->required()
                                                        ->label("Female")
                                                        ->maxLength(255)
                                                        ->live()
                                                        ->numeric(),
                                                ]),
                                            Forms\Components\Placeholder::make('teleBranch_total')
                                                ->content(function (Get $get): int {
                                                    return intval($get('teleBranch_manageMale')) + 
                                                            intval($get('teleBranch_manageFemale')) + 
                                                            intval($get('teleBranch_superMale')) + 
                                                            intval($get('teleBranch_superFemale')) + 
                                                            intval($get('teleBranch_rankMale')) + 
                                                            intval($get('teleBranch_rankFemale'));
                                                })
                                                ->label('Total'),
                                            
                                            
                                        ]),
                                    Section::make('Special Group of Workers Covered')
                                        ->columnSpan(1)
                                        ->columns(2)
                                        ->schema([
                                            Section::make('Persons with Disability')
                                                ->columns(2)
                                                ->schema([
                                                    Forms\Components\TextInput::make('teleBranch_disabMale')
                                                        // ->required()
                                                        ->label("Male")
                                                        ->maxLength(255)
                                                        ->live()
                                                        ->numeric(),
                                                    Forms\Components\TextInput::make('teleBranch_disabFemale')
                                                        // ->required()
                                                        ->label("Female")
                                                        ->maxLength(255)
                                                        ->live()
                                                        ->numeric(),
                                                ]),
                                            Section::make('Solo Parent')
                                                ->columns(2)
                                                ->schema([
                                                    Forms\Components\TextInput::make('teleBranch_soloperMale')
                                                        // ->required()
                                                        ->label("Male")
                                                        ->maxLength(255)
                                                        ->live()
                                                        ->numeric(),
                                                    Forms\Components\TextInput::make('teleBranch_soloperFemale')
                                                        // ->required()
                                                        ->label("Female")
                                                        ->maxLength(255)
                                                        ->live()
                                                        ->numeric(),
                                                ]),
                                            Section::make('Immunocompromised ')
                                                ->columns(2)
                                                ->schema([
                                                    Forms\Components\TextInput::make('teleBranch_immunoMale')
                                                        // ->required()
                                                        ->label("Male")
                                                        ->maxLength(255)
                                                        ->live()
                                                        ->numeric(),
                                                    Forms\Components\TextInput::make('teleBranch_immunoFemale')
                                                        // ->required()
                                                        ->label("Female")
                                                        ->maxLength(255)
                                                        ->live()
                                                        ->numeric(),
                                                ]),
                                            Section::make('With Mental Health Condition')
                                                ->columns(2)
                                                ->schema([
                                                    Forms\Components\TextInput::make('teleBranch_mentalMale')
                                                        // ->required()
                                                        ->label("Male")
                                                        ->maxLength(255)
                                                        ->live()
                                                        ->numeric(),
                                                    Forms\Components\TextInput::make('teleBranch_mentalFemale')
                                                        // ->required()
                                                        ->label("Female")
                                                        ->maxLength(255)
                                                        ->live()
                                                        ->numeric(),
                                                ]),
                                            Section::make('Senior Citizen')
                                                ->columns(2)
                                                ->schema([
                                                    Forms\Components\TextInput::make('teleBranch_seniorMale')
                                                        // ->required()
                                                        ->label("Male")
                                                        ->maxLength(255)
                                                        ->live()
                                                        ->numeric(),
                                                    Forms\Components\TextInput::make('teleBranch_seniorFemale')
                                                        // ->required()
                                                        ->label("Female")
                                                        ->maxLength(255)
                                                        ->live()
                                                        ->numeric(),
                                                ]),
                                            // Forms\Components\TextInput::make('teleBranch_specialTotal')
                                            //     // ->required()
                                            //     ->columnSpan(2)
                                            //     ->label("Total")
                                            //     ->disabled()
                                            //     ->maxLength(255),
                                            Forms\Components\Placeholder::make('teleBranch_specialTotal')
                                                ->content(function (Get $get): int {
                                                    return intval($get('teleBranch_disabMale')) + 
                                                            intval($get('teleBranch_disabFemale')) + 
                                                            intval($get('teleBranch_soloperMale')) + 
                                                            intval($get('teleBranch_soloperFemale')) + 
                                                            intval($get('teleBranch_immunoMale')) + 
                                                            intval($get('teleBranch_immunoFemale')) + 
                                                            intval($get('teleBranch_mentalMale')) + 
                                                            intval($get('teleBranch_mentalFemale')) + 
                                                            intval($get('teleBranch_seniorMale')) + 
                                                            intval($get('teleBranch_seniorFemale'));
                                                })
                                                ->label('Total'),
                                        ]),
                                    Section::make('Telecommuting Workplace')
                                        ->schema([
                                            Forms\Components\CheckboxList::make('teleBranch_workspace')
                                                ->label('Alternative Workplace')
                                                ->options([
                                                    '1' => 'Branch Office (including Satellite Offices and Hubs) ',
                                                    '2' => 'Employee\'s Residence',
                                                    '3' => 'Pre-selected by the company',
                                                    '4' => 'At the discretion of the employee ',
                                                    '5' => 'Others'
                                                ])
                                                ->live(),
                                            // Forms\Components\CheckboxList::make('teleBranch_workspace_others')
                                            //     ->label('')
                                            //     ->options([
                                            //         '5' => 'Pre-selected by the company',
                                            //         '6' => 'At the discretion of the employee '
                                            //     ])
                                            //     ->hidden(function (Get $get){
                                            //         if ($get('workplace') == '3'){
                                            //             return false;
                                            //         }else{
                                            //             return true;
                                            //         }
                                            //     }),
                                            Forms\Components\TextInput::make('teleBranch_workspace_others')
                                                ->label('Please Specify')
                                                ->hidden(function (Get $get){
                                                    if ($get('teleBranch_workspace') == '5'){
                                                        return false;
                                                    }else{
                                                        return true;
                                                    }
                                                }),
                                            
                                        ]),
                                    Section::make('Functional Areas Covered by the Telecommuting Program')
                                        ->schema([
                                            Forms\Components\CheckboxList::make('teleBranch_areasCovered')
                                                ->label('')
                                                ->options([
                                                    '1' => 'Research and Development',
                                                    '2' => 'Product Design and Development',
                                                    '3' => 'Sales and Customer Support',
                                                    '4' => 'Marketing and Brand Management',
                                                    '5' => 'Corporate Communication and Social Media Marketing',
                                                    '6' => 'Finance and Administrative functions/task',
                                                    '7' => 'Financial Management, Accounting, Audit, Controllership',
                                                    '8' => 'Human Resource Management',
                                                    '9' => 'IT and related Works',
                                                    '10' => 'Executive functions/tasks',
                                                    '11' => 'Materials Management / Procurement',
                                                    '12' => 'Engineering',
                                                    '13' => 'Others'
                                                ])
                                                ->columns(2)
                                                ->gridDirection('row')
                                                ->live(),
                                            Forms\Components\TextInput::make('teleBranch_areasCovered_others')
                                                ->label('Please Specify')
                                                ->hidden(function (Get $get){
                                                    if ($get('teleBranch_areasCovered') == '13'){
                                                        return false;
                                                    }else{
                                                        return true;
                                                    } 
                                                }),
                                        ])
                                ]),
                            
                        ]),
                    Wizard\Step::make('Certification')
                        ->schema([
                            Section::make()
                                ->columns(2)
                                ->schema([
                                    Forms\Components\FileUpload::make('teleBranch_program')
                                        ->label("Upload Telecommuting Program")
                                        ->acceptedFileTypes(['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'image/jpeg', 'image/png'])
                                        ->columnSpan(2),
                                    Forms\Components\TextInput::make('teleBranch_employer')
                                        ->label("Owner / Employer")
                                        ->maxLength(255),
                                    Forms\Components\TextInput::make('teleBranch_designation')
                                        ->label("Designation")
                                        ->maxLength(255),
                                    Forms\Components\TextInput::make('teleBranch_contact')
                                        ->label("Contact Number:")
                                        ->maxLength(255),
                                ]),
                        ]),
                ])
                ->submitAction(new HtmlString(Blade::render(<<<BLADE
                    <x-filament::button wire:click="create" color="success" icon="heroicon-o-check" tag="button" type="submit" size="lg" >
                        Submit
                        <svg fill="none" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" class="animate-spin fi-btn-icon transition duration-75 h-5 w-5 text-white" wire:loading.delay.default="" wire:target="dispatchFormEvent">
                            <path clip-rule="evenodd" d="M12 19C15.866 19 19 15.866 19 12C19 8.13401 15.866 5 12 5C8.13401 5 5 8.13401 5 12C5 15.866 8.13401 19 12 19ZM12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z" fill-rule="evenodd" fill="currentColor" opacity="0.2"></path>
                            <path d="M2 12C2 6.47715 6.47715 2 12 2V5C8.13401 5 5 8.13401 5 12H2Z" fill="currentColor"></path>
                        </svg>
                    </x-filament::button>
                BLADE))),
            ])
            ->statePath('data');
    }
}

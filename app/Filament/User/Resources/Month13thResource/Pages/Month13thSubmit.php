<?php

namespace App\Filament\User\Resources\Month13thResource\Pages;

use App\Filament\User\Resources\Month13thResource;
use Filament\Resources\Pages\Page;
use App\Models\Month13th;

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

class Month13thSubmit extends Page implements HasForms
{
    use InteractsWithForms;

    protected static string $resource = Month13thResource::class;

    protected static string $view = 'filament.user.resources.month13th-resource.pages.month13th-submit';

    protected ?string $heading = '13th Month Report';

    protected static ?string $breadcrumb = '13th Month';

    public ?array $data = [];
    
    public function mount(): void
    {
        $this->form->fill();
    }


    public function create()
    {
        Month13th::create($this->form->getState());

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
                    Wizard\Step::make('Report Details')
                        ->schema([
                            Section::make()
                                ->columns(3)
                                ->schema([
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
                            Section::make()
                                ->columns(3)
                                ->schema([
                                    Forms\Components\Select::make('month13th_yearCovered')
                                        ->label('Year Covered by Report')
                                        ->placeholder('Select a year covered by this report.')
                                        ->options(range(2019, now()->year))
                                        ->native(false)
                                        ->columnSpan(1)
                                        
                                        ->required(),
                                    Forms\Components\TextInput::make('month13th_numWorkers')
                                        ->label('Total Number of Workers Benifited')
                                        ->columnSpan(1)
                                        ->required(),
                                    Forms\Components\TextInput::make('month13th_amount')
                                        ->label('Total Amount of Benefits Granted')
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
                    Wizard\Step::make('Review')
                        ->schema([
                            Section::make()
                                ->columns(3)
                                ->schema([
                                    Forms\Components\TextInput::make('month13th_ownRep')
                                        ->readOnly(),
                                    Forms\Components\TextInput::make('month13th_designation')
                                        ->readOnly(),
                                    Forms\Components\TextInput::make('month13th_contact')
                                        ->readOnly(),
                                ]),
                            Section::make('Report Details')
                                ->columns(3)
                                ->schema([
                                    Forms\Components\TextInput::make('month13th_yearCovered')
                                        ->readOnly(),
                                    Forms\Components\TextInput::make('month13th_numWorkers')
                                        ->integer()
                                        ->readOnly(),
                                    Forms\Components\TextInput::make('month13th_amount')
                                        ->integer()
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
                            ]),
                ])
                ->submitAction(new HtmlString(Blade::render(<<<BLADE
                    <x-filament::button color="success" icon="heroicon-o-check" tag="button" type="submit" size="lg" wire:click="create" >
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

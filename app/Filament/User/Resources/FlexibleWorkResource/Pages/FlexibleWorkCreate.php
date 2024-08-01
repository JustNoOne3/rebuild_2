<?php

namespace App\Filament\User\Resources\FlexibleWorkResource\Pages;

use App\Filament\User\Resources\FlexibleWorkResource;
use Filament\Resources\Pages\Page;
use App\Models\FlexibleWork;
use App\Livewire\FlexibleWorkTable;

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

class FlexibleWorkCreate extends Page
{
    protected static string $resource = FlexibleWorkResource::class;

    protected static string $view = 'filament.user.resources.flexible-work-resource.pages.flexible-work-create';

    protected ?string $heading = 'Accident Report';

    protected static ?string $breadcrumb = 'Accident';

    public ?array $data = [];
    
    public function mount(): void
    {
        $this->form->fill();
    }

    public function create()
    {
        $temp_emp = TempEmp::query()->where('emp_estabId', Auth::user()->est_id)->get();
        $emp_ids = [];
        // dd($this->form->getState());
        if($temp_emp != null){
            $c = 1;
            foreach ($temp_emp as $emp) {
                $attributes = $emp->toArray();
                $emp_ids[$c] = $attributes['id'];
                Employees::create($attributes);
                TempEmp::where('id', $attributes['id'])->delete();
                $c += $c;
            }
            session()->put('emp_ids', $emp_ids);

        }
        FlexibleWork::create($this->form->getState());

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
                    Wizard\Step::make('FWA / AWS')
                        // ->description()
                        ->schema([
                            Livewire::make(FlexibleWorkTable::class)
                                ->key('flexible-work-table')
                        ]),
                    Wizard\Step::make('Certification')
                        // ->description()
                        ->schema([
                            Forms\Components\TextInput::make('fwa_owner')
                                ->maxLength(255),
                            Forms\Components\TextInput::make('fwa_designation')
                                ->maxLength(255),
                            Forms\Components\TextInput::make('fwa_contact')
                                ->maxLength(255),
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
            ->statePath('data');
    }
}

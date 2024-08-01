<?php
 
namespace App\Filament\Pages\Auth;

use App\Models\Geocode;
use App\Models\Establishment;
use Filament\Forms;  
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Pages\Auth\Register as RegisterPage;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Section;
use Filament\Forms\Get;
use Filament\Forms\Components\Group;

 
class Register extends RegisterPage
{
    protected ?string $maxWidth = '5xl';

    public function mount(): void
    {
        parent::mount();

    }
    
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->schema([
                        TextInput::make('username')
                            ->required()
                            ->maxLength(255)
                            ->label('Username')
                            ->columnSpan(2),
                    ]),
                Section::make()
                    ->columns(2)
                    ->schema([
                        TextInput::make('firstname')
                            ->required()
                            ->maxLength(255)
                            ->label('First Name'),
                        TextInput::make('lastname')
                            ->required()
                            ->maxLength(255)
                            ->label('Last Name'),
                            ]),
                Section::make()
                    ->schema([
                        $this->getEmailFormComponent(),
                    ]),
                Section::make()
                    ->columns(2)
                    ->schema([
                        $this->getPasswordFormComponent(),
                        $this->getPasswordConfirmationFormComponent(),
                    ]), 
            ]);
                
    }

}
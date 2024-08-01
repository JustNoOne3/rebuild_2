<?php

namespace App\Livewire;

use Livewire\Component;

use App\Models\TempEmp;
use App\Models\Establishment;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Filament\Actions\CreateAction;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\DeleteAction;
use Filament\Forms;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Filament\Forms\Components\Section;
use App\Models\Geocode;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Carbon\Carbon;


class EmployeeTable extends Component implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;
    
    public function table(Table $table): Table
    {
        return $table
            ->query(TempEmp::query()->where('emp_estabId', Auth::user()->est_id))
            ->columns([
                TextColumn::make('emp_lastName')
                    ->label('Last Name'),
                TextColumn::make('emp_firstName')
                    ->label('First Name'),
                TextColumn::make('emp_middleName')
                    ->label('Middle Name'),
            ])
            ->emptyStateHeading('Empty')
            ->emptyStateDescription('Add a new Record')
            ->emptyStateIcon('heroicon-o-bookmark')
            ->headerActions([
                Action::make('create')
                    ->label('Add Affected Worker')
                    ->model(TempEmp::class)
                    ->form([
                        Forms\Components\TextInput::make('emp_estabId')
                            ->hidden(),
                        Section::make()
                            ->columns(4)
                            ->schema([
                                Forms\Components\TextInput::make('emp_lastName')
                                    ->columnSpan(1)
                                    ->label('Last Name')
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('emp_firstName')
                                    ->columnSpan(1)
                                    ->label(' First Name')
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('emp_middleName')
                                    ->columnSpan(1)
                                    ->label('Middle Name')
                                    ->maxLength(255),
                                Forms\Components\Select::make('emp_extensionName')
                                    ->columnSpan(1)
                                    ->required()
                                    ->label('Extension Name')
                                    ->options([
                                        'N/A' => 'N/A',
                                        'JR' => 'JR',
                                        'SR' => 'SR',
                                        'I' => 'I',
                                        'II' => 'II',
                                        'III' => 'III',
                                        'IV' => 'IV',
                                        'V' => 'V',
                                    ]),
                                Forms\Components\DatePicker::make('emp_birthday')
                                    ->columnSpan(2)
                                    ->label('Birthdate'),
                                Forms\Components\Select::make('emp_sex')
                                    ->columnSpan(1)
                                    ->label('Sex')
                                    ->native(false)
                                    ->options([
                                        'Male' => 'Male',
                                        'Female' => 'Female',
                                        'Prefer not to say' => 'Prefer not to say',
                                    ]),
                                Forms\Components\Select::make('emp_civilStatus')
                                    ->columnSpan(1)
                                    ->label('Civil Status')
                                    ->native(false)
                                    ->options([
                                        'Single' => 'Single',
                                        'Married' => 'Married',
                                        'Widowed' => 'Widowed',
                                        'Separated' => 'Separated',
                                        'Divorced' => 'Divorced',
                                        'Prefer not to say' => 'Prefer not to say',
                                    ]),
                                Forms\Components\TextInput::make('emp_houseNum')
                                    ->label('House Number/ Building Name')
                                    ->required()
                                    ->columnSpan(2)
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('emp_street')
                                    ->label('Street')
                                    ->required()
                                    ->columnSpan(2)
                                    ->maxLength(255),
                                Forms\Components\Select::make('emp_region')
                                    ->required()
                                    ->columnSpan(2)
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
                                Forms\Components\Select::make('emp_province')
                                    ->required()
                                    ->columnSpan(2)
                                    ->live()
                                    ->searchable()
                                    ->native(false)
                                    ->options(function (Get $get){
                                        $num = intval($get('emp_region'));
                                        $limit = $num + 100000000;
                                        return Geocode::query()
                                                    ->where('geo_id', '>', $num)
                                                    ->where('geo_id', '<', $limit)
                                                    ->whereRaw('MOD(geo_id, 100000) = 0')
                                                    ->pluck('geo_name', 'geo_id');
                                    })
                                    ->label("Select Province"),
                                Forms\Components\Select::make('emp_city')
                                    ->required()
                                    ->columnSpan(2)
                                    ->live()
                                    ->searchable()
                                    ->native(false)
                                    ->options(function (Get $get){
                                        $num = intval($get('emp_province'));
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
                                Forms\Components\Select::make('emp_barangay')
                                    ->required()
                                    ->columnSpan(2)
                                    ->live()
                                    ->searchable()
                                    ->native(false)
                                    ->options(function (Get $get){
                                        $num = intval($get('emp_city'));
                                        $limit = $num + 1000;
                                        return Geocode::query()
                                                    ->where('geo_id', '>', $num)
                                                    ->where('geo_id', '<', $limit)
                                                    ->pluck('geo_name', 'geo_id');
                                    })
                                    ->label("Select Barangay"),
                            ]),
                        Section::make()
                            ->schema([
                                Forms\Components\TextInput::make('emp_wage')
                                    ->required()
                                    ->columnSpan(1)
                                    ->label('Average Weekly Wage'),
                                Forms\Components\TextInput::make('emp_numDependents')
                                    ->required()
                                    ->columnSpan(1)
                                    ->label('No. of Dependents'),
                                Forms\Components\TextInput::make('emp_serviceLength')
                                    ->required()
                                    ->columnSpan(2)
                                    ->label('Length of Service prior to Accident / Illness ( in months)'), 
                                Forms\Components\TextInput::make('emp_occupation')
                                    ->required()
                                    ->columnSpan(2)
                                    ->label('Occupation'),
                                Forms\Components\TextInput::make('emp_yearsExp')
                                    ->required()
                                    ->columnSpan(2)
                                    ->label('Years of Work'),
                                Forms\Components\Select::make('emp_employmentStatus')
                                    ->required()
                                    ->native(false)
                                    ->label('Employment Status')
                                    ->options([
                                        'Regular' => 'Regular',
                                        'Probationary' => 'Probationary',
                                        'Fixed Term / Project Based' => 'Fixed Term / Project Based',
                                        'Casual' => 'Casual',
                                        'Regular - Seasonal' => 'Regular - Seasonal',
                                        'Contractor\'s Employee' => 'Contractor\'s Employee',
                                    ]),
                                Forms\Components\TimePicker::make('emp_shiftStart')
                                    ->required()
                                    ->live()
                                    ->label('Work Shift Start'),
                                Forms\Components\TimePicker::make('emp_shiftEnd')
                                    ->required()
                                    ->live()
                                    ->label('Work Shift End'),
                                Forms\Components\TextInput::make('emp_workHours')
                                    ->live()
                                    ->label('Hours of Work per Day'), 
                                Forms\Components\TextInput::make('emp_workDays')
                                    ->required()
                                    ->label('Days of Work per Week'),
                                
                            ]),
                    ])
                    ->action(function (array $data, string $model): TempEmp {
                        $uuid = Uuid::uuid4()->toString();
                        $microseconds = substr(explode('.', microtime(true))[1], 0, 6); // Limit microseconds to 6 digits
                        $uuid = 'emp-' . substr($uuid, 0, 12) . '-' . $microseconds;

                        $data['id'] = $uuid;
                        $data['emp_estabId'] = Auth::user()->est_id;
                        return $model::create($data);
                    }),
            ])
            ->filters([
                // ...
            ])
            ->actions([
                DeleteAction::make(),
            ])
            ->bulkActions([
                // ...
            ]);
    }

    public function render()
    {
        return view('livewire.employee-table');
    }
}

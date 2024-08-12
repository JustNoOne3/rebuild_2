<?php

use Illuminate\Support\Facades\Route;

use App\Filament\Pages\Register;
use App\Filament\User\Pages\RegisterEst;
use App\Livewire\VerifyEst;
use App\Livewire\Certificate;

use App\Http\Middleware\Authenticate;
use App\Filament\Pages\Auth\Login;
use App\Filament\User\Pages\UnderConstruction;
use App\Filament\User\Resources\Month13thResource\Pages\Month13thSubmit;
use App\Filament\User\Resources\WairResource\Pages\WairSelect;
use App\Filament\User\Resources\WairResource\Pages\AccidentCreate;
use App\Filament\User\Resources\WairResource\Pages\IllnessCreate;
use App\Filament\User\Resources\WairResource\Pages\AccIllCreate;
use App\Filament\User\Resources\WairResource\Pages\NoAccIllCreate;
use App\Filament\User\Resources\TeleReportResource\Pages\TeleHeadCreate;
use App\Filament\User\Resources\TeleReportResource\Pages\TeleBranchCreate;
use App\Filament\User\Resources\FlexibleWorkResource\Pages\FlexibleWorkCreate;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('verify/{record}', VerifyEst::class)
    ->name('verify');

Route::get('register-est', RegisterEst::class)
    ->name('register-est')
    ->middleware(Authenticate::class);
    // ->middleware(Spatie\Csp\AddCspHeaders::class);

Route::get('user/certificate', Certificate::class)
    ->name('user-certificate')
    ->middleware(Authenticate::class);
    // ->middleware(Spatie\Csp\AddCspHeaders::class);

Route::get('admin/certificate', Certificate::class)
    ->name('admin-certificate')
    ->middleware(Authenticate::class);
    // ->middleware(Spatie\Csp\AddCspHeaders::class);

Route::get('focal/certificate', Certificate::class)
    ->name('focal-certificate')
    ->middleware(Authenticate::class);

Route::get('bwc_focal/certificate', Certificate::class)
    ->name('bwc_focal-certificate')
    ->middleware(Authenticate::class);

Route::get('user/underConstruction', UnderConstruction::class)
    ->name('user-page-underconstruction')
    ->middleware(Authenticate::class);
    // ->middleware(Spatie\Csp\AddCspHeaders::class);

Route::get('user/month13ths/submit', Month13thSubmit::class)
    ->name('user-month13ths-submit')
    ->middleware(Authenticate::class);
    // ->middleware(Spatie\Csp\AddCspHeaders::class);

///////////////////////////////////////////////////////////////////////////////////////////////////

Route::get('user/wairs/select', WairSelect::class)
    ->name('user-wairs-select')
    ->middleware(Authenticate::class);
    // ->middleware(Spatie\Csp\AddCspHeaders::class);
    
Route::get('user/accident-report', AccidentCreate::class)
    ->name('user-accident_report')
    ->middleware(Authenticate::class);
    // ->middleware(Spatie\Csp\AddCspHeaders::class);

Route::get('user/illness-report', IllnessCreate::class)
    ->name('user-illness_report')
    ->middleware(Authenticate::class);
    // ->middleware(Spatie\Csp\AddCspHeaders::class);

Route::get('user/accident-illness-report', AccIllCreate::class)
    ->name('user-accident_illness_report')
    ->middleware(Authenticate::class);
    // ->middleware(Spatie\Csp\AddCspHeaders::class);

Route::get('user/no-accident-illness-report', NoAccIllCreate::class)
    ->name('user-no_accident_illness_report')
    ->middleware(Authenticate::class);
    // ->middleware(Spatie\Csp\AddCspHeaders::class);

/////////////////////////////////////////////////////////////////////////////////////////////////////////////

Route::get('user/tele-reports/head-report', TeleHeadCreate::class)
    ->name('user-telecommuting-head_report')
    ->middleware(Authenticate::class);
    // ->middleware(Spatie\Csp\AddCspHeaders::class);

Route::get('user/tele-reports/branch-report', TeleBranchCreate::class)
    ->name('user-telecommuting-branch_report')
    ->middleware(Authenticate::class);
    // ->middleware(Spatie\Csp\AddCspHeaders::class);

Route::get('user/flexible-works/flexible-work-create', FlexibleWorkCreate::class)
    ->name('user-flexible_works-flexible_work_create')
    ->middleware(Authenticate::class);
    // ->middleware(Spatie\Csp\AddCspHeaders::class);

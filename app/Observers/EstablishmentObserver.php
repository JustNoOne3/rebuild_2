<?php

namespace App\Observers;

use App\Models\Establishment;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class EstablishmentObserver
{
    /**
     * Handle the Establishment "created" event.
     */
    public function created(Establishment $establishment): void
    {
        //
    }

    public function creating(Establishment $establishment): void
    {
        
        $timestampInMilliseconds = microtime(true) * 100;
        $rand1 = intval(microtime(true) * 321);
        $rand2 = intval(microtime(true) * 123);
        $region = intval($establishment->region_id)/100000000;
        if($region<10){
            $region = '0'.$region;
        }

        $dataId = 'R'.$region."-RP0-".now()->year.'-'.$rand2;

        $establishment->est_id = $rand1;
        $establishment->est_status = "unvalidated";
        $establishment->est_acknowledgement = now()->format('Y-m-d');
        $establishment->est_certIssuance = now()->format('Y-m-d');
        $establishment->est_numworkTotal = $establishment->est_numworkMale + $establishment->est_numworkFemale;

        $user = User::query()->where('id', Auth::user()->id)->first();
        $user->est_id = $rand1; 
        $user->save();
        
    }

    /**
     * Handle the Establishment "updated" event.
     */
    public function updated(Establishment $establishment): void
    {
        //
    }

    /**
     * Handle the Establishment "deleted" event.
     */
    public function deleted(Establishment $establishment): void
    {
        //
    }

    public function deleting(Establishment $establishment): void
    {
        $user = User::query()->where('est_id', $establishment->est_id)->first();
        $user->est_id = null;
        $user->save();
    }

    /**
     * Handle the Establishment "restored" event.
     */
    public function restored(Establishment $establishment): void
    {
        //
    }

    /**
     * Handle the Establishment "force deleted" event.
     */
    public function forceDeleted(Establishment $establishment): void
    {
        //
    }
}

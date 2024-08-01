<?php

namespace App\Livewire;

use Livewire\Component;

class TeleModal extends Component
{
    public function render()
    {
        return view('livewire.tele-modal');
    }

    public function teleHead() {
        return redirect('user/tele-reports/head-report');
    }

    public function teleBranch() {
        return redirect('user/tele-reports/branch-report');
    }
}

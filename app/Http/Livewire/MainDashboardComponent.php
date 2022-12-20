<?php

namespace App\Http\Livewire;

use App\Enums\InscriptionStatus;
use App\Enums\UserRole;
use App\Models\Annee;
use App\Models\Inscription;
use Auth;
use Carbon\Carbon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class MainDashboardComponent extends Component
{

    public function mount()
    {
     $me = Auth::user();
     if($me->role == UserRole::caissier){
         return redirect()->route('finance.finance');
     }else{
         return redirect()->route('dashboard');
     }
    }

}

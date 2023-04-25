<?php

namespace App\View\Components\Charts;

use App\Enums\Sexe;
use App\Models\Inscription;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class MaleFemaleDonutChart extends Component
{
    public array $dataset = [];
    public array $labels = [];

    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->labels = ['Garçons', 'Filles'];

        $this->dataset = [
            [
                'backgroundColor' => ['#3e95cd', '#8e5ea2'],
                'data' => [
                    Inscription::sexe(Sexe::m)->count(),
                    Inscription::sexe(Sexe::f)->count(),
                ]
            ],
        ];
    }


    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.charts.male-female-donut-chart');
    }

}

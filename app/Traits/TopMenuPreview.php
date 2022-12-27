<?php

namespace App\Traits;
use App\Models\Annee;
use Illuminate\Support\Facades\Event;
use JeroenNoten\LaravelAdminLte\Events\BuildingMenu;

trait TopMenuPreview
{
    // private $company2;
    public function __construct()
    {
      $this->init();
    }

    private function init(){
        Event::listen(BuildingMenu::class, function (BuildingMenu $event) {
           $aa = Annee::encours();
            if (!$event->menu->itemKeyExists('annee_encours')) {
                $event->menu->add([
                    'key' => 'annee_encours',
                    'text' => "Année scolaire",
                    'label' => $aa->nom,
                    'url' => '#',
                    'label_color' => 'secondary',
                    'topnav' => true,
                ]);
            }

        });
    }

}

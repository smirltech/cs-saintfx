<?php

namespace App\Traits;
use App\Models\Annee;
use App\Models\Classe;
use App\Models\ClasseEnseignant;
use App\Models\CoursEnseignant;
use App\Models\Inscription;
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

            if (!$event->menu->itemKeyExists('eleves_inscrits')) {
                $event->menu->add([
                    'key' => 'eleves_inscrits',
                    'text' => "Élèves",
                    'label' => Inscription::getCurrentInscriptions()->count(),
                    'url' => '#',
                    'label_color' => 'secondary',
                    'topnav' => true,
                ]);
            }

            if (!$event->menu->itemKeyExists('annee_classes')) {
                $event->menu->add([
                    'key' => 'annee_classes',
                    'text' => "Classes",
                    'label' => Classe::all()->count(),
                    'url' => '#',
                    'label_color' => 'secondary',
                    'topnav' => true,
                ]);
            }

            if (!$event->menu->itemKeyExists('enseignants')) {

                $event->menu->add([
                    'key' => 'enseignants',
                    'text' => "Enseignants",
                    'label' => ClasseEnseignant::all()->count() + CoursEnseignant::all()->count(),
                    'url' => '#',
                    'label_color' => 'secondary',
                    'topnav' => true,
                ]);
            }

        });
    }

}

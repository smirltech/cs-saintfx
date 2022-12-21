@php
     use App\Enums\ResultatType;
@endphp

<div>
    <div class="btn-group" role="group" aria-label="Basic example">
        <button wire:click="selectResultatType('{{ResultatType::p1->name }}')" class="btn btn-secondary btn-xs">{{ResultatType::p1->label()}}</button>
        <button wire:click="selectResultatType('{{ResultatType::p2->name }}')" type="button" class="btn btn-secondary btn-xs">{{ResultatType::p2->label()}}</button>
        <button wire:click="selectResultatType('{{ResultatType::ex1->name }}')" type="button" class="btn btn-secondary btn-xs">{{ResultatType::ex1->label()}}</button>
        <button wire:click="selectResultatType('{{ResultatType::t1->name }}')" type="button" class="btn btn-secondary btn-xs">{{ResultatType::t1->label()}}</button>

        <button wire:click="selectResultatType('{{ResultatType::p3->name }}')" type="button" class="btn btn-secondary btn-xs">{{ResultatType::p3->label()}}</button>
        <button wire:click="selectResultatType('{{ResultatType::p4->name }}')" type="button" class="btn btn-secondary btn-xs">{{ResultatType::p4->label()}}</button>
        <button wire:click="selectResultatType('{{ResultatType::ex2->name }}')" type="button" class="btn btn-secondary btn-xs">{{ResultatType::ex2->label()}}</button>
        <button wire:click="selectResultatType('{{ResultatType::t2->name }}')" type="button" class="btn btn-secondary btn-xs">{{ResultatType::t2->label()}}</button>

        <button wire:click="selectResultatType('{{ResultatType::p5->name }}')" type="button" class="btn btn-secondary btn-xs">{{ResultatType::p5->label()}}</button>
        <button wire:click="selectResultatType('{{ResultatType::p6->name }}')" type="button" class="btn btn-secondary btn-xs">{{ResultatType::p6->label()}}</button>
        <button wire:click="selectResultatType('{{ResultatType::ex3->name }}')" type="button" class="btn btn-secondary btn-xs">{{ResultatType::ex3->label()}}</button>
        <button wire:click="selectResultatType('{{ResultatType::t3->name }}')" type="button" class="btn btn-secondary btn-xs">{{ResultatType::t3->label()}}</button>

        <button wire:click="selectResultatType('{{ResultatType::tg->name }}')" type="button" class="btn btn-secondary btn-xs">{{ResultatType::tg->label()}}</button>
    </div>
    <div>Résultat - {{$resultatType?->longLabel()}}</div>
    <div class="card-body p-0 table-responsive">
        <table class="table">
            <thead>
            <tr>
                <th>PLACE</th>
                <th>ÉLÈVE</th>
                <th>POURCENT</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
@foreach($resultats as $resultat)
    <tr>
        <td>{{$resultat->place}}</td>
        <td>{{$resultat->eleve->fullName}}</td>
        <td>{{$resultat->pourcentage}}%</td>
    </tr>
@endforeach
            </tbody>
        </table>
    </div>
</div>

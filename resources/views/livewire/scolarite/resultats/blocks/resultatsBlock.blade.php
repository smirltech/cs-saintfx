@php
    use App\Enums\ResultatType;
@endphp

<div>
    @include('livewire.scolarite.resultats.blocks.modals.result')
    <div class="form-group">
        <label for="">Résultat de :</label>
        <x-form-select wire:change="selectResultatType" wire:model="resultatTypeValue"
                       class="form-control">
            @if(!$classe->maternelle())
                <option value="{{ResultatType::p1->value}}">{{ResultatType::p1->longLabel()}}</option>
                <option value="{{ResultatType::p2->value}}">{{ResultatType::p2->longLabel()}}</option>
                <option value="{{ResultatType::ex1->value}}">{{ResultatType::ex1->longLabel()}}</option>
            @endif
            <option value="{{ResultatType::t1->value}}">{{ResultatType::t1->longLabel()}}</option>
            <option value="" disabled>----------</option>
            @if(!$classe->maternelle())
                <option value="{{ResultatType::p3->value}}">{{ResultatType::p3->longLabel()}}</option>
                <option value="{{ResultatType::p4->value}}">{{ResultatType::p4->longLabel()}}</option>
                <option value="{{ResultatType::ex2->value}}">{{ResultatType::ex2->longLabel()}}</option>
            @endif
            <option value="{{ResultatType::t2->value}}">{{ResultatType::t2->longLabel()}}</option>
            <option value="" disabled>----------</option>
            @if($classe->primaire())
                @if($classe->primaire(strict:true))
                    <option value="{{ResultatType::p5->value}}">{{ResultatType::p5->longLabel()}}</option>
                    <option value="{{ResultatType::p6->value}}">{{ResultatType::p6->longLabel()}}</option>
                    <option value="{{ResultatType::ex3->value}}">{{ResultatType::ex3->longLabel()}}</option>
                @endif
                <option value="{{ResultatType::t3->value}}">{{ResultatType::t3->longLabel()}}</option>
                <option value="" disabled>----------</option>
            @endif
                <option value="{{ResultatType::tg->value}}">{{ResultatType::tg->longLabel()}}</option>
        </x-form-select>

    </div>
   {{-- <div class="btn-toolbar justify-content-between" role="toolbar" aria-label="Toolbar with button groups">
        <div class="btn-group mr-1" role="group" aria-label="first term">
            @if(!$classe->maternelle())
                <button wire:click="selectResultatType('{{ResultatType::p1->value }}')"
                        class="btn btn-secondary btn-xs">{{ResultatType::p1->label()}}</button>
                <button wire:click="selectResultatType('{{ResultatType::p2->value }}')" type="button"
                        class="btn btn-secondary btn-xs">{{ResultatType::p2->label()}}</button>
                <button wire:click="selectResultatType('{{ResultatType::ex1->value }}')" type="button"
                        class="btn btn-secondary btn-xs">{{ResultatType::ex1->label()}}</button>
            @endif
            <button wire:click="selectResultatType('{{ResultatType::t1->value }}')" type="button"
                    class="btn btn-secondary btn-xs">{{ResultatType::t1->label()}}</button>
        </div>
        <div class="btn-group mr-1" role="group" aria-label="second term">
            @if(!$classe->maternelle())
                <button wire:click="selectResultatType('{{ResultatType::p3->value }}')" type="button"
                        class="btn btn-secondary btn-xs">{{ResultatType::p3->label()}}</button>
                <button wire:click="selectResultatType('{{ResultatType::p4->value }}')" type="button"
                        class="btn btn-secondary btn-xs">{{ResultatType::p4->label()}}</button>
                <button wire:click="selectResultatType('{{ResultatType::ex2->value }}')" type="button"
                        class="btn btn-secondary btn-xs">{{ResultatType::ex2->label()}}</button>
            @endif
            <button wire:click="selectResultatType('{{ResultatType::t2->value }}')" type="button"
                    class="btn btn-secondary btn-xs">{{ResultatType::t2->label()}}</button>
        </div>
        @if($classe->primaire())

            <div class="btn-group mr-1" role="group" aria-label="third term">
                @if($classe->primaire(strict:true))
                    <button wire:click="selectResultatType('{{ResultatType::p5->value }}')" type="button"
                            class="btn btn-secondary btn-xs">{{ResultatType::p5->label()}}</button>
                    <button wire:click="selectResultatType('{{ResultatType::p6->value }}')" type="button"
                            class="btn btn-secondary btn-xs">{{ResultatType::p6->label()}}</button>
                    <button wire:click="selectResultatType('{{ResultatType::ex3->value }}')" type="button"
                            class="btn btn-secondary btn-xs">{{ResultatType::ex3->label()}}</button>
                @endif
                <button wire:click="selectResultatType('{{ResultatType::t3->value }}')" type="button"
                        class="btn btn-secondary btn-xs">{{ResultatType::t3->label()}}</button>
            </div>
        @endif
        <div class="btn-group" role="group" aria-label="final total">
            <button wire:click="selectResultatType('{{ResultatType::tg->value }}')" type="button"
                    class="btn btn-secondary btn-xs">{{ResultatType::tg->label()}}</button>
        </div>
    </div>
    --}}
    {{--<h5 class="mt-2 mb-2">Résultat - {{$resultatType?->longLabel()}}</h5>--}}
    <div class="card-body p-0 table-responsive">
        <table class="table">
            <thead>
            <tr>
                <th>PLACE</th>
                <th>ÉLÈVE</th>
                <th>POURCENT</th>
                <th>CONDUITE</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            @if($resultatType != null)
                @foreach($inscriptions as $inscription)
                    @php
                        $resultat = $inscription->resultats()->where('custom_property', $resultatType)->first();
                    @endphp
                    <tr>
                        <td>{{$resultat?->place}}</td>
                        <td>
                            <a href="{{route('scolarite.eleves.show', [$inscription->eleve])}}">{{$inscription->eleve->fullName}}</a>
                        </td>
                        <td>{{$resultat?->pourcentage}}%</td>
                        <td>{{strtoupper($resultat?->conduite?->value)}}</td>
                        <td>
                            <div class="d-flex float-right">
                                <button wire:click="selectInscription('{{$inscription->id }}')"
                                        title="supprimer"
                                        class="btn btn-sm btn-outline-warning ml-2"
                                        data-toggle="modal"
                                        data-target="#update-resultat">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button
                                    type="button"
                                    title="Téléverser bulletin"
                                    class="btn btn-outline-info btn-xs  ml-2">
                                    <span class="fa fa-upload"></span>
                                </button>
                            </div>
                        </td>

                    </tr>
                @endforeach
            @endif
            </tbody>
        </table>
    </div>
</div>

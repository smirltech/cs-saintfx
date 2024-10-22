<div>
    <div class="card">
        <div class="card-header">
            <div class="card-title d-flex">
                <div>
                    <form wire:submit.prevent="search" class="mt-1">
                        <div class="row">
                            <div class="col-md-4">
                                <x-form::select
                                    placeholder="Section"
                                    :options="$sections"
                                    wire:model="section_id"/>
                            </div>
                            <div class="col-md-4">
                                <x-form::select
                                    placeholder="Classe"
                                    :options="$classes"
                                    wire:model="classe_id"/>
                            </div>
                            <div class="col-md-4">
                                <x-form::select
                                    placeholder="Eleves"
                                    :options="$eleves"
                                    wire:model="eleve_id"/>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card-tools d-flex my-auto">
                @can('inscriptions.create')
                    <button
                        onclick="showModal('scolarite.eleve.eleve-import-component')"
                        title="ajouter"
                        class="btn btn-success mr-2"><span class="fa fa-file-excel">
                                    </span>
                    </button>
                @endcan
                @can('inscriptions.create')
                    <a href="{{ route('scolarite.inscriptions.create') }}" title="ajouter"
                       class="btn btn-primary mr-2"><span class="fa fa-plus"></span></a>
                @endcan

            </div>
        </div>
    </div>
    <livewire:scolarite.presence.charts.presences-line/>
</div>

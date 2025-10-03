<div class="container py-4">

    <h2 class="mb-4 text-2xl font-bold text-gray-700">Monter un élève dans la classe supérieure</h2>

    @if (session()->has('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if (session()->has('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif


    <input type="search" class="w-full mb-3 p-2 border rounded"
           placeholder="Rechercher par nom ou matricule"
           wire:model="search">


    <form wire:submit.prevent="passerClasse" class="bg-white shadow rounded p-4">

        <div class="row">

            <div class="col-md-6 mb-3">
                <div class="card border-light shadow-sm">
                    <div class="card-header bg-primary text-white font-weight-bold">
                        Informations de l'élève
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Nom complet</label>
                            <input type="text" class="form-control" value="{{ $eleve->nom ?? '' }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Matricule</label>
                            <input type="text" class="form-control" value="{{ $eleve->matricule ?? '' }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Sexe</label>
                            <input type="text" class="form-control" value="{{ $eleve->sexe ?? '' }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Date de naissance</label>
                            <input type="date" class="form-control"
                                   value="{{ isset($eleve) ? \Carbon\Carbon::parse($eleve->date_naissance)->format('Y-m-d') : '' }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Classe actuelle</label>
                            <input type="text" class="form-control" value="{{ $eleve->classe->nom ?? '' }}" readonly>
                        </div>

                    </div>
                </div>
            </div>

            <div class="col-md-6 mb-3">
                <div class="card border-light shadow-sm">
                    <div class="card-header bg-success text-white font-weight-bold">
                        Nouvelle classe
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Choisir la classe</label>
                            <select class="form-control" wire:model="nouvelleClasseId" {{ $eleve ? '' : 'disabled' }}>
                                <option value="">-- Sélectionner --</option>
                                @foreach($classes as $classe)
                                    <option value="{{ $classe->id }}"
                                            @if(isset($eleve) && $classe->id == ($eleve->classe->id ?? null)) disabled @endif>
                                        {{ $classe->code }}
                                        @if(isset($eleve) && $classe->id == ($eleve->classe->id ?? null))
                                            (Classe actuelle)
                                        @endif
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-success" {{ $eleve ? '' : 'disabled' }}>
                            Soumettre
                        </button>
                    </div>
                </div>
            </div>

        </div>

    </form>

</div>

@php use App\Models\Annee; @endphp
<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col-md-6">
                Frais impayés
            </div>
            <div class="col-md-6">
                <x-form::select
                    wire:model="annee_id"
                    :options="Annee::all()"
                />
            </div>
        </div>


    </div>
    <div class="card-body">
        <table class="table">
            <thead>
            <tr>
                <th>Eleve</th>
                <th>Frais</th>
                <th>Montant</th>
                <th>Echeance</th>
            </tr>
            </thead>
            <tbody>
            @foreach($perceptions as $perception)
                <tr>
                    <td>{{ $perception->eleve->nom }}</td>
                    <td>{{ $perception->frais->nom }}</td>
                    <td>{{ $perception->montant }}{{ $perception->devise }}</td>
                    <td>{{ $perception->due_date }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>

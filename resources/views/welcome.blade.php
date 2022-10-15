<x-app-layout>
    <div class="p-3 d-flex flex-column align-items-center bg-primary">
        <x-application-logo style="height: 90px; width:auto"/>
        <h1 class="text-bold fw-bold text-center text-white">Inscription en ligne</h1>
    </div>
    <div class="container d-flex flex-column align-items-center  p-3">


        <h5 class="text-gray-soft text-regular text-center">
            Avant de vous inscrire, veuillez vous assurer d'avoir les éléments suivants :
        </h5>
        <div>
            <ol class="">
                <li>Adresse e-mail valide</li>
                <li>Diplome d'état ou Journal officiel (PDF)</li>
                <li>Bordereau de paiement des frais d'inscription (PDF)</li>
                <li>Certificat de bonnes conduites, vie et moeurs (PDF)</li>
                <li>Certificat de naissance (PDF)</li>
                <li>Certificat de résidence (PDF)</li>
            </ol>
        </div>
        <a class="btn btn-primary mt-3" href="{{route('inscription')}}">
            Je m'inscris</a>
    </div>
</x-app-layout>

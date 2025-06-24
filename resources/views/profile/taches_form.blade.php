<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Ajouter une tâche') }}
        </h2>
    </x-slot>

    <link rel="stylesheet" type="text/css" href="{{ asset('create.css') }}">

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div class="container">
        <div class="content">
            <form action="{{ route('ajouter.tache') }}" enctype="multipart/form-data" method="post">
                @csrf

                <div class="form-group">
                    <label for="titre">Titre</label>
                    <input type="text" id="titre" name="titre" required>
                </div>

                <div class="form-group">
                    <label for="description">Description</label>
                    <input type="text" id="description" name="description" required>
                </div>

                <div class="form-group">
                    <label for="date_debut">Date de début</label>
                    <input type="date" id="date_debut" name="date_debut" >
                </div>

                <div class="form-group">
                    <label for="date_echeance">Date d'échéance</label>
                    <input type="date" id="date_echeance" name="date_echeance" required>
                </div>

                <div class="form-group">
                    <label for="statut">Statut</label>
                    <select id="statut" name="statut" required>
                        <option value="en_cours">En cours</option>
                        <option value="a_venir">À venir</option>
                        <option value="en_attente">En attente</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="priorite">Priorité</label>
                    <select id="priorite" name="priorite" required>
                        <option value="faible">Faible</option>
                        <option value="moyenne">Moyenne</option>
                        <option value="haute">Haute</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="commentaires">Commentaires</label>
                    <textarea id="commentaires" name="commentaires"></textarea>
                </div>

                <div class="form-group">

                 <label for="entreprise">Entreprise :</label>
                    <select name="entreprise" id="entreprise" class="border px-2 py-1">
                    @foreach($clients as $client)
                    <option value="{{ $client->id }}" {{ request('entreprise') == $client->id ? 'selected' : '' }}>
                        {{ $client->nom }}
                    </option>
                    @endforeach
                    </select>
                </div>


                <div class="form-group">
                    <label for="categorie">Catégorie</label>
                    <select id="categorie" name="categorie" required>
                        <option value="sous_contrat">Sous contrat</option>
                        <option value="pas_de_contrat">Pas de contrat</option>
                    </select>
                </div>

                <button type="submit">Ajouter</button>
            </form>
        </div>
    </div>
</x-app-layout>

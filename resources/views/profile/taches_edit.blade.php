<x-app-layout>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="{{ asset('create.css') }}">
    <meta charset="utf-8">
    <title>Modifier une tâche</title>

</head>
<body>

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




<form action="{{ route('update.save', ['id' => $tache->id]) }}" method="POST">
    @csrf

    <label for="titre">Titre</label>
    <input type="text" name="titre" id="titre" value="{{ $tache->titre }}" required><br>

    <label for="description">Description</label>
    <input type="text" name="description" id="description" value="{{ $tache->description }}"><br>

    
    <label for="date_debut">Date de début</label>
    <input type="date" name="date_debut" id="date_debut" value="{{ $tache->date_debut }}"><br>

    <label for="date_echeance">Date d'échéance</label>
    <input type="date" name="date_echeance" id="date_echeance" value="{{ $tache->date_echeance }}"><br>

   <label for="categorie">Catégorie</label>
    <select name="categorie" id="categorie" value="{{ $tache->categorie }}">
        <option value="sous_contrat" {{ $tache->categorie == 'sous_contrat' ? 'selected' : '' }}>Sous contrat</option>
        <option value="pas_de_contrat" {{ $tache->statut == 'pas_de_contrat' ? 'selected' : '' }}>Pas de contrat</option>

    </select><br>

    <label for="statut">Statut</label>
    <select name="statut" id="statut" value="{{ $tache->statut }}">
        <option value="en_cours" {{ $tache->statut == 'en_cours' ? 'selected' : '' }}>En cours</option>
        <option value="terminee" {{ $tache->statut == 'terminee' ? 'selected' : '' }}>Terminée</option>
        <option value="a_venir" {{ $tache->statut == 'a_venir' ? 'selected' : '' }}>À venir</option>
        <option value="en_attente" {{ $tache->statut == 'en_attente' ? 'selected' : '' }}>En attente</option>
        <option value="annulee" {{ $tache->statut == 'annulee' ? 'selected' : '' }}>Annulée</option>
    </select><br>

    <label for="priorite">Priorité</label>
    <select name="priorite" id="priorite" value="{{ $tache->priorite }}">
        <option value="faible" {{ $tache->priorite == 'faible' ? 'selected' : '' }}>Faible</option>
        <option value="moyenne" {{ $tache->priorite == 'moyenne' ? 'selected' : '' }}>Moyenne</option>
        <option value="haute" {{ $tache->priorite == 'haute' ? 'selected' : '' }}>Haute</option>
    </select><br>

    <label for="commentaires">Commentaires</label>
    <textarea name="commentaires" id="commentaires">{{ $tache->commentaires }}</textarea><br>


    <label for="entreprise">Entreprise :</label>
    <select name="entreprise" id="entreprise" class="border px-2 py-1" value ="{{ $tache->entreprise }}">
    @foreach($clients as $client)
    <option value="{{ $client->id }}" {{ request('entreprise') == $client->id ? 'selected' : '' }}>
        {{ $client->nom }}
    </option>
    @endforeach
    </select>
 
    <button type="submit" class="mt-4 bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">Mettre à jour</button>
</form>

<a href="{{ route('dashboard') }}">Retour au tableau de bord</a>

</body>
</html>
</x-app-layout>
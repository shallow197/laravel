<x-app-layout>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Page de modification</title>

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

<header>
    <h1>infos de l'utilisateur</h1>
</header>


<p class="text-sm text-gray-500">Utilisateur  : {{ $user->name }}</p>
<p class="text-sm text-gray-500">Email  : {{ $user->email }}</p>

<br>
 <h1 class="text-2xl font-bold mb-4">Liste des Tâches</h1>

           
                    <table class="w-full table-auto border-collapse border border-gray-300">
                        <thead>
                            <tr class="bg-gray-200">

                                <th>ID</th>
                                <th>Tâche</th>
                                <th>Date d'ajout</th>
                                <th>Date de début</th>
                                <th>Date d'échéance</th>
                                <th>Catégorie</th>
                                <th>Statut</th>
                                <th>Priorité</th>
                                <th>Description</th>
                                <th>Commentaires</th>
                                <th>Entreprise</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($taches as $tache)
                                <tr class="border-t">
                                    <td>{{ $tache->id }}</td>
                                    <td>{{ $tache->titre }}</td>
                                    <td>{{ $tache->date_ajout }}</td>
                                    <td>{{ $tache->date_debut }}</td>
                                    <td>{{ $tache->date_echeance }}</td>
                                    <td>{{ $tache->categorie }}</td>
                                    <td>{{ $tache->statut }}</td>
                                    <td>{{ $tache->priorite }}</td>
                                    <td>{{ $tache->description }}</td>
                                    <td>{{ $tache->commentaires }}</td>
                                    <td>{{ $tache->entreprise }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10" class="text-center py-4">Aucune tâche pour l'instant.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

               


</body>
</html>
</x-app-layout>
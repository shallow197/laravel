
<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Tableau de bord') }}
        </h2>
    </x-slot>

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


    <div class="py-12">
        <div class="container mx-auto px-4">

        <div class="mb-4">
    
</div>


            @if($user->role === 'admin')

            
                <a href="{{ route('showtask.admin') }}" class="mt-4 bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">Voir toutes les tâches</a><br><br>

                <h1 class="text-2xl font-bold mb-4">Liste des utilisateurs</h1>

                <table class="w-full table-auto border-collapse border border-gray-300">
                    <thead>
                        <tr class="bg-gray-200">
                            <th class="border px-3 py-1">ID</th>
                            <th class="border px-3 py-1">Prénom</th>
                            <th class="border px-3 py-1">Email</th>
                            <th class="border px-3 py-1">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $utilisateur)
                            <tr class="border-t">
                                <td class="border px-3 py-1">{{ $utilisateur->id }}</td>
                                <td class="border px-3 py-1">{{ $utilisateur->name }}</td>
                                <td class="border px-3 py-1">{{ $utilisateur->email }}</td>
                                <td class="border px-3 py-1">
                                    <a href="{{ route('voirplus', ['id' => $utilisateur->id]) }}" class="text-blue-500">  Voir plus  &#128269;</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-4">Aucun utilisateur inscrit.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

            @else

             <form method="GET" action="{{ route('dashboard') }}" class="mb-6">
    <label for="statut">Statut :</label>
    <select name="statut" id="statut" class="border px-2 py-1">
        <option value=""> Tous </option>
        <option value="en_attente" {{ request('statut') == 'a_venir' ? 'selected' : '' }}>A venir </option>
        <option value="en_cours" {{ request('statut') == 'en_cours' ? 'selected' : '' }}>En cours</option>
        <option value="terminee" {{ request('statut') == 'terminee' ? 'selected' : '' }}>Terminée</option>
        <option value="en_attente" {{ request('statut') == 'en_attente' ? 'selected' : '' }}>En attente</option>
        <option value="annulee" {{ request('statut') == 'annulee' ? 'selected' : '' }}>Annulée</option>
    </select>

    <label for="priorite">Priorité :</label>
    <select name="priorite" id="priorite" class="border px-2 py-1">
        <option value=""> Toutes </option>
        <option value="basse" {{ request('priorite') == 'basse' ? 'selected' : '' }}>Basse</option>
        <option value="moyenne" {{ request('priorite') == 'moyenne' ? 'selected' : '' }}>Moyenne</option>
        <option value="haute" {{ request('priorite') == 'haute' ? 'selected' : '' }}>Haute</option>
    </select><br><br>

      <label for="categorie">Catégorie :</label>
    <select name="categorie" id="categorie" class="border px-2 py-1">
        <option value=""> Toutes </option>
        <option value="sous_contrat" {{ request('categorie') == 'sous_contrat' ? 'selected' : '' }}>Sous contrat</option>
        <option value="pas_de_contrat" {{ request('categorie') == 'pas_de_contrat' ? 'selected' : '' }}>Pas de contrat</option>

    </select>

    <label for="entreprise">Entreprise :</label>
                    <select name="entreprise" id="entreprise" class="border px-2 py-1">
                    <option value="">Tous</option>
                    @foreach($clients as $client)
                    <option value="{{ $client->id }}" {{ request('entreprise') == $client->id ? 'selected' : '' }}>
                        {{ $client->name }}
                    </option>
                    @endforeach
                    </select>

    <button type="submit" class="mt-4 bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">Filtrer</button>
</form>


                <h1 class="text-2xl font-bold mb-4">Liste des Tâches</h1>

                <form action="{{ route('multidelete') }}" method="POST">
                    @csrf
                    <table class="w-full table-auto border-collapse border border-gray-300">
                        <thead>
                            <tr class="bg-gray-200">
                                <th class="border px-3 py-1"><input type="checkbox" onclick="toggle(this)"></th>
                                <th class="border px-3 py-1">ID</th>
                                <th class="border px-3 py-1">Tâche</th>
                                <th class="border px-3 py-1">Date d'ajout</th>
                                <th class="border px-3 py-1">Date de début</th>
                                <th class="border px-3 py-1">Date d'échéance</th>
                                <th class="border px-3 py-1">Catégorie</th>
                                <th class="border px-3 py-1">Entreprise</th>
                                <th class="border px-3 py-1">Statut</th>
                                <th class="border px-3 py-1">Priorité</th>
                                <th class="border px-3 py-1">Description</th>
                                <th class="border px-3 py-1">Commentaires</th>
                                <th class="border px-3 py-1">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($taches as $tache)
                                <tr class="border-t">
                                    <td class="border px-4 py-1"><input type="checkbox" name="tasks_to_delete[]" value="{{ $tache->id }}"></td>
                                    <td class="border px-4 py-1">{{ $tache->id }}</td>
                                    <td class="border px-4 py-1">{{ $tache->titre }}</td>
                                    <td class="border px-4 py-1">{{ $tache->date_ajout }}</td>
                                    <td class="border px-4 py-1">{{ $tache->date_debut }}</td>
                                    <td class="border px-4 py-1">{{ $tache->date_echeance }}</td>
                                    <td class="border px-4 py-1">{{ $tache->categorie }}</td>
                                    <td class="border px-4 py-1">{{ $tache->entreprise }}</td>
                                    <td class="border px-4 py-1">{{ $tache->statut }}</td>
                                    <td class="border px-4 py-1">{{ $tache->priorite }}</td>
                                    <td class="border px-4 py-1">{{ $tache->description }}</td>
                                    <td class="border px-4 py-1">{{ $tache->commentaires }}</td>
                                    
                                    <td>
                                        <a href="{{ route('update.form', ['id' => $tache->id]) }}" class="inline-block mt-4 bg-red-600 text-white px-5 py-3 rounded hover:bg-red-700"> modifier &#9998;</a> 
                                         <a href="{{ route('delete', ['id' => $tache->id]) }}"  class="inline-block mt-4 bg-red-600 text-white px-5 py-3 rounded hover:bg-red-700" onsubmit="return confirm('Êtes-vous sûr(e) de vouloir supprimer cette tâche ?');">supprimer  &#128465;</a>

                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="13" class="text-center py-4">Aucune tâche pour l'instant.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <button type="submit" onclick="return confirm('Confirmer la suppression ?');" class="mt-4 bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">
                        Supprimer &#128465;
                    </button>
                </form><br><br>

                <a href="{{ route('add.task') }}" class="mt-4 bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">Ajouter une tâche</a>
            @endif
        </div>
    </div>

    <script>
        function toggle(source) {
            document.querySelectorAll('input[type="checkbox"]').forEach(cb => cb.checked = source.checked);
        }
    </script>
</x-app-layout>

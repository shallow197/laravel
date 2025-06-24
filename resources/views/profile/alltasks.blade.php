<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Liste des tâches') }}
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


             <form method="GET" action="{{ route('showtask.admin') }}" class="mb-6">
    <label for="statut">Statut :</label>
    <select name="statut" id="statut" class="border px-2 py-1">
        <option value=""> Toutes </option>
        <option value="en_attente" {{ request('statut') == 'a_venir' ? 'selected' : '' }}>A venir</option>
        <option value="en_cours" {{ request('statut') == 'en_cours' ? 'selected' : '' }}>En cours</option>
        <option value="terminee" {{ request('statut') == 'terminee' ? 'selected' : '' }}>Terminée</option>
        <option value="en_attente" {{ request('statut') == 'en_attente' ? 'selected' : '' }}>En attente</option>
        <option value="annulee" {{ request('statut') == 'annulee' ? 'selected' : '' }}>Annulée</option>
    </select>

       <label for="categorie">Catégorie :</label>
    <select name="categorie" id="categorie" class="border px-2 py-1">
        <option value=""> Toutes </option>
        <option value="sous_contrat" {{ request('categorie') == 'sous_contrat' ? 'selected' : '' }}>Sous contrat</option>
        <option value="pas_de_contrat" {{ request('categorie') == 'pas_de_contrat' ? 'selected' : '' }}>Pas de contrat</option>

    </select>

    <label for="priorite">Priorité :</label>
    <select name="priorite" id="priorite" class="border px-2 py-1">
        <option value=""> Toutes </option>
        <option value="basse" {{ request('priorite') == 'basse' ? 'selected' : '' }}>Basse</option>
        <option value="moyenne" {{ request('priorite') == 'moyenne' ? 'selected' : '' }}>Moyenne</option>
        <option value="haute" {{ request('priorite') == 'haute' ? 'selected' : '' }}>Haute</option>
    </select><br><br>

   <label for="utilisateur">Utilisateur :</label>
    <select name="utilisateur" id="utilisateur" class="border px-2 py-1">
    <option value="">Tous</option>
    @foreach($users as $user)
        <option value="{{ $user->id }}" {{ request('utilisateur') == $user->id ? 'selected' : '' }}>
            {{ $user->name }}
        </option>
    @endforeach
</select>

<label for="entreprise">Entreprise :</label>
                    <select name="entreprise" id="entreprise" class="border px-2 py-1">
                          <option value="">Tous</option>
                          @foreach($clients as $client)
                          <option value="{{ $client->nom }}" {{ request('entreprise') == $client->nom ? 'selected' : '' }}>
                          {{ $client->nom }}
                          </option>
                          @endforeach

                    </select>
           


    <button type="submit" class="mt-4 bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">Filtrer</button>
</form>


                <h1 class="text-2xl font-bold mb-4">Liste des Tâches</h1>

                    <table class="w-full table-auto border-collapse border border-gray-300">
                        <thead>
                            <tr class="bg-gray-200">
                                <th class="border px-2 py-1">ID</th class="border px-2 py-1">
                                <th class="border px-2 py-1">Tâche</th class="border px-2 py-1">
                                <th class="border px-2 py-1">Date d'ajout</th class="border px-2 py-1">
                                <th class="border px-2 py-1">Date de début</th class="border px-2 py-1">
                                <th class="border px-2 py-1">Date d'échéance</th class="border px-2 py-1">
                                <th class="border px-2 py-1">Catégorie</th class="border px-2 py-1">
                                <th class="border px-2 py-1">Entreprise</th class="border px-2 py-1">
                                <th class="border px-2 py-1">Statut</th class="border px-2 py-1">
                                <th class="border px-2 py-1">Priorité</th class="border px-2 py-1">
                                <th class="border px-2 py-1">Description</th class="border px-2 py-1">
                                <th class="border px-2 py-1">Commentaires</th class="border px-2 py-1">
                                <th class="border px-2 py-1">Utilisateur</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($tasks as $task)
                                <tr class="bg-gray-200">
                                    <td class="border px-2 py-1">{{ $task->id }}</td>
                                    <td class="border px-2 py-1">{{ $task->titre }}</td>
                                    <td class="border px-2 py-1">{{ $task->date_ajout }}</td class="border px-2 py-1">
                                    <td class="border px-2 py-1">{{ $task->date_debut }}</td class="border px-2 py-1">
                                    <td class="border px-2 py-1">{{ $task->date_echeance }}</td class="border px-2 py-1">
                                    <td class="border px-2 py-1">{{ $task->categorie }}</td class="border px-2 py-1">
                                    <td class="border px-2 py-1">{{ $task->entreprise }}</td class="border px-2 py-1">
                                    <td class="border px-2 py-1">{{ $task->statut }}</td class="border px-2 py-1">
                                    <td class="border px-2 py-1">{{ $task->priorite }}</td class="border px-2 py-1">
                                    <td class="border px-2 py-1">{{ $task->description }}</td class="border px-2 py-1">
                                    <td class="border px-2 py-1">{{ $task->commentaires }}</td class="border px-2 py-1">               
                                    <td class="border px-2 py-1">{{ $task->user->name ?? '—' }}</td>

                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10" class="text-center py-4">Aucune tâche pour l'instant.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

        </div>
    </div>

    <script>
      
    </script>
</x-app-layout>

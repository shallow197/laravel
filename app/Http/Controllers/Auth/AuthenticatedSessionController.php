<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\Client;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB; 
use App\Models\Tache;
use App\Models\User;



class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        //$request->authenticate();
         $identifiants = $request->only('email', 'password', 'role');
         $remember = $request->boolean('remember');

    if (Auth::attempt($identifiants, $remember)&& Auth::user()->role
 === "utilisateur") 
    {
        $request->session()->regenerate();
        return redirect()->intended(RouteServiceProvider::HOME);
        
    } 

    elseif (Auth::attempt($identifiants, $remember) && Auth::user()->role
 === "admin")

    {
            $request->session()->regenerate();
            return redirect()->intended(RouteServiceProvider::HOME);
           
    } 

    else 
    {
        return back()->withErrors([
            'email' => "Les identifiants fournis ne correspondent à aucun compte.",
        ]);
    }
        
    }
        
    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

 
    public function affichage_infos_users(Request $request, $id)
    {
        $user = DB::table('users')->where('id', $id)->first();
        $taches = DB::table('taches')->get()
        ->where('user_id', $user->id);


         return view('profile.userdata', compact( 'taches', 'user'));
    }

   public function multiDelete(Request $request)
{
    $ids = $request->input('tasks_to_delete');
    
    if ($ids) {
        Tache::whereIn('id', $ids)->delete();
        return redirect()->back()->with('success', 'Les tâches ont été supprimées avec succès.');
    }

    return redirect()->back()->with('error', 'Aucune tâche sélectionnée.');
}



    public function showdashboard(Request $request)
    {
        $user = Auth::user();
        $users = DB::table('users')
        ->where('role', 'utilisateur')
        ->get();


           
    $query = Tache::query()
    ->where('user_id', Auth::id());

    if ($request->filled('statut')) {
        $query->where('statut', $request->statut);
    }

    if ($request->filled('priorite')) {
        $query->where('priorite', $request->priorite);
    }

    if ($request->filled('categorie')) {
        $query->where('categorie', $request->categorie);
    }

    if ($request->filled('entreprise')) {
        $query->where('entreprise', $request->entreprise);
    }
    $taches = $query->get();

    $clients = Client::all();



        return view('dashboard', compact('taches', 'user', 'users', 'clients'));
    
}

public function storetask(Request $request)
    {
        $client = DB::table('clients')->where('id', $request->entreprise)->first();
        $validatedData = $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'nullable|string',
            'date_ajout' => 'nullable|date',
            'date_debut' => 'nullable|date',
            'date_echeance' => 'nullable|date|after_or_equal:date_ajout',
            'priorite' => 'nullable|in:faible,elevee,moyenne',
            'statut' => 'nullable|in:en_cours,terminee,a_venir, en_attente, annulee',
            'categorie' => 'nullable|in:sous_contrat,pas_de_contrat',
            'commentaires' => 'nullable|string',
            'entreprise' => 'required|exists:clients,id'

        ]);

        $validatedData['user_id'] = Auth::id();
        $validatedData['entreprise'] = $client ? $client->nom : null;

        DB::table('taches')->insert($validatedData);

        return redirect()->route('dashboard')->with('success', 'Tâche ajoutée avec succès.');
    }

    public function add_task(Request $request)
    {
        $user = Auth::user();
        $id = $user->id;
        $clients = Client::all();
        return view('profile.taches_form', compact('id', 'clients'));
    }

    public function update_task(Request $request, $id)
    {
        $validatedData = $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'nullable|string',
            'date_debut' => 'nullable|date',
            'date_echeance' => 'nullable|date|after_or_equal:date_ajout',
            'priorite' => 'nullable|in:faible,moyenne,elevee',
            'statut' => 'nullable|in:en_cours,terminee,a_venir, en_attente, annulee',
            'categorie' => 'nullable|in:sous_contrat,pas_de_contrat',
            'commentaires' => 'nullable|string',
            'entreprise' => 'required|exists:clients,id'
        ]);

        $validatedData['entreprise'] = DB::table('clients')->where('id', $validatedData['entreprise'])->value('nom');

        DB::table('taches')->where('id', $id)->update($validatedData);

        return redirect()->route('dashboard')->with('success', 'Tâche mise à jour avec succès.');
    }

    public function edit_task($id)
{
    $clients = Client::all();
    $tache = DB::table('taches')->where('id', $id)->first();
    if (!$tache) {
        return redirect()->route('dashboard')->with('error', 'Tâche non trouvée');
    }
    return view('profile.taches_edit', compact('tache', 'clients'));
}


    public function delete_task($id)
    {
        DB::table('taches')->where('id', $id)->delete();
        return redirect()->route('dashboard')->with('success', 'Tâche supprimée avec succès.');
    }

    public function showtaskstoadmin(Request $request)
{

    $users = User::all()
    ->where('role', 'utilisateur');


    $query = Tache::with('user');

    $clients = Client::all();

    if ($request->filled('statut')) {
        $query->where('statut', $request->statut);
    }

    if ($request->filled('priorite')) {
        $query->where('priorite', $request->priorite);
    }

    if ($request->filled('utilisateur')) {
        $query->where('user_id', $request->utilisateur);
    }
    
     if ($request->filled('categorie')) {
        $query->where('categorie', $request->categorie);
    }

    if ($request->filled('entreprise')) {
        $query->where('entreprise', $request->entreprise);
    }


  
    $tasks = $query->get();

    return view('profile.alltasks', compact('tasks', 'users', 'clients'));
}

}
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Option;
use App\Models\Role;
use App\Models\User;
use App\Notifications\PasswordResettedNotification;
use App\Notifications\UserCreatedNotification;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class UserController extends Controller
{

    public function __construct()
    {
        $this->authorizeResource(User::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {

        // get user not super admins, use spatie permission
        $users = User::orderByDesc('id')->get();

        return view('admin.users.index', compact('users'))->with('title', __('Utilisateurs'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Application|RedirectResponse|Redirector
     */
    public function store(StoreUserRequest $request)
    {

        $user = User::create($request->safe()->only(['name', 'email', 'faculte_id']));

        $user->assignRole($request->role_id);

        // Generate a random password for the user
        $password = Str::random(8);

        $user->password = Hash::make($password);
        $user->save();

        // Send an email to the user with the password, surround with try/catch to prevent errors
        try {
            $user->notify(new UserCreatedNotification($password));
        } catch (Exception $e) {
            // log the error
            Log::error($e->getMessage());

            // undo the user creation
            $user->delete();

            // redirect to the user creation page with an error message
            return redirect()->route('scolarite.users.create')->with('error', __('Une erreur est survenue lors de l\'envoi du mail. Veuillez réessayer.'));
        }


        return redirect()->route('scolarite.users.index')->with('success', __('Utilisateur créé avec succès'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        //  get alls roles except super scolarite

        $roles = Role::where('name', '!=', 'super-scolarite')->get();
        $facultes = Option::all();

        return view('admin.users.create', compact('roles', 'facultes'))->with('title', __('Ajouter un utilisateur'));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return void
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param User $user
     * @return Application|Factory|View
     */
    public function edit(User $user)
    {
        $roles = Role::where('name', '!=', 'super-scolarite')->get();
        $facultes = Option::all();

        return view('admin.users.edit', compact('user', 'roles', 'facultes'))->with('title', $user->name);
    }

    public function resetPassword(Request $request, User $user)
    {

        $password = Str::random(8);

        $user->password = Hash::make($password);


        // Send an email to the user with the password, surround with try/catch to prevent errors
        try {
            $user->notify(new PasswordResettedNotification($password));
            $user->save();
        } catch (Exception $e) {
            // log the error
            Log::error($e->getMessage());

            // redirect to the user creation page with an error message
            return redirect()->back()->with('error', __('Une erreur est survenue lors de l\'envoi du mail. Veuillez réessayer.'));
        }

        return redirect()->back()->with('success', __('Mot de passe réinitialisé avec succès'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param User $user
     * @return Application|Redirector|RedirectResponse
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        //return $user;

        $user->update($request->safe()->only(['name', 'faculte_id']));
        $user->syncRoles($request->role_id);
        $user->save();

        return redirect()->back()->with('success', __('Le nouveau mot de passe a été envoyé à votre addresse email :' . $user->email));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @return Application|Redirector|RedirectResponse
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect(route('scolarite.users.index'))->with('success', __('The action ran successfully!'));
    }
}

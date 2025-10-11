<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!auth()->user()->isSuperAdmin()) {
            return redirect()->route('dashboard');
        }

        $users = User::with('creator')
            ->orderBy('name')
            ->get();

        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'created_by' => auth()->id(),
        ]);

        return redirect()->route('users.index')
            ->with('success', 'Usuário criado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        if (!auth()->user()->isSuperAdmin()) {
            return redirect()->route('dashboard');
        }
        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'notes' => 'nullable|string|max:500',
        ]);

        $user->update($request->only(['name', 'email', 'notes']));

        return redirect()->route('users.index')
            ->with('success', 'Usuário atualizado com sucesso!');
    }

    public function resetPassword(Request $request, User $user)
    {
        $request->validate([
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('users.index')
            ->with('success', 'Senha redefinida com sucesso!');
    }

    public function toggleStatus(User $user)
    {
        // Impedir que o próprio usuário se desative
        if ($user->id === auth()->id()) {
            return redirect()->route('users.index')
                ->with('error', 'Você não pode desativar sua própria conta!');
        }

        // Impedir desativar o super admin
        if ($user->isSuperAdmin()) {
            return redirect()->route('users.index')
                ->with('error', 'Não é possível desativar o usuário administrador principal!');
        }

        $user->update([
            'is_active' => !$user->is_active,
        ]);

        $status = $user->is_active ? 'ativado' : 'desativado';

        return redirect()->route('users.index')
            ->with('success', "Usuário {$status} com sucesso!");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        // Impedir exclusão do próprio usuário
        if ($user->id === auth()->id()) {
            return redirect()->route('users.index')
                ->with('error', 'Você não pode excluir sua própria conta!');
        }

        // Impedir exclusão do super admin
        if ($user->isSuperAdmin()) {
            return redirect()->route('users.index')
                ->with('error', 'Não é possível excluir o usuário administrador principal!');
        }

        $user->delete();

        return redirect()->route('users.index')
            ->with('success', 'Usuário excluído com sucesso!');
    }
}

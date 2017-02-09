<?php

namespace Build\Core\Http\Controllers;

/*
 * This file is part of the Build package.
 *
 * (c) Centagon <contact@centagon.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\Response;
use Build\Core\Http\Controller;
use Build\Core\Eloquent\Models\User;
use Build\Core\Eloquent\Models\Role;
use Illuminate\Http\RedirectResponse;
use Build\Core\Eloquent\Models\Website;
use Build\Core\Http\Entities\UserEntity;
use Build\Core\Http\Requests\UserRequest;

class UsersController extends Controller
{

    /**
     * @return Response
     */
    public function index()
    {
        $this->authorize('index-user');

        $users = User::all();

        return entity(UserEntity::class, 'index')
            ->setQuery($users)
            ->render();
    }

    /**
     * @return Response
     */
    public function create()
    {
        $this->authorize('create-user');

        return entity(UserEntity::class, 'create')->render();
    }

    /**
     * @param  UserRequest  $request
     *
     * @return RedirectResponse
     */
    public function store(UserRequest $request)
    {
        $this->authorize('create-user');

        // Additional password validation.
        $this->validate($request, [
            'password' => 'required|confirmed'
        ]);

        User::create($request->all());

        alert()->success('Successfully created the new user.');

        return redirect()->route('admin.users.index');
    }

    /**
     * @param  User  $user
     *
     * @return Response
     */
    public function edit(User $user)
    {
        $this->authorize('edit', $user);

        return entity(UserEntity::class, 'edit')
            ->setQuery($user)
            ->render();
    }

    /**
     * @param  UserRequest  $request
     * @param  User  $user
     *
     * @return RedirectResponse
     */
    public function update(UserRequest $request, User $user)
    {
        $this->authorize('edit', $user);

        $payload = $request->all();

        if ($request->has('password')) {
            $this->validate($request, [
                'password' => 'required|confirmed'
            ]);
        } else {
            unset($payload['password'], $payload['password_confirmation']);
        }

        $this->updateRoles($request, $user);

        $user->update($payload);

        alert()->success('Successfully updated the user.');

        return redirect()->route('admin.users.index');
    }

    public function destroy()
    {
        $this->authorize('delete-user');
    }

    /**
     * @param  User  $user
     *
     * @return View
     */
    public function rolesSidebar(User $user)
    {
        $this->authorize('manage_roles-user');

        $user = User::findOrFail($user);
        $roles = Role::all();

        $websites = Website::all();
        $websiteRoles = Role::where('id', '!=', Role::SUPER_ADMINISTRATORS)->get();

        return view('build.core::screens.users.sidebar.roles', [
            'user' => $user,
            'roles' => $roles,
            'websites' => $websites,
            'websiteRoles' => $websiteRoles
        ]);
    }

    /**
     * @param  Request  $request
     * @param  User $user
     * @return array
     */
    public function updateRoles(Request $request, User $user)
    {
        $roles = $request->get('role');

        foreach ($roles as $website => $role) {
            $website = $website ?: null;

            if (! $role) {
                continue;
            }

            $user->assignRole($role, $website);
        }
    }
}

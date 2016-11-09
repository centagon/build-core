<?php

namespace Build\Core\Http\Controllers;

use Build\Core\Http\Controller;
use Build\Core\Support\Facades\Modules;
use Build\Core\Http\Entities\ModulesEntity;
use Illuminate\Http\Request;

class ModulesController extends Controller
{

    public function index()
    {
        $modules = Modules::all();

        return entity(ModulesEntity::class, 'index')
            ->setQuery($modules)
            ->render();
    }

    public function edit($slug)
    {
        $module = Modules::find($slug);

        return entity(ModulesEntity::class, 'edit')
            ->setQuery($module)
            ->render();
    }

    public function update(Request $request, $slug)
    {
        $payload = $request->except('_token', '_method');

        foreach ($payload as $key => $value) {
            Modules::set(sprintf('%s::%s', $slug, $key), $value);
        }

        alert()->success('Successfully updated a module.')->flash();

        return redirect()->route('admin.modules.index');
    }
}

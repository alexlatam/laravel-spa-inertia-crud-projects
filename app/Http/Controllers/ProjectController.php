<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProjectController extends Controller
{
    public function index() {
        if (!session()->has("search")){
            session()->put("search", null);
            session()->put("trashed", null);
        }

        /* Aqui vamos a retornar una vista de Inertia.
        * En este caso renderizamos un componente de vuejs
        * Este comonente recibe las propiedades (props)
        * La primera propiedad llamada filters, es un array que contiene los filtros de busqueda
        * La segunda propiedad llamada projects, es un array que contiene los proyectos
        */
        return Inertia::render('Projects/Index', [
            "filters" => session()->only(["search", "trashed"]),
            "projects" => Project::with("users")
                ->orderByDesc("id")
                // A este metodo le pasamos los filtros de busqueda. Este metodo esta definido en el modelo Project
                ->filter(request()->only("search", "trashed"))
                ->paginate(10)
        ]);
    }
}

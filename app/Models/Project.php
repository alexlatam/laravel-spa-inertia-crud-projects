<?php

namespace App\Models;

use Illuminate\Database\Query\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Project extends Model
{
    use HasFactory;

    protected $fillable = ["user_id", "name", "excerpt", "content"];

    // Este metodo se ejecuta cuando se crea un nuevo registro
    protected static function boot()
    {
        // Llamamos al metodo boot de la clase padre
        parent::boot();

        /**
         * Este metodo es para asignar el id del usuario autenticado al campo user_id del modelo Project
         * Esta forma se suele usar cuando no se envia el usuario desde el formulario o no se toma en el controlador
         * Todos los projectos que se creen siempre se asignaran al usuario autenticado
         */
        // Este evento se ejecuta antes de crear un nuevo registro
        self::creating(function ($project) {
            // Si el usuario esta autenticado y no estamos en la consola
            if (auth()->check() && !app()->runningInConsole()) {
                // Asignamos el id del usuario autenticado al campo user_id del modelo Project
                $project->user_id = auth()->id();
            }
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Este metodo es para aplicar los filtros de busqueda
    // Este metodo se usa con el modelo como si fuera otro metodo del query builder Project::filter();
    // Este metodo se aplicara solo cuando se use el metodo filter en el queryBuilder
    public function scopeFilter( Builder $query, array $filters)
    {
        // Si no es una peticion de paginacion, entonces actualizamos los filtros en la sesion
        if(!request("page")){
            session()->put("search", $filters["search"] ?? null);
            session()->put("trashed", $filters["trashed"] ?? null);
        }

        // Cuando la busqueda "search" no esta vacia, entonces aplicamos el filtro
        $query->when(session("search"), function ($query, $search){
            $query->where('name', 'LIKE', '%'.$search.'%')
                ->orWhere('excerpt', 'LIKE', '%'.$search.'%')
                ->orWhere('content', 'LIKE', '%'.$search.'%');
        })->when(session("trashed"), function ($query, $trashed){
            if($trashed === "with"){
                $query->withTrashed(); // proyectos incluso eliminados mediante soft delete
            }elseif ($trashed === "only"){
                $query->onlyTrashed(); // solo proyectos eliminados mediante soft delete
            }
        });
    }
}

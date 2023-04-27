<?php

namespace App\Models;

use Illuminate\Contracts\Database\Query\Builder;
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

    public function scopeFilter( Builder $query, array $filters)
    {
        // TODO filtrar listado del cliente con vuejs
    }
}

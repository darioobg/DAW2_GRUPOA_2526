<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class EstadoTarea extends Model
{
	protected $table = 'estado_tarea';

	protected $casts = [
		'orden' => 'int'
	];

	protected $fillable = [
		'nombre',
		'orden',
		'id_proyecto'
	];

	public function tareas()
	{
		return $this->hasMany(Tarea::class, 'id_estado');
	}

	public function proyecto()
	{
		return $this->belongsTo(Proyecto::class, 'id_proyecto');
	}
}

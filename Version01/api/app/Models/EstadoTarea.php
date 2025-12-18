<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class EstadoTarea
 * 
 * @property int $id
 * @property string $nombre
 * @property int $orden
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|Tarea[] $tareas
 *
 * @package App\Models
 */
class EstadoTarea extends Model
{
	protected $table = 'estado_tarea';

	protected $casts = [
		'orden' => 'int'
	];

	protected $fillable = [
		'nombre',
		'orden'
	];

	public function tareas()
	{
		return $this->hasMany(Tarea::class, 'id_estado');
	}
}

<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Prioridad
 * 
 * @property int $id
 * @property string $nombre
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|Tarea[] $tareas
 *
 * @package App\Models
 */
class Prioridad extends Model
{
	protected $table = 'prioridad';

	protected $fillable = [
		'nombre'
	];

	public function tareas()
	{
		return $this->hasMany(Tarea::class, 'id_prioridad');
	}
}

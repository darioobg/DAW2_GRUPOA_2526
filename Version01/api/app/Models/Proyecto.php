<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Proyecto
 * 
 * @property int $id
 * @property int $id_equipo
 * @property string $nombre
 * @property string $descripcion
 * @property Carbon $fecha_creacion
 * @property Carbon $fecha_inicio
 * @property Carbon $fecha_fin_prevista
 * @property int $id_estado_proyecto
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Equipo $equipo
 * @property EstadoProyecto $estado_proyecto
 * @property Collection|Tarea[] $tareas
 *
 * @package App\Models
 */
class Proyecto extends Model
{
	protected $table = 'proyectos';

	protected $casts = [
		'id_equipo' => 'int',
		'fecha_creacion' => 'datetime',
		'fecha_inicio' => 'datetime',
		'fecha_fin_prevista' => 'datetime',
		'id_estado_proyecto' => 'int'
	];

	protected $fillable = [
		'id_equipo',
		'nombre',
		'descripcion',
		'fecha_creacion',
		'fecha_inicio',
		'fecha_fin_prevista',
		'id_estado_proyecto'
	];

	public function equipo()
	{
		return $this->belongsTo(Equipo::class, 'id_equipo');
	}

	public function estado_proyecto()
	{
		return $this->belongsTo(EstadoProyecto::class, 'id_estado_proyecto');
	}

	public function tareas()
	{
		return $this->hasMany(Tarea::class, 'id_proyectos');
	}
}

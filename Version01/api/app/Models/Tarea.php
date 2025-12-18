<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Tarea
 * 
 * @property int $id
 * @property int $id_proyectos
 * @property int $id_prioridad
 * @property int $id_asignado_a
 * @property int $id_estado
 * @property string $titulo
 * @property string|null $descripcion
 * @property Carbon $fecha_creacion
 * @property Carbon $fecha_limite
 * @property Carbon $fecha_cierre
 * @property int $orden_kanban
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Usuario $usuario
 * @property EstadoTarea $estado_tarea
 * @property Prioridad $prioridad
 * @property Proyecto $proyecto
 * @property Collection|Comentario[] $comentarios
 * @property Collection|Notificacion[] $notificacions
 *
 * @package App\Models
 */
class Tarea extends Model
{
	protected $table = 'tarea';

	protected $casts = [
		'id_proyectos' => 'int',
		'id_prioridad' => 'int',
		'id_asignado_a' => 'int',
		'id_estado' => 'int',
		'fecha_creacion' => 'datetime',
		'fecha_limite' => 'datetime',
		'fecha_cierre' => 'datetime',
		'orden_kanban' => 'int'
	];

	protected $fillable = [
		'id_proyectos',
		'id_prioridad',
		'id_asignado_a',
		'id_estado',
		'titulo',
		'descripcion',
		'fecha_creacion',
		'fecha_limite',
		'fecha_cierre',
		'orden_kanban'
	];

	public function usuario()
	{
		return $this->belongsTo(Usuario::class, 'id_asignado_a');
	}

	public function estado_tarea()
	{
		return $this->belongsTo(EstadoTarea::class, 'id_estado');
	}

	public function prioridad()
	{
		return $this->belongsTo(Prioridad::class, 'id_prioridad');
	}

	public function proyecto()
	{
		return $this->belongsTo(Proyecto::class, 'id_proyectos');
	}

	public function comentarios()
	{
		return $this->hasMany(Comentario::class, 'id_tarea');
	}

	public function notificacions()
	{
		return $this->hasMany(Notificacion::class, 'id_tarea');
	}
}

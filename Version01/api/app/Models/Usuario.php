<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Usuario
 * 
 * @property int $id
 * @property string $nombre
 * @property string $apellidos
 * @property string $email
 * @property Carbon $fecha_registro
 * @property Carbon $ultimoAcceso
 * @property bool $activo
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|Comentario[] $comentarios
 * @property Collection|Notificacion[] $notificacions
 * @property Collection|Tarea[] $tareas
 * @property Collection|Equipo[] $equipos
 *
 * @package App\Models
 */
class Usuario extends Model
{
	protected $table = 'usuarios';

	protected $casts = [
		'fecha_registro' => 'datetime',
		'ultimoAcceso' => 'datetime',
		'activo' => 'bool'
	];

	protected $fillable = [
		'nombre',
		'apellidos',
		'email',
		'fecha_registro',
		'ultimoAcceso',
		'activo'
	];

	public function comentarios()
	{
		return $this->hasMany(Comentario::class, 'id_usuario');
	}

	public function notificacions()
	{
		return $this->hasMany(Notificacion::class, 'id_usuario_destino');
	}

	public function tareas()
	{
		return $this->hasMany(Tarea::class, 'id_asignado_a');
	}

	public function equipos()
	{
		return $this->belongsToMany(Equipo::class, 'usuario_equipo', 'id_usuario', 'id_equipo')
					->withPivot('id_rol_equipo', 'fecha_alta', 'activo')
					->withTimestamps();
	}
}

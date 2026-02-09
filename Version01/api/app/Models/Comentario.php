<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Comentario
 *
 * @property int $id
 * @property int $id_tarea
 * @property int $id_usuario
 * @property string $texto
 * @property Carbon $fecha_creacion
 * @property Carbon $fecha_edicion
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Tarea $tarea
 * @property Usuario $usuario
 *
 * @package App\Models
 */
class Comentario extends Model
{
	protected $table = 'comentario';

	protected $casts = [
		'id_tarea' => 'int',
		'id_usuario' => 'int',
		'fecha_creacion' => 'datetime',
		'fecha_edicion' => 'datetime'
	];

	protected $fillable = [
		'id_tarea',
		'id_usuario',
		'texto',
		'fecha_creacion',
		'fecha_edicion'
	];

	public function tarea()
	{
		return $this->belongsTo(Tarea::class, 'id_tarea');
	}

	public function usuario()
	{
		return $this->belongsTo(User::class, 'id_usuario');
	}
}

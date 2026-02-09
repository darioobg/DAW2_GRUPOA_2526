<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Notificacion
 *
 * @property int $id
 * @property int $id_tarea
 * @property int $id_usuario_destino
 * @property int $id_tipo_notificacion
 * @property int $id_canal_notificacion
 * @property string $mensaje
 * @property bool $leida
 * @property Carbon $fecha_envio
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property CanalNotificacion $canal_notificacion
 * @property Tarea $tarea
 * @property TipoNotificacion $tipo_notificacion
 * @property Usuario $usuario
 *
 * @package App\Models
 */
class Notificacion extends Model
{
	protected $table = 'notificacion';

	protected $casts = [
		'id_tarea' => 'int',
		'id_usuario_destino' => 'int',
		'id_tipo_notificacion' => 'int',
		'id_canal_notificacion' => 'int',
		'leida' => 'bool',
		'fecha_envio' => 'datetime'
	];

	protected $fillable = [
		'id_tarea',
		'id_usuario_destino',
		'id_tipo_notificacion',
		'id_canal_notificacion',
		'mensaje',
		'leida',
		'fecha_envio'
	];

	public function canal_notificacion()
	{
		return $this->belongsTo(CanalNotificacion::class, 'id_canal_notificacion');
	}

	public function tarea()
	{
		return $this->belongsTo(Tarea::class, 'id_tarea');
	}

	public function tipo_notificacion()
	{
		return $this->belongsTo(TipoNotificacion::class, 'id_tipo_notificacion');
	}

	public function usuario()
	{
		return $this->belongsTo(User::class, 'id_usuario_destino');
	}
}

<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class UsuarioEquipo
 * 
 * @property int $id_usuario
 * @property int $id_equipo
 * @property int $id_rol_equipo
 * @property Carbon $fecha_alta
 * @property bool $activo
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Equipo $equipo
 * @property RolEquipo $rol_equipo
 * @property Usuario $usuario
 *
 * @package App\Models
 */
class UsuarioEquipo extends Model
{
	protected $table = 'usuario_equipo';
	public $incrementing = false;

	protected $casts = [
		'id_usuario' => 'int',
		'id_equipo' => 'int',
		'id_rol_equipo' => 'int',
		'fecha_alta' => 'datetime',
		'activo' => 'bool'
	];

	protected $fillable = [
		'id_usuario',
		'id_equipo',
		'id_rol_equipo',
		'fecha_alta',
		'activo'
	];

	public function equipo()
	{
		return $this->belongsTo(Equipo::class, 'id_equipo');
	}

	public function rol_equipo()
	{
		return $this->belongsTo(RolEquipo::class, 'id_rol_equipo');
	}

	public function usuario()
	{
		return $this->belongsTo(Usuario::class, 'id_usuario');
	}
}

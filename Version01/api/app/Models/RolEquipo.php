<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class RolEquipo
 * 
 * @property int $id
 * @property string $nombre
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|UsuarioEquipo[] $usuario_equipos
 *
 * @package App\Models
 */
class RolEquipo extends Model
{
	protected $table = 'rol_equipo';

	protected $fillable = [
		'nombre'
	];

	public function usuario_equipos()
	{
		return $this->hasMany(UsuarioEquipo::class, 'id_rol_equipo');
	}
}

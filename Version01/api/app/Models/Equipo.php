<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Equipo
 * 
 * @property int $id
 * @property int $id_empresa
 * @property string $nombre
 * @property string|null $descripcion
 * @property Carbon $fecha_creacion
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Empresa $empresa
 * @property Collection|Proyecto[] $proyectos
 * @property Collection|Usuario[] $usuarios
 *
 * @package App\Models
 */
class Equipo extends Model
{
	protected $table = 'equipo';

	protected $casts = [
		'id_empresa' => 'int',
		'fecha_creacion' => 'datetime'
	];

	protected $fillable = [
		'id_empresa',
		'nombre',
		'descripcion',
		'fecha_creacion'
	];

	public function empresa()
	{
		return $this->belongsTo(Empresa::class, 'id_empresa');
	}

	public function proyectos()
	{
		return $this->hasMany(Proyecto::class, 'id_equipo');
	}

	public function usuarios()
	{
		return $this->belongsToMany(Usuario::class, 'usuario_equipo', 'id_equipo', 'id_usuario')
					->withPivot('id_rol_equipo', 'fecha_alta', 'activo')
					->withTimestamps();
	}
}

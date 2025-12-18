<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Empresa
 * 
 * @property int $id
 * @property string $nombre
 * @property string $cif_nif
 * @property string $direccion
 * @property string $telefono
 * @property Carbon $fecha_alta
 * @property bool $activa
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|Equipo[] $equipos
 *
 * @package App\Models
 */
class Empresa extends Model
{
	protected $table = 'empresa';

	protected $casts = [
		'fecha_alta' => 'datetime',
		'activa' => 'bool'
	];

	protected $fillable = [
		'nombre',
		'cif_nif',
		'direccion',
		'telefono',
		'fecha_alta',
		'activa'
	];

	public function equipos()
	{
		return $this->hasMany(Equipo::class, 'id_empresa');
	}
}

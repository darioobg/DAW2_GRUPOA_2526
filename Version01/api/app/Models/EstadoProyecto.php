<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class EstadoProyecto
 * 
 * @property int $id
 * @property string $nombre
 * @property string $estado
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|Proyecto[] $proyectos
 *
 * @package App\Models
 */
class EstadoProyecto extends Model
{
	protected $table = 'estado_proyecto';

	protected $fillable = [
		'nombre',
		'estado'
	];

	public function proyectos()
	{
		return $this->hasMany(Proyecto::class, 'id_estado_proyecto');
	}
}

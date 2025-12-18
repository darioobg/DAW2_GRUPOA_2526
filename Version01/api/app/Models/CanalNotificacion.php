<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class CanalNotificacion
 * 
 * @property int $id
 * @property string $nombre
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|Notificacion[] $notificacions
 *
 * @package App\Models
 */
class CanalNotificacion extends Model
{
	protected $table = 'canal_notificacion';

	protected $fillable = [
		'nombre'
	];

	public function notificacions()
	{
		return $this->hasMany(Notificacion::class, 'id_canal_notificacion');
	}
}

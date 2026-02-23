<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use App\Http\Middleware\Authenticate;
use App\Models\UsuarioEquipo;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\HasApiTokens;

/**
 * Class User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class User extends Authenticatable
{
	use HasApiTokens, HasFactory, Notifiable;

	protected $table = 'users';

	protected $casts = [
		'fecha_registro' => 'datetime',
		'ultimoAcceso' => 'datetime',
		'activo' => 'bool',
		'email_verified_at' => 'datetime'
	];

	protected $hidden = [
		'password',
		'remember_token'
	];

	protected $fillable = [
		'name',
		'apellidos',
		'email',
		'email_verified_at',
		'password',
		'remember_token',
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
		return $this
			->belongsToMany(Equipo::class, 'usuario_equipo', 'id_usuario', 'id_equipo')
			->withPivot('id_rol_equipo', 'fecha_alta', 'activo')
			->withTimestamps();
	}

	public function usuarioEquipos()
	{
		return $this->hasMany(UsuarioEquipo::class, 'id_usuario', 'id');
	}
}

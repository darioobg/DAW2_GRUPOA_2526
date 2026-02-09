<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UsuarioEmpresa extends Model
{
    protected $table = 'usuario_empresa';
    protected $primaryKey = 'id_usuario_empresa';

    protected $fillable = [
        'id_usuario',
        'id_empresa',
        'id_rol_empresa',
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_usuario', 'id_usuario');
    }

    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'id_empresa', 'id_empresa');
    }

    public function rolEmpresa()
    {
        return $this->belongsTo(RolEmpresa::class, 'id_rol_empresa', 'id_rol_empresa');
    }
}

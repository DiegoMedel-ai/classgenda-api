<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Usuario
 * 
 * @property int $id
 * @property int $rol
 * @property string $correo
 * @property string $nombre
 * @property string $apellido
 * @property string $carrera
 * @property string $centro
 * @property int $situacion
 * @property string $telefono
 * @property string $foto_url
 * @property string $contraseña
 * 
 * @property TiposUsuario $tipos_usuario
 * @property TiposSituacion $tipos_situacion
 * @property Collection|Inscripcion[] $inscripcions
 * @property Collection|Materia[] $materias
 *
 * @package App\Models
 */
class Usuario extends Model
{
	protected $table = 'usuarios';
	protected $hidden = ['contraseña'] ;
	public $timestamps = false;

	protected $casts = [
		'rol' => 'int',
		'situacion' => 'int'
	];

	protected $fillable = [
		'rol',
		'correo',
		'nombre',
		'apellido',
		'carrera',
		'centro',
		'situacion',
		'telefono',
		'foto_url',
		'contraseña',
		'academia',
		'departamento'
	];

	public function tipos_usuario()
	{
		return $this->belongsTo(TiposUsuario::class, 'rol');
	}

	public function tipos_situacion()
	{
		return $this->belongsTo(TiposSituacion::class, 'situacion');
	}

	public function inscripcions()
	{
		return $this->hasMany(Inscripcion::class, 'usuario');
	}

	public function materias()
	{
		return $this->hasMany(Materia::class, 'profesor');
	}
}

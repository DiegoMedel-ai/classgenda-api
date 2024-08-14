<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TiposUsuario
 * 
 * @property int $id
 * @property string $rol
 * 
 * @property Collection|Usuario[] $usuarios
 *
 * @package App\Models
 */
class TiposUsuario extends Model
{
	protected $table = 'tipos_usuario';
	public $timestamps = false;

	protected $fillable = [
		'rol'
	];

	public function usuarios()
	{
		return $this->hasMany(Usuario::class, 'rol');
	}
}

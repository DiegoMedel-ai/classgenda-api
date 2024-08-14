<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TiposSituacion
 * 
 * @property int $id
 * @property string $situacion
 * 
 * @property Collection|Usuario[] $usuarios
 *
 * @package App\Models
 */
class TiposSituacion extends Model
{
	protected $table = 'tipos_situacion';
	public $timestamps = false;

	protected $fillable = [
		'situacion'
	];

	public function usuarios()
	{
		return $this->hasMany(Usuario::class, 'situacion');
	}
}

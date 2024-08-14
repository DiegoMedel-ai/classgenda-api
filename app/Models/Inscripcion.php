<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Inscripcion
 * 
 * @property int $id
 * @property int $usuario
 * @property int $materia
 * 
 *
 * @package App\Models
 */
class Inscripcion extends Model
{
	protected $table = 'inscripcion';
	public $timestamps = false;

	protected $casts = [
		'usuario' => 'int',
		'materia' => 'int'
	];

	protected $fillable = [
		'usuario',
		'materia'
	];

	public function materia()
	{
		return $this->belongsTo(Materia::class, 'materia');
	}

	public function usuario()
	{
		return $this->belongsTo(Usuario::class, 'usuario');
	}
}

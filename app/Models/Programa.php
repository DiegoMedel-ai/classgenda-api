<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Programa
 * 
 * @property int $clave
 * @property string $nombre
 * @property int $tipo
 * @property int $creditos
 * @property int $requisito
 * @property int $simultaneo
 * @property int $horas_practica
 * @property int $horas_curso
 * @property string $descripcion
 * @property string $perfil_egreso
 * 
 * @property Programa $programa
 * @property Collection|Materia[] $materias
 * @property Collection|Programa[] $programas
 *
 * @package App\Models
 */
class Programa extends Model
{
	protected $table = 'programas';
	protected $primaryKey = 'clave';
	public $timestamps = false;

	protected $casts = [
		'creditos' => 'int',
		'requisito' => 'int',
		'simultaneo' => 'int',
		'horas_practica' => 'int',
		'horas_curso' => 'int'
	];

	protected $fillable = [
		'nombre',
		'tipo',
		'creditos',
		'requisito',
		'simultaneo',
		'horas_practica',
		'horas_curso',
		'descripcion',
		'perfil_egreso',
		'temas',
		'departamento'
	];

	public function requisitoPrograma()
	{
		return $this->belongsTo(Programa::class, 'requisito');
	}
	
	public function simultaneoPrograma()
	{
		return $this->belongsTo(Programa::class, 'simultaneo');
	}

	public function materias()
	{
		return $this->hasMany(Materia::class, 'programa');
	}

	public function programas()
	{
		return $this->hasMany(Programa::class, 'simultaneo');
	}
}

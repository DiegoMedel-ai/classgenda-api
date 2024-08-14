<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Materia
 * 
 * @property int $nrc
 * @property int $programa
 * @property string $dias_clase
 * @property Carbon $hora_inicio
 * @property Carbon $hora_final
 * @property string $edificio
 * @property int $aula
 * @property int $profesor
 * 
 * @property Usuario $usuario
 * @property Collection|Inscripcion[] $inscripcions
 * @property Collection|Reporte[] $reportes
 *
 * @package App\Models
 */
class Materia extends Model
{
	protected $table = 'materias';
	protected $primaryKey = 'nrc';
	public $timestamps = false;

	protected $casts = [
		'programa' => 'int',
		'hora_inicio' => 'datetime',
		'hora_final' => 'datetime',
		'aula' => 'int',
		'profesor' => 'int'
	];

	protected $fillable = [
		'programa',
		'dias_clase',
		'hora_inicio',
		'hora_final',
		'edificio',
		'aula',
		'profesor'
	];

	public function profesor()
	{
		return $this->belongsTo(Usuario::class, 'profesor');
	}

	public function programa()
	{
		return $this->belongsTo(Programa::class, 'programa');
	}

	public function inscripcions()
	{
		return $this->hasMany(Inscripcion::class, 'materia');
	}

	public function reportes()
	{
		return $this->hasMany(Reporte::class, 'materia');
	}
}

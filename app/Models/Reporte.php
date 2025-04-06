<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Reporte
 * 
 * @property int $id
 * @property int $materia
 * @property int $semana
 * @property string $pdf_url
 * @property string $temas
 * 
 *
 * @package App\Models
 */
class Reporte extends Model
{
	protected $table = 'reportes';
	public $timestamps = false;

	protected $casts = [
		'materia' => 'int',
		'semana' => 'int'
	];

	protected $fillable = [
		'materia',
		'semana',
		'pdf_uid',
		'temas',
		'descripcion'
	];

	public function materia()
	{
		return $this->belongsTo(Materia::class, 'materia');
	}
}

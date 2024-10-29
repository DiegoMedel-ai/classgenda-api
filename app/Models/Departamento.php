<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $academia
 * @property string $departamento
 * @property Academia $academia
 * @property Programa[] $programas
 */
class Departamento extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['academia', 'departamento'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function academia()
    {
        return $this->belongsTo('App\Models\Academia', 'academia');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function programas()
    {
        return $this->hasMany('App\Models\Programa', 'departamento');
    }
}

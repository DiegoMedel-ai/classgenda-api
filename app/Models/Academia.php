<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property string $academia
 * @property Departamento[] $departamentos
 */
class Academia extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['academia'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function departamentos()
    {
        return $this->hasMany('App\Models\Departamento', 'academia');
    }
}

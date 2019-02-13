<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClubModel extends Model
{
    protected $table = 'clubes';

    public function zona(){return $this->belongsTo('App\ZonaModel','idZona','id');}

    public function campo(){return $this->belongsTo('App\CampoModel','idCampo','id');}

    public function usuario(){return $this->hasOne('App\User', 'id');}

    public function tieneDirector(){
        $count = MiembroModel::directorDeClub($this->id)->count();
        return ($count > 0)?true:false;
    }

    public function scopeActivated($query){
        return $query->where('active',1);
    }
    public function scopeDisabled($query){
        return $query->where('active',0);
    }
    public function scopeSinUsuario($query){return $query->whereNull('idUsuario');}
}

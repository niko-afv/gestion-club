<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Contracts\ILog;

class LogModel extends Model implements ILog
{
    protected $table = 'logs';

    protected $fillable = ['tipo_id'];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function tipo(){
        return $this->belongsTo(TipoLogModel::class);
    }
}

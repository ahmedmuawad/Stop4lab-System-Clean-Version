<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class Antibiotic extends Model
{
    use SoftDeletes;
    use LogsActivity;

    public $guarded=[];

    protected static $logName = 'Antibiotic';

    protected static $logAttributesToIgnore = [ 'updated_at'];

    protected static $logAttributes = ['*'];

    protected static $logOnlyDirty = true;

    protected static $submitEmptyLogs = false;

    public function getDescriptionForEvent(string $eventName): string
    {
        return "Antibiotic was {$eventName}";
    }
}

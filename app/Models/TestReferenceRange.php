<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;


class TestReferenceRange extends Model
{
    use LogsActivity;
    use SoftDeletes;
    public $guarded=[];

    protected static $logName = 'Reference Renge';
    protected static $logAttributesToIgnore = [ 'updated_at'];

    // protected static $logAttributes = ['gender','age_unit','age_from','age_from_days','age_to','age_to_days','critical_low_from','normal_from','normal_to','critical_high_from','show_status','comment'];
    protected static $logAttributes = ['*'];

    protected static $logOnlyDirty = true;

    protected static $submitEmptyLogs = false;

    public function test()
    {
        return $this->belongsTo(Test::class,'test_id','id');
    }

    public function getDescriptionForEvent(string $eventName): string
    {
        return "Reference Range was {$eventName}";
    }
}

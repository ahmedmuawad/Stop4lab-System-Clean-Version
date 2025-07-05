<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Expense extends Model
{
    use LogsActivity;

    public $guarded=[];

    protected static $logName = 'Expense';

    protected static $logAttributesToIgnore = [ 'updated_at'];

    protected static $logAttributes = ['*'];

    protected static $logOnlyDirty = true;

    protected static $submitEmptyLogs = false;

    public function category()
    {
        return $this->belongsTo(ExpenseCategory::class,'expense_category_id','id')->withTrashed();
    }

    public function doctor()
    {
        return $this->belongsTo(User::class,'doctor_id','id');
    }
    public function branch()
    {
        return $this->belongsTo(Branch::class,'branch_id','id');
    }

    public function payment_method()
    {
        return $this->belongsTo(PaymentMethod::class,'payment_method_id','id')->withTrashed();
    }

    public function custody()
    {
        return $this->morphOne(Branches_custody::class,'priceable');
    }

    public function getDescriptionForEvent(string $eventName): string
    {
        return "Expense was {$eventName}";
    }
}

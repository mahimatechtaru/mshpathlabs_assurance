<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    protected $table = 'report';

    protected $fillable = ['report_id', 'lab_id', 'pathology_category_id', 'pathology_id', 'radiology_category_id', 'radiology_id', 'amount', 'doctor_id', 'prescription', 'user_id', 'patient_name', 'phone_no', 'age', 'gender', 'date', 'time', 'payment_type', 'payment_token', 'payment_status', 'upload_report'];

    public $appends = ['pathology_category', 'radiology_category', 'pathology', 'radiology'];

    public function lab()
    {
        return $this->belongsTo('App\Models\Lab');
    }

    public function getPathologyCategoryAttribute()
    {
        if ($this->pathology_category_id != null) {
            return PathologyCategory::find($this->pathology_category_id)->name;
        }
    }

    public function getPathologyAttribute()
    {
        if ($this->pathology_id != null) {
            $ids = explode(',', $this->pathology_id);

            return Pathology::whereIn('id', $ids)->get();
        }
    }

    public function getRadiologyCategoryAttribute()
    {
        if ($this->radiology_category_id != null) {
            return PathologyCategory::find($this->radiology_category_id)->name;
        }
    }

    public function getRadiologyAttribute()
    {
        if ($this->radiology_id != null) {
            $ids = explode(',', $this->radiology_id);

            return Radiology::whereIn('id', $ids)->get();
        }
    }
}

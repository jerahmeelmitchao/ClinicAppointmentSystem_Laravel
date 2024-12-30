<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory;

    // Define the table name if it's different from the plural form of the model name
    protected $table = 'doctors';

    // Define the fillable properties (mass assignable)
    protected $fillable = [
        'name',
        'email',
        'MobileNumber',
        'specialization_id',
        'status',
    ];

    // Define any relationships (if applicable, e.g., Specialization)
    public function specialization()
    {
        return $this->belongsTo(Specialization::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class, 'Doctor', 'id');
    }
}

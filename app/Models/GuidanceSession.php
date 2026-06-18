<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model; use Illuminate\Database\Eloquent\Factories\HasFactory;
class GuidanceSession extends Model { use HasFactory; protected $guarded=[]; protected $casts=['session_date'=>'date']; public function student(){ return $this->belongsTo(User::class,'student_id'); } public function supervisor(){ return $this->belongsTo(User::class,'supervisor_id'); } }

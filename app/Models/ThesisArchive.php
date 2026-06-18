<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model; use Illuminate\Database\Eloquent\Factories\HasFactory;
class ThesisArchive extends Model { use HasFactory; protected $guarded=[]; protected $casts=['is_public'=>'boolean']; public function student(){ return $this->belongsTo(User::class,'student_id'); } }

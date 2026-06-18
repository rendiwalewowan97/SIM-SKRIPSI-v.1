<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model; use Illuminate\Database\Eloquent\Factories\HasFactory;
class ExamRegistration extends Model {
    use HasFactory;
    protected $guarded=[];
    protected $casts=['scheduled_at'=>'datetime','documents'=>'array'];
    public function student(){ return $this->belongsTo(User::class,'student_id'); }
    public function supervisor1(){ return $this->belongsTo(User::class,'supervisor_1_id'); }
    public function supervisor2(){ return $this->belongsTo(User::class,'supervisor_2_id'); }
    public function examiner1(){ return $this->belongsTo(User::class,'examiner_1_id'); }
    public function examiner2(){ return $this->belongsTo(User::class,'examiner_2_id'); }
    public function examiner3(){ return $this->belongsTo(User::class,'examiner_3_id'); }
    public function chairman(){ return $this->belongsTo(User::class,'chairman_id'); }
    public function secretary(){ return $this->belongsTo(User::class,'secretary_id'); }
}

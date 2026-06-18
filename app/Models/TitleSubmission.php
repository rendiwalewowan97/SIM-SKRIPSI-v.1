<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model; use Illuminate\Database\Eloquent\Factories\HasFactory;
class TitleSubmission extends Model {
    use HasFactory;
    protected $guarded=[];
    protected $casts=['approved_at'=>'datetime','assigned_at'=>'datetime'];
    public function student(){ return $this->belongsTo(User::class,'student_id'); }
    public function supervisor(){ return $this->belongsTo(User::class,'supervisor_id'); }
    public function supervisor1(){ return $this->belongsTo(User::class,'supervisor_1_id'); }
    public function supervisor2(){ return $this->belongsTo(User::class,'supervisor_2_id'); }
    public function votes(){ return $this->hasMany(TitleVote::class); }
    public function setujuVotes(){ return $this->votes()->where('vote','setuju'); }
    public function tidakSetujuVotes(){ return $this->votes()->where('vote','tidak_setuju'); }
}

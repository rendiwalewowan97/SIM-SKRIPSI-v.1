<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class TitleVote extends Model
{
    protected $guarded = [];
    public function titleSubmission(){ return $this->belongsTo(TitleSubmission::class); }
    public function dosen(){ return $this->belongsTo(User::class, 'dosen_id'); }
}

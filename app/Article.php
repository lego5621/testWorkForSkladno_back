<?php
  
namespace App;
   
use Illuminate\Database\Eloquent\Model;
   
class Article extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'text', 'published_at', 'user_id', 'urlImage'
    ];

    protected $table = 'article'; 

    public function User()
    {
        return $this->belongsTo('App\Models\User');
    }
}
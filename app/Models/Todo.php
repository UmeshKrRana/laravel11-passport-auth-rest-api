<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'description',
    ];

    /**
     * Function: user
     * @relationType: belongsTo
     */
    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}

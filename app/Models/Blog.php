<?php
/**
 * User: faiz
 * Date: 4/26/16
 * Time: 3:30 PM
 */

namespace Asianatech\Models;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{

    /**
     * Mass-assignment protection prevents fields
     * from being filled by default. Tell the model which
     * fields are fillable.
     *
     * @var array
     */
    protected $fillable = ['author_id', 'title', 'content', 'photo'];
    
    /*
    |--------------------------------------------------------------------------
    | Model Relationship
    |--------------------------------------------------------------------------
    */

    /**
     * Submission hasMany Submission Type relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('Asianatech\Models\User', 'id', 'author_id');
    }
    
}
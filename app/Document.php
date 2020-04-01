<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Document extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'payload',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'payload' => 'array',
    ];

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'modify_at';

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'created_at', 'modify_at',
    ];

    /**
     * Change created_at date format.
     *
     * @param $date
     * @return string
     */
    public function getCreatedAtAttribute($date)
    {
        return \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $date)->setTimezone('Europe/Kiev')->format('Y-m-d H:i:sP');
    }

    /**
     * Change modify_at date format.
     *
     * @param $date
     * @return string
     */
    public function getModifyAtAttribute($date)
    {
        return \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $date)->setTimezone('Europe/Kiev')->format('Y-m-d H:i:sP');
    }

    protected $guarded = [];

    /**
     * Change default id to uuid string.
     *
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($document) {
            $document->{$document->getKeyName()} = (string) Str::uuid();
        });
    }

    /**
     * Disable auto increment id.
     *
     * @return bool
     */
    public function getIncrementing()
    {
        return false;
    }

    /**
     * Get key type.
     *
     * @return string
     */
    public function getKeyType()
    {
        return 'string';
    }

    /**
     * Retrieve user related with the document.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

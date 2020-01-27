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

    protected $dates = [
        'created_at', 'modify_at',
    ];

    public function getCreatedAtAttribute($date)
    {
        return \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $date)->setTimezone('Europe/Kiev')->format('Y-m-d\TH:i:sP');
    }

    public function getModifyAtAttribute($date)
    {
        return \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $date)->setTimezone('Europe/Kiev')->format('Y-m-d\TH:i:sP');
    }

    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($document) {
            $document->{$document->getKeyName()} = (string) Str::uuid();
        });
    }

    public function getIncrementing()
    {
        return false;
    }

    public function getKeyType()
    {
        return 'string';
    }
}

<?php

namespace SLiMS\Models\Default;

use Illuminate\Database\Eloquent\Model;

class Biblio extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'biblio';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'biblio_id';

    /**
     * Indicates if the model's ID is auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = true;

    /**
     * The data type of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'integer';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;

    const CREATED_AT = 'input_date';
    const UPDATED_AT = 'last_update';

    function authors()
    {
        return $this->hasMany(BiblioAuthor::class, 'biblio_id', 'biblio_id');
    }

    function gmd()
    {
        return $this->hasOne(Gmd::class, 'gmd_id', 'gmd_id');
    }

    function publisher()
    {
        return $this->hasOne(Publisher::class, 'publisher_id', 'publisher_id');
    }

    function place()
    {
        return $this->hasOne(Place::class, 'place_id', 'publish_place_id');
    }

    function frequency()
    {
        return $this->hasOne(Frequency::class, 'frequency_id', 'frequency_id');
    }

    function language()
    {
        return $this->hasOne(Language::class, 'language_id', 'language_id');
    }

    function items()
    {
        return $this->hasMany(Item::class, 'biblio_id', 'biblio_id');
    }
}

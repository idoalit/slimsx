<?php
namespace SLiMS\Models\Default;

use Illuminate\Database\Eloquent\Model;

class MemberCustom extends Model {
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'member_custom';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'member_id';

    /**
     * Indicates if the model's ID is auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * The data type of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'string';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    const CREATED_AT = 'input_date';
    const UPDATED_AT = 'last_update';
}

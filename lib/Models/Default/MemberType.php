<?php
namespace SLiMS\Models\Default;

use Illuminate\Database\Eloquent\Model;

class MemberType extends Model {
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'mst_meber_type';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'member_type_id';

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
}

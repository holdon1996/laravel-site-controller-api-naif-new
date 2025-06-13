<?php

namespace ThachVd\LaravelSiteControllerApi\Models;

use Illuminate\Database\Eloquent\Model;

class TllincolnCancelPolicyDetail extends Model
{
    protected $table = 'tllincoln_cancel_policy_details';

    protected $fillable = [
        'tllincoln_cancel_policy_id',
        'tllincoln_percent',
        'tllincoln_amount',
        'tllincoln_currency_code',
        'tllincoln_from',
        'tllincoln_to',
    ];
}

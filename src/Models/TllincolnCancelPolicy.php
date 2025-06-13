<?php

namespace ThachVd\LaravelSiteControllerApi\Models;

use Illuminate\Database\Eloquent\Model;

class TllincolnCancelPolicy extends Model
{
    protected $table = 'tllincoln_cancel_policies';

    protected $fillable = [
        'tllincoln_hotel_code',
        'tllincoln_cancel_policy_code',
        'tllincoln_cancel_policy_text',
        'tllincoln_percent_no_show',
        'tllincoln_amount_no_show',
        'tllincoln_currency_code_no_show',
    ];
    
}

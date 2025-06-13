<?php

namespace ThachVd\LaravelSiteControllerApi\Models;

use Illuminate\Database\Eloquent\Model;

class TllincolnCancelPolicyPlan extends Model
{
    protected $table = 'tllincoln_cancel_policy_plans';

    protected $fillable = [
        'tllincoln_cancel_policy_id',
        'tllincoln_plan_code',
    ];
}

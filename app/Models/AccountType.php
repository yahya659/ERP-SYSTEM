<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccountType extends Model
{
    //
   protected $table="accauont_types";
       protected $fillable = [//حقول المسموح تعبتها
       'name','active','relatedternalaccounts'
    ];
}

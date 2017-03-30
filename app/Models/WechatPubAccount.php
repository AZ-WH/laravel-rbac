<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WechatPubAccount extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [
        'sync_status'
    ];


    protected $table = 'wechat_pub_accounts';
}

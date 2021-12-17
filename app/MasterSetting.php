<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MasterSetting extends Model
{
    protected $fillable=['master_title','master_value'];
    public $timestamps = false;

    /* master settings value update settings */
    public function siteData(){
        $siteInfo=array();
        foreach($this->get() as $key=>$value){
            $siteInfo[$value['master_title']]=$value['master_value'];
        }
        return $siteInfo;
    }
}
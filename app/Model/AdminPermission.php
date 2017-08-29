<?php

namespace App\Model;
class AdminPermission extends Model
{
    protected $table="admin_permissions";
    /**
     * @param
     * @name 权限属于那个角色
     * @return $this
     */
    public function roles(){
        return $this->belongsToMany(AdminRole::class,'admin_permission_role','role_id','permission_id')->withPivot(['permission_id','role_id']);
    }
}

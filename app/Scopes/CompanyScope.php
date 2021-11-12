<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\Model\User;

class CompanyScope implements Scope
{    /**
     * 应用作用域到给定的Eloquent查询构建器.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return void
     * @translator laravelacademy.org
     */
    public function apply(Builder $builder, Model $model)
    {
		$account=auth("api")->user();
		
		if($account&&$user=User::withoutGlobalScopes()->where('id',$account->user_id)->first()){
			return $builder->where('company_id', $user->company_id);
		}
    }
}

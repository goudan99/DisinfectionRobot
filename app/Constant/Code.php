<?php
namespace App\Constant;

class Code
{
    public const SUCCESS = 0;     //操作成功
    public const FAIL = 100;      //操作失败
    public const BUSY = 501;      //服务器繁忙
    public const ERROR = 500;     //服务错误
    public const NOTFOUND = 101;  //资源不存在了
    public const ATTACH = 102;    //依赖资源不存
    public const UNIQUE = 103;    //依赖资源不存
    public const VALIDATE = 422;  //字段验证失败
    public const LOGIN = 401;     //没有授权
    public const AUTH = 402;      //权限不足

}

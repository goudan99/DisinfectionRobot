# 扫地机器人介绍 
扫地机器人是一个物联网项目，该项目由三部分组成，后端程序（本代码），后台管理（vue）,前台小程序。

## 系统架构
### 使用的技术栈
1. php7.2以上，php8以及必须有以下扩展插件件
1.1 PHP_OpenSSL
1.2 PHP_PDO
1.3 PHP_PDO_Mysql
1.4 PHP_Mbstring
1.5 PHP_XML
1.6 PHP_JSON
1.7 PHP_CURL
1.8 PHP_GD
2. mysql5.7及其以上
3. laravel8
启swoole还需要以下组件
swoole
mysqlnd 
### 软件架构图


## 部署说明
- 1,运行 composer install下载插件
- 2,修改 env文件   
- 3,运行 php artisan migration下载插件
- 4,运行 php artisan db:seed 生成基础数据
### 初始化帐号
初始化账号：admin/admin888

## 功能说明


### 权限管理
- 1,用户管理
- 2,角色管理
- 3,权限限管理
- 4,授权管理

### 个人信息
- 1,个人信息设置
- 2,个人通信息

### 系统配置
- 1,菜单管理
- 2,菜单权限



## 更新说明

## 引用到的插件
1.  Laravel  [https://laravel.com/docs/8.x](https://laravel.com/docs/8.x)
2.  tymon/jwt-auth  [https://github.com/tymondesigns/jwt-auth)
3.  Laravel-Swoole  [https://github.com/swooletw/laravel-swoole)
4.  eayswechat  [https://www.easywechat.com/](https://www.easywechat.com/)
5.  php-amqplib  [https://github.com/php-amqplib/php-amqplib/)
6.  php-mqtt [https://github.com/php-mqtt/client](https://github.com/php-mqtt/client)

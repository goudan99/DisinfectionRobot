# 项目介绍 
## 开发目的
市面上虽然有很多开源的商城的系统，但进行二次开发不够友善。主要表现在以下二点。
- 1,对接其他系统，如公司现有的仓库系统，HR系统，客服系统等。
- 2,增加其他其他营销手段，如红包，打折，抢购，渠道推广等
## 开发目标
主要做一个比较通用简单通用的商城系统,利于具体需求商城的增加及改进

## 系统加构
### 使用的技术栈
1、php7.2以上，php8暂有些功能不支持
2、mysql5.7及其以上
3、laravel8

### 架构特色
- 1、易懂
-- 1、少,少量自己标准，尽可能使用通用标准
-- 2、微,一个文件，只适度几个功能
-- 3、小,在符合标准前提下，尽量做到框架简易程度
- 2、易扩展：
-- 1、尽可能采用先开发后配置
-- 2、采用管道及配置处理方法，除基础功能以外能，能轻松扩充，修改,删除功能
- 3、高维护:
-- 1、结构、功能、接口等标准化
-- 2、尽量做到处任意错误能捕捉到

## 部署说明
- 1,运行 composer install下载插件
- 2,在控制台运行 
php artisan passport:install --uuids 
找到Password grant client created successfully.
复制 Client ID值到 env文件 AUTH_CLIENT
复制 Client secret值到 env文件 AUTH_SECRET
- 3,修改 env文件   
- 4,运行 php artisan db:seed 生成基础数据

### 初始化帐号
前端地址  [manager](gitee.com/heekit-mall/manager)
初始化账号：admin/admin888

## 功能说明
- 1,登录退出
- 2,创建、修改、删除管理员，及设置所属角色
- 3,创建、修改、删除角色，及增加修改删除角色权限
- 4,创建、修改、删除菜单，及增加修改删除菜单权限
- 5,前端日志保存,查看,删除
- 6,后端日志查看,删除
- 7,查看系统所有权限
- 8,保存及读取系统配置
- 9,修改个人信息，修改个人密码。修改个头像
- 10,查看个人通知，已读个人通知，删除及恢复个人通知
- 11,获取个人通知未读条数

## 更新说明

## 引用到的插件
1.  Laravel  [https://laravel.com/docs/8.x](https://laravel.com/docs/8.x)
2.  Laravel passport  [https://laravel.com/docs/8.x/passport](https://laravel.com/docs/8.x/passport)
3.  Laravel Excel  [https://laravel-excel.com/](https://laravel-excel.com/)
4.  eayswechat  [https://www.easywechat.com/](https://www.easywechat.com/)

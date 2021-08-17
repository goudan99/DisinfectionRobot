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

###软件架构图
稍后再上



## 部署说明
- 1,运行 composer install下载插件
- 2,在控制台运行 
php artisan passport:install --uuids 
找到Password grant client created successfully.
复制 Client ID值到 env文件AUTH_CLIENT
复制 Client secret值到 env文件 AUTH_SECRET

- 3,修改 env文件   
- 4,运行 php artisan db:seed 生成基础数据

### 初始化帐号
初始化账号：admin/admin888

## 功能说明
本系统只做一些普通通用的功能，其他功能需要自己进行二次开发，

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
2.  Laravel passport  [https://laravel.com/docs/8.x/passport](https://laravel.com/docs/8.x/passport)
3.  Laravel Excel  [https://laravel-excel.com/](https://laravel-excel.com/)
4.  eayswechat  [https://www.easywechat.com/](https://www.easywechat.com/)

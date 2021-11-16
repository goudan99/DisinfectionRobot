# 扫地机器人接口文档

## 版本编号说明
首位为大版本变更，若有与之存在相同的api，则新旧是不不能兼容  
第二们功能变,能否兼容会有有说明  
第三位为修正编号，作出调整能与之前兼容  

## 版本历史

|名称|说明|
|-|-|-|
|1.0.0|  |
|1.2.0|  |

## 版本说明
 ### v1.0.2:  
 此版本主要进一步接口字段标准化,对一些手机验证码进一步统一化,另外新增几个接口
 
 ### 功能变更:
 - 1/auth/register 
   - 新增了一个 wechat_code 微信小程序code值
   - 新增了一个 nickname 用户昵称,可以为空
 - 2,/auth/login/token 
   - 新增了一个 wechat_code 微信小程序code值
 - 3,/auth/login/phone 
   - 新增了一个 wechat_code 微信小程序code值
   - 修改code为 phone_code
 - 4,auth/login/program
   - 修改code为 wechat_code
 - 5,/profile/user
   - 移除了name
 - 6,/profile/phone
   - 修改code为 phone_code
 - 7,/profile/password
   - 修改code为 phone_code
 - 8,/member/user
   - 修改post为添加 put修改  
 - 9,/robot/machine
   - 新增macid
   - 新增macid 机器的macid
   - 新增job_status 任务状态
   - 新增job_progress 任务进度
   - 新增power_num 剩余电量
   - 新增work_area 累计工作面积
   - 新增work_time 累计工作时间
   - 新增work_num 累计工作次数
   - 新增cpu_tempe cpu温度
   - 新增cpu_usage cpu使用量
   - 新增hdd_usage 硬盘使用量
   - 新增wifi_name wifi名称
   - 新增wifi_stronge wifi信号强度
   - 新增wifi_stronge wifi类型
   - 新增wifi_ip  wifi ip
   - 新增wifi_macid  wifi 物理地址
   - 新增move_speed 移动速度
   - 新增power_setting 充电设置
 - 10,/profile/notice  
   - 新增form_id消息来源
 ### 功能新增:
   1,用户权限: get /profile/access
   2,发送通知: post /profile/notice
   3,添加反馈: post /me/feedback
   4,删除反馈: delete /me/feedback
   6,反馈图片: post /me/feedback/upload
## api接口说明
 本接口文档api文档返回格式请求成功统一为

|名称|类型|说明|
|-|-|-|
|code| int | 状态码，0为成功|
|data| json| 返回内容 |
|msg | string | 返回说明 |

成功样例
```
{
    "code": 0,
    "msg": "请求成功",
    "data": [],
    "timestamp": 1631254154
}
```
失败样例（带数据据返回）
```
{
    "code": 422,
    "msg": "数据验证不正确",
    "data": {
        "phone": [
            "国内的手机号码长度为11位"
        ]
    }
}
```
失败样例（不带数据据返回）
```
{
    "code": 100,
    "msg": "请求失败",
    "data": ""
}
```
### 状态说明：
|code|说明|
|-|-|
|0 | 成功|
|100| 失败 |
|501| 服务器繁忙 |
|500| 服务务器错误 |
|401| 没有授权 |
|403| 请求下级依赖资源不存在 |
|405| 权限不足，没有权限操作此资源 |
|409| 已经存在该资源了 |
|422| 字段验证失败 |
|419| token丢失 |

### 授权说明：
请注意写有面要授权的接品，需要带上token格式如果放在header格式如上  

|名称|类型|说明|
|-|-|-|
|Authorization| sring | Bearer $token|

```
{
Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vbG9jYWxob3N0OjgwODEvYXBpL2F1dGgvbG9naW4vdG9rZW4iLCJpYXQiOjE2MzI4MjI3OTMsImV4cCI6MTYzMjgyNjM5MywibmJmIjoxNjMyODIyNzkzLCJqdGkiOiJ5c3VGaVFGZjJOQXJGQjM5Iiwic3ViIjoxLCJwcnYiOiJlMzkxMzU1ZTRmZGUxY2YyMWVkNzFiODM1ZTJmMzA1Y2M2N2Q3Y2M2IiwiMCI6IiJ9.1SJcsKW-JAoa1wtYAR5ol0DYkYbABsKiqSs3MpsGkvA
}
```
如果放在请求头上则直接,?token=$token,如
```
http://www.robot.com/?token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vbG9jYWxob3N0OjgwODEvYXBpL2F1dGgvbG9naW4vdG9rZW4iLCJpYXQiOjE2MzI4MjI3OTMsImV4cCI6MTYzMjgyNjM5MywibmJmIjoxNjMyODIyNzkzLCJqdGkiOiJ5c3VGaVFGZjJOQXJGQjM5Iiwic3ViIjoxLCJwcnYiOiJlMzkxMzU1ZTRmZGUxY2YyMWVkNzFiODM1ZTJmMzA1Y2M2N2Q3Y2M2IiwiMCI6IiJ9.1SJcsKW-JAoa1wtYAR5ol0DYkYbABsKiqSs3MpsGkvA

```
## 公共接口
### 获取手机验证码
接口地址：/public/mobile/code  
返回格式:josn  
是否需要授权：部分需要 type=2需要验证  
请求方式：post  
请内容：

| 参数 | 类型| 方式 | 是否必填 | 说明 |
|-|-|-|-|-|
|phone| string| josn | 是 | 手机号 |
|type| string| josn | 是 | 要获取验证码类型,0为注册，1为找密码，2更改密码，3 更改密码，4更改手机确认新手机，5手机验证码登录|

返回：空

请求样例：
```
{
    "phone":"15113339677",
    "type":"2"
}
```
返回样例：
```
{
    "code": 0,
    "msg": "验证码发送成功，请注意查收",
    "data": [],
    "timestamp": 1633944173
}
```
### 公开的配置文件
接口地址：/public/config  
返回格式:josn  
是否需要授权：否  
请求方式：get  
 格式待定

## 授权
授权流程
用用户名帐号密码登录拿到token值

### 用户注册
接口地址：/auth/register  
返回格式:josn  
是否需要授权：否  
请求方式：post  
请内容： 

| 参数 | 类型| 方式 | 是否必填 | 说明 |
|-|-|-|-|-|
|nickname| string| josn | 否 | 用户昵称  v1.0.2前新增|
|phone| string| josn | 是 | 手机号，注册的手机号 |
|phone_code| string| josn | 是 | 手机验证码 |
|invite_code| string| josn | 是 | 邀请码 |
|wechat_code| string| josn | 否 | 小程序code值 v1.0.2前新增 |
|password| string| josn | 是 | 新密码 |
|password_confirmation| string| josn | 是 | 确认新密码 |

返回:空

请求样例：
```
{
    "nickname":"测试用户",
    "phone":"13800138000",
    "phone_code":"123123",
    "wechat_code":"cxPidsfs",
    "invite_code":"78900",
    "password":"123123",
    "password_confirmation":"123123"
}
```
返回样例：
```
{
    "code": 0,
    "data": "",
    "msg": "注册成功",
    "timestamp": 1631245833
}
```
### 用户帐号名密码登录
接口地址：/auth/login/token  
返回格式:josn  
是否需要授权：否  
请求方式：post  
请内容：

| 参数 | 类型| 方式 | 是否必填 | 说明 |
|-|-|-|-|-|
|username| string| josn | 是 | 登录帐号 |
|password| string| josn | 是 | 登录密码 |
|wechat_code| string| josn | 否 | 小程序code值,v1.0.2前新增 |

返回格式:

| 字段 | 类型 | 说明 |
|-|-|-|
| token_type | string | token类型|
| expires_in | int | token到期时间|
| access_token | string | token值|

请求样例：
```
{
    "username": "13800138000",
    "password": "admin888",
    "wechat_code": "123456789",
}
```
返回样例：
```
{
    "code": 0,
    "data": {
        "token_type": "Bearer",
        "expires_in": 31536000,
        "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiI5NDNjNzk2Mi1kYmYyLTQ3ZTQtYTA3OC1mNDcwMTY3NGRiNDYiLCJqdGkiOiIwZDU4ODE5MjA0ZjEzOWViOWQxNmJhNTUyZThiNGIyNzU1MjllOGNhZGE1NDc2YjI0YTI0ZmQxM2FjMDEwZDYxNzdiNDRjNTMyOGM4YzU2NSIsImlhdCI6MTYzMTI0NTgzMywibmJmIjoxNjMxMjQ1ODMzLCJleHAiOjE2NjI3ODE4MzMsInN1YiI6IjEiLCJzY29wZXMiOltdfQ.LYE80c7IQe9qqLc5Kb0qPdoCouHDC13zWgqBNRjsD133UyB_hSJLPftzb2RP4HEzwcvdFs1WmurWIk5iWSxFkwDqdZSNeIPxXp6qMubN1zVwD-X-B2-dh0Hu7tS9LcAraOhZDz0_Wqf8YoOn4NyMp_ds2gvaADP9Xkpxexeg3eoV78lJb4Sx89L00aEiAxn2HattueA_fatVKxztueU_iH8u-25sB-vJFKdmoXIV-VF9EH4inxDh6hPvFBPT_iH6YFzBFHBSln7bu7JBudXamFT4fg0d5dubDVs78ZX4uSD0CPEyda7CY39UDFkICT8ltKCcF_zHsCc0FcSjU2G2KomB9eHo7Ga3L99M4I0KqrXnFKAHq44G0vOP1k4PYlxsISqOPeqILYck30iszttRbxpBSu4YIf0-i2nO07vsjrVW-LXKXQPqeUQTebgnTgPi0nZz7Svh7BWrBhFP3iaERQKUbAnLOSuy-zLPf3j10L-Ap9PGBJMny6w6T-7Okld7WTYjpv5R3TT6i7PnyatBQosLbxkSXuiOpilsMNOaWa0Yv73c31TLHwX1u70rPXPq5p9VRHnZJPzxveWdBP5atBNELpiTXiZwup8eThj64O80QbN86SAuCJF9Sl6Yhim6BMQIwVDUnaWxKFhgTuChgK5KqkoYPymnQZj5heGl1mM"
    },
    "msg": "success",
    "timestamp": 1631245833
}
```
### 手机验证码登录  
接口地址：/auth/login/phone  
返回格式:josn  
是否需要授权：否  
请求方式：post  
请内容：

| 参数 | 类型| 方式 | 是否必填 | 说明 |
|-|-|-|-|-|
|phone| string| josn | 是 | 手机号 |
|phone_code| string| josn | 是 | 手机验证码code值，旧版为1.0.2前是code |
|wechat_code| string| josn | 否 | 小程序code值 |

data说明

| 字段 | 类型 | 说明 |
|-|-|-|
| token_type | string | token类型|
| expires_in | int | token到期时间|
| access_token | string | token值|

请求样例：
```
{
    "username": "admin",
    "phone_code": "123456",
    "wechat_code": "123456789"
}
```
返回样例：
```
{
    "code": 0,
    "data": {
        "token_type": "Bearer",
        "expires_in": 31536000,
        "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiI5NDNjNzk2Mi1kYmYyLTQ3ZTQtYTA3OC1mNDcwMTY3NGRiNDYiLCJqdGkiOiIwZDU4ODE5MjA0ZjEzOWViOWQxNmJhNTUyZThiNGIyNzU1MjllOGNhZGE1NDc2YjI0YTI0ZmQxM2FjMDEwZDYxNzdiNDRjNTMyOGM4YzU2NSIsImlhdCI6MTYzMTI0NTgzMywibmJmIjoxNjMxMjQ1ODMzLCJleHAiOjE2NjI3ODE4MzMsInN1YiI6IjEiLCJzY29wZXMiOltdfQ.LYE80c7IQe9qqLc5Kb0qPdoCouHDC13zWgqBNRjsD133UyB_hSJLPftzb2RP4HEzwcvdFs1WmurWIk5iWSxFkwDqdZSNeIPxXp6qMubN1zVwD-X-B2-dh0Hu7tS9LcAraOhZDz0_Wqf8YoOn4NyMp_ds2gvaADP9Xkpxexeg3eoV78lJb4Sx89L00aEiAxn2HattueA_fatVKxztueU_iH8u-25sB-vJFKdmoXIV-VF9EH4inxDh6hPvFBPT_iH6YFzBFHBSln7bu7JBudXamFT4fg0d5dubDVs78ZX4uSD0CPEyda7CY39UDFkICT8ltKCcF_zHsCc0FcSjU2G2KomB9eHo7Ga3L99M4I0KqrXnFKAHq44G0vOP1k4PYlxsISqOPeqILYck30iszttRbxpBSu4YIf0-i2nO07vsjrVW-LXKXQPqeUQTebgnTgPi0nZz7Svh7BWrBhFP3iaERQKUbAnLOSuy-zLPf3j10L-Ap9PGBJMny6w6T-7Okld7WTYjpv5R3TT6i7PnyatBQosLbxkSXuiOpilsMNOaWa0Yv73c31TLHwX1u70rPXPq5p9VRHnZJPzxveWdBP5atBNELpiTXiZwup8eThj64O80QbN86SAuCJF9Sl6Yhim6BMQIwVDUnaWxKFhgTuChgK5KqkoYPymnQZj5heGl1mM"
    },
    "msg": "success",
    "timestamp": 1631245833
}
```
### 小程序登录  
接口地址：/auth/login/program  
返回格式:josn  
是否需要授权：否  
请求方式：post  
请内容：

| 参数 | 类型| 方式 | 是否必填 | 说明 |
|-|-|-|-|-|
|wechat_code| string| josn | 是 | 小程序code值,v1.0.2前为code |

data说明

| 字段 | 类型 | 说明 |
|-|-|-|
| token_type | string | token类型|
| expires_in | int | token到期时间|
| session_key | string | 小程序session_key|
| access_token | string | token值|

请求样例：
```
{
    "wechat_code": "12333223",
}
```
返回样例：
```
{
    "code": 0,
    "data": {
        "token_type": "Bearer",
        "expires_in": 31536000,
        "session_key" :"111",
        "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiI5NDNjNzk2Mi1kYmYyLTQ3ZTQtYTA3OC1mNDcwMTY3NGRiNDYiLCJqdGkiOiIwZDU4ODE5MjA0ZjEzOWViOWQxNmJhNTUyZThiNGIyNzU1MjllOGNhZGE1NDc2YjI0YTI0ZmQxM2FjMDEwZDYxNzdiNDRjNTMyOGM4YzU2NSIsImlhdCI6MTYzMTI0NTgzMywibmJmIjoxNjMxMjQ1ODMzLCJleHAiOjE2NjI3ODE4MzMsInN1YiI6IjEiLCJzY29wZXMiOltdfQ.LYE80c7IQe9qqLc5Kb0qPdoCouHDC13zWgqBNRjsD133UyB_hSJLPftzb2RP4HEzwcvdFs1WmurWIk5iWSxFkwDqdZSNeIPxXp6qMubN1zVwD-X-B2-dh0Hu7tS9LcAraOhZDz0_Wqf8YoOn4NyMp_ds2gvaADP9Xkpxexeg3eoV78lJb4Sx89L00aEiAxn2HattueA_fatVKxztueU_iH8u-25sB-vJFKdmoXIV-VF9EH4inxDh6hPvFBPT_iH6YFzBFHBSln7bu7JBudXamFT4fg0d5dubDVs78ZX4uSD0CPEyda7CY39UDFkICT8ltKCcF_zHsCc0FcSjU2G2KomB9eHo7Ga3L99M4I0KqrXnFKAHq44G0vOP1k4PYlxsISqOPeqILYck30iszttRbxpBSu4YIf0-i2nO07vsjrVW-LXKXQPqeUQTebgnTgPi0nZz7Svh7BWrBhFP3iaERQKUbAnLOSuy-zLPf3j10L-Ap9PGBJMny6w6T-7Okld7WTYjpv5R3TT6i7PnyatBQosLbxkSXuiOpilsMNOaWa0Yv73c31TLHwX1u70rPXPq5p9VRHnZJPzxveWdBP5atBNELpiTXiZwup8eThj64O80QbN86SAuCJF9Sl6Yhim6BMQIwVDUnaWxKFhgTuChgK5KqkoYPymnQZj5heGl1mM"
    },
    "msg": "success",
    "timestamp": 1631245833
}
```
### 找密码
接口地址：/auth/find/password  
返回格式:josn  
是否需要授权：否  
请求方式：post  
请内容：

| 参数 | 类型| 方式 | 是否必填 | 说明 |
|-|-|-|-|-|
|phone| string| josn | 是 | 手机号，要更改帐号的手机号 |
|phone_code| josn | string| josn | 是 | 小程序code值,v1.0.2前是code |
|password| string| josn | 是 | 新密码 |
|password_confirmation| string| josn | 是 | 确认新密码 |

返回：空 

请求样例：
```
{
    "phone":"15113339677",
    "phone_code":"1848306182",
    "password":"123123",
    "password_confirmation":"123123"
}
```

返回样例：
```
{
    "code": 0,
    "data": "",
    "msg": "密码重置成功",
    "timestamp": 1631245833
}
```

### 退出
接口地址：/login/logout  
返回格式:josn  
是否需要授权：是  
请求方式：any  
请求样例：
```
/login/logout
```

返回样例：
```
{
    "code": 0,
    "data": "",
    "msg": "已退出",
    "timestamp": 1631245833
}
```

## 个人信息

### 获取个人信息  
接口地址：/profile/user  
返回格式:josn   
是否需要授权：是  
请求方式：get  
返回data说明  

| 字段 | 类型 | 说明 |
|-|-|-|
| id | string | 用户id|
| nickname| string| 用户昵称 |
| phone| string| 用户手机 |
| code| string| 邀请码 |
| openid| string| 小程序ipenid |
| avatar| string| 用户头像 |
| last_at| string| 上次登录时间 |
| last_ip| string| 上次登录ip |
| passed| string| 是否审核，默认审核通过 |
| is_system| string| 是否为系统用户 |
| desc| string| 用户描述 |
| created_at | datetime | 创建时间|
| updated_at | datetime | 更新时间|

请求样例：
```
profile/user
```
返回样例：
```
{
    "code": 0,
    "msg": "获取成功",
    "data": {
        "id": 1,
        "nickname": "管理员",
        "phone": "15113339677",
        "code": "",
        "openid": "",
        "avatar": "/img/nopic.jpg",
        "last_at": "2019-05-20 00:00:00",
        "last_ip": "127.0.0.1",
        "login_times": 195,
        "passed": 1,
        "is_system": 1,
        "is_first": 2,
        "desc": "系统用户",
        "created_at": null,
        "updated_at": null
    },
    "timestamp": 1633941348
}
```


### 获取个人权限  
接口地址：/profile/access  
返回格式:josn   
是否需要授权：是  
请求方式：get  
返回data说明  

| 字段 | 类型 | 说明 |
|-|-|-|
| id | string | 权限id|
| parent_id | int | 权限所依赖上一级权限|
| name | string | 权限名|
| code | string | 权限标识，为了后续扩展肜|
| path | string | 权限路径|
| desc | string | 权限描述|
| created_at | string | 创建时间|
| updated_at | string | 更新时间|


请求样例：
```
profile/access
```
返回样例：
```
{
    "code": 0,
    "msg": "操作成功",
    "data": [
        {
            "id": 1,
            "parent_id": 0,
            "name": "用户管理",
            "code": "safe",
            "path": "/api/member/user",
            "method": "GET",
            "desc": "",
            "created_at": null,
            "updated_at": null
        },
        {
            "id": 2,
            "parent_id": 1,
            "name": "添加用户",
            "code": "user",
            "path": "/api/member/user",
            "method": "POST",
            "desc": "",
            "created_at": null,
            "updated_at": null
        }
    ],
    "timestamp": 1635500916
}
```

### 修改个人信息
接口地址：/profile/user  
返回格式:josn  
是否需要授权：是  
请求方式：post  

请内容：

| 参数 | 类型| 方式 | 是否必填 | 说明 |
|-|-|-|-|-|
| nickname| string| josn | 否 | 用户昵称 |
| avatar| string| josn | 否 | 用户头像 |

请求样例：
```
{
    "nickname":"好人",
    "avatar":"/img/123.jpg"
}
```
返回样例：
```
{
    "code": 0,
    "data": "",
    "msg": "操作成功",
    "timestamp": 1631245833
}
```
### 上传头像
接口地址：/profile/avatar  
返回格式:josn  
是否需要授权：是  
请求方式：post  

请内容：

| 参数 | 类型| 方式 | 是否必填 | 说明 |
|-|-|-|-|-|
| file| blob| josn | 是 | 文件 |

### 修改手机
接口地址：/profile/phone    
返回格式:josn  
是否需要授权：是  
请求方式：post  

请内容：

| 参数 | 类型| 方式 | 是否必填 | 说明 |
|-|-|-|-|-|
| oldcode| string| josn | 否 | 旧手机验证码 |
| phone| string| josn | 否 | 新手机号 |
| phone_code| string| josn | 否 | 新手机验证码,v1.0.2前为code |

请求样例：
```
{
    "oldcode":"123456",
    "phone":"13800011380",
    "phone_code":"234567"
}
```
返回样例：
```
{
    "code": 0,
    "data": "",
    "msg": "操作成功",
    "timestamp": 1631245833
}
```
### 修改密码
接口地址：/profile/password  
返回格式:josn  
是否需要授权：是  
请求方式：post  

请内容：

| 参数 | 类型| 方式 | 是否必填 | 说明 |
|-|-|-|-|-|
| phone_code| string| josn | 是 | 手机验证码,v1.0.2前为code |
| password| string| josn | 是 | 新密码 |

请求样例：
```
{
    "phone_code":"123456",
    "password":"456789012"
}
```
返回样例：
```
{
    "code": 0,
    "data": "",
    "msg": "操作成功",
    "timestamp": 1631245833
}
```
### 获取个人菜单
接口地址：/profile/menu  
返回格式:josn  
是否需要授权：是  
请求方式：get  
返回data说明

| 字段 | 类型 | 说明 |
|-|-|-|
| id | string | 菜单id|
| parent_id| string| 上级菜单id |
| name| string| 菜单名 |
| desc| string| 菜单描述 |
| prefix| string| 菜单前缀 |
| path| string| 菜单路径 |
| icon| string| 菜单图片 |
| target| string| 打开方式 |
| order| string| 菜单排序 |
| status| string| 菜单状态 |
| is_system| string| 是否为系统菜单 |
| created_at | datetime | 创建时间|
| updated_at | datetime | 更新时间|

请求样例：
```
profile/menu
```
返回样例：
```
{
    "code": 0,
    "msg": "获取成功",
    "data": [
        {
            "id": 1,
            "parent_id": 0,
            "name": "权限管理",
            "desc": null,
            "prefix": "/",
            "path": "",
            "icon": "",
            "target": "_self",
            "order": 1,
            "status": 1,
            "is_system": 1,
            "created_at": null,
            "updated_at": null
        },
        {
            "id": 2,
            "parent_id": 1,
            "name": "系统用户",
            "desc": null,
            "prefix": "/",
            "path": "member/user",
            "icon": "",
            "target": "_self",
            "order": 1,
            "status": 1,
            "is_system": 1,
            "created_at": null,
            "updated_at": null
        }
    ],
    "timestamp": 1633943239
}
```

### 获取个人通知
接口地址：/profile/notice  
返回格式:josn  
是否需要授权：是  
请求方式：get  
返回data说明

| 字段 | 类型 | 说明 |
|-|-|-|
| id | string | 消息id|
| user_id| string| 所属用户id |
| title| string| 消息标题 |
| content| string| 消息内容 |
| is_read| string| 是否已读 |
| type| string| 消息类型 |
| created_at | datetime | 创建时间|
| updated_at | datetime | 更新时间|
| deleted_at | datetime | 删除时间|

请求样例：
```
profile/notice
```
返回样例：
```
{
    "code": 0,
    "msg": "",
    "data": [
        {
            "id": 1,
            "user_id": 1,
            "title": "asda",
            "content": "ss",
            "is_read": 1,
            "type": 1,
            "deleted_at": null,
            "created_at": null,
            "updated_at": null
        }
    ],
    "timestamp": 1633943527
}
```

### 发送通知
接口地址：/profile/notice  
返回格式:josn  
是否需要授权：是  
请求方式：post  

请内容：

| 参数 | 类型| 方式 | 是否必填 | 说明 |
|-|-|-|-|-|
| user_id| int| josn | 否 | 接收者用户id |
| title| string| josn | 否 | 通知消息标题 |
| content| string| josn | 否 | 通知消息内容 |
| type| int| josn | 否 | 新手机验证码,v1.0.2前为code |

请求样例：

```
{
    "title":"消息三",
    "user_id":2,
    "content":"消息内容三"
}
```

返回样例：

```
{
    "code": 0,
    "msg": "",
    "data": "操作成功",
    "timestamp": 1636948307
}
```

### 获取通知详情
接口地址：/profile/notice/{id}  
返回格式:josn  
是否需要授权：是  
请求方式：get  
返回data说明  

| 字段 | 类型 | 说明 |
|-|-|-|
| id | string | 消息id|
| user_id| string| 所属用户id |
| title| string| 消息标题 |
| content| string| 消息内容 |
| is_read| string| 是否已读 |
| type| string| 消息类型 |
| created_at | datetime | 创建时间|
| updated_at | datetime | 更新时间|
| deleted_at | datetime | 删除时间|

请求样例：
```
profile/notice/1
```
返回样例：
```
{
    "code": 0,
    "msg": "",
    "data": {
        "id": 1,
        "user_id": 1,
        "title": "asda",
        "content": "ss",
        "is_read": 1,
        "type": 1,
        "form_id": 1,
        "deleted_at": null,
        "created_at": null,
        "updated_at": null
    }
    "timestamp": 1633943527
}
```
### 设置消息已读
接口地址：/profile/notice/{id}  
返回格式:josn  
是否需要授权：是  
请求方式：put  
请求样例：
```
profile/notice/1
```
返回样例：
```
{
    "code": 0,
    "data": "",
    "msg": "操作成功",
    "timestamp": 1631245833
}
```

### 设置消息置顶
接口地址：/profile/notice/{id}/top
返回格式:josn  
是否需要授权：是  
请求方式：put  
请求样例：
```
profile/notice/1/top
```
返回样例：
```
{
    "code": 0,
    "data": "",
    "msg": "操作成功",
    "timestamp": 1631245833
}
```

### 删除消息  
接口地址：/profile/notice/{id}  
返回格式:josn  
是否需要授权：是  
请求方式：delete  
请求样例：
```
profile/notice/1
```
返回样例：
```
{
    "code": 0,
    "data": "",
    "msg": "操作成功",
    "timestamp": 1631245833
}
```
### 恢复消息
接口地址：/profile/notice/{id}  
返回格式:josn  
是否需要授权：是  
请求方式：patch  
请求样例：
```
profile/notice/1
```
返回样例：
```
{
    "code": 0,
    "data": "",
    "msg": "操作成功",
    "timestamp": 1631245833
}
```

## 机器人管理

### 所有机器
接口地址：/robot/machine 
返回格式:josn 
是否需要授权：是 
请求方式：get 
请求内容：

| 参数 | 数据类型| 请求方式 | 是否必填 | 说明 |
|-|-|-|-|-|
|page| int| request | 否 | 当前页,默认1 |
|limit| int| request | 否 | 一页条数，默认是10 |
|key| string| request | 否 | 搜索关键字 |
|status| boolen| request | 否 | 机器状态，0为正常，1机器正在任务中 |

返回data说明

| 字段 | 类型 | 说明 |
|-|-|-|
| data | array | 用户数据|
| total | int | 总条数|
| page | int | 当前页数|
| limit | int | 一页条数|

返回data说明

| 字段 | 类型 | 说明 |
|-|-|-|
| id | int | 机器id|
| name | string | 机器名|
| mac_id | int | 机器macid |
| sn | int | 机器序列号|
| job_id | int | 机器所做的任务 |
| job_status | int | 任务状态0-5 |
| job_progress | int | 任务进度 |
| power_num | int | 机器电量 |
| machine_area | string | 机器位置 |
| work_area | int | 累计工作面积 |
| work_time | int | 累计工作时间 |
| work_num | int | 累计工作次数 |
| cpu_tempe | int | cpu温度 |
| cpu_usage | int | cpu使用量 |
| hdd_usage | int | 硬盘使用量 |
| wifi_name | string | wifi名称 |
| wifi_stronge | int | wifi强度 |
| wifi_type | string | wifi类型 |
| wifi_ip | string | wifi ip |
| wifi_macid | string | wifi macid |
| disinfect_num | int | 消毒液体剩余数量 |
| move_speed | int | 移动速度 |
| power_setting | int | 充电设置 |
|status| boolen | 机器状态，0为正常，1机器正在任务中 |

请求样例：
```
robot/machine?page=1&limit=10&key=&status=0
```
返回样例：
```
{
    "code": 0,
    "msg": "",
    "data": {
        "data": [
            {
                "id": 147,
                "name": "天空一号",
                "sn": "Test001",
                "status": null,
                "access": null,
                "macid": null,
                "disinfect_num": null,
                "move_speed": 44,
                "job_status": null,
                "job_progress": null,
                "power_num": null,
                "power_setting": 17,
                "machine_area": null,
                "work_area": null,
                "work_time": null,
                "work_num": null,
                "cpu_tempe": null,
                "cpu_usage": null,
                "hdd_usage": null,
                "wifi_name": null,
                "wifi_stronge": null,
                "wifi_type": null,
                "wifi_ip": null,
                "wifi_macid": null,
                "created_at": "2021-11-13T07:49:17.000000Z",
                "updated_at": "2021-11-13T07:53:21.000000Z"
            },
            {
                "id": 109,
                "name": "3333",
                "sn": "1212",
                "status": null,
                "access": null,
                "macid": null,
                "disinfect_num": null,
                "move_speed": null,
                "job_status": null,
                "job_progress": null,
                "power_num": null,
                "power_setting": null,
                "machine_area": null,
                "work_area": null,
                "work_time": null,
                "work_num": null,
                "cpu_tempe": null,
                "cpu_usage": null,
                "hdd_usage": null,
                "wifi_name": null,
                "wifi_stronge": null,
                "wifi_type": null,
                "wifi_ip": null,
                "wifi_macid": null,
                "created_at": "2021-11-04T09:07:41.000000Z",
                "updated_at": "2021-11-04T09:07:41.000000Z"
            }
        ],
        "total": 53,
        "page": 1,
        "limit": 10
    },
    "timestamp": 1637025018
}
```

### 添加/修改机器
接口地址：/robot/machine  
返回格式:josn  
是否需要授权：是  
请求方式：post  
请内容：

| 参数 | 类型| 方式 | 是否必填 | 说明 |
|-|-|-|-|-|
| id | string | josn | 是 | 用户id，存在时为修改|
| name| string| josn | 是 | 机器名 |
| sn| string| josn | 是 | 机器序列号 |

请求样例：
```
{
    "name":"test1",
    "sn":"13500000088"
    
}
```
返回样例：
```
{
    "code": 0,
    "data": "",
    "msg": "操作成功",
    "timestamp": 1631245833
}
```


### 删除机器
接口地址：/robot/machine  
返回格式:josn   
是否需要授权：是  
请求方式：delete  
请求头：

| 参数 | 类型| 方式 | 是否必填 | 说明 |
|-|-|-|-|-|
|id| array| josn | 是 | 删除的机器id |

请求样例：
```
{
    "id":[3,4]
}
```
返回样例：
```
{
    "code": 0,
    "msg": "删除成功",
    "data": [],
    "timestamp": 1633935664
}
```


### 所有地图
接口地址：/robot/map 
返回格式:josn 
是否需要授权：是 
请求方式：get 
请求内容：

| 参数 | 数据类型| 请求方式 | 是否必填 | 说明 |
|-|-|-|-|-|
|page| int| request | 否 | 当前页，默认为1 |
|limit| int| request | 否 | 一页条数，默认10 |
|key| string| request | 否 | 搜索关键字 |
|status| boolen| request | 否 | 地图状态 |

返回data说明

| 字段 | 类型 | 说明 |
|-|-|-|
| data | array | 用户数据|
| total | int | 总条数|
| page | int | 当前页数|
| limit | int | 一页条数|

返回data说明

| 字段 | 类型 | 说明 |
|-|-|-|
| id | string | 地图id|
| name | string | 地图名|
| area | array | 机器序列号|
| image| string | 地图图片路径|
| user_id | int | 创建都id|
| user_name | string | 创建者|
| machine_id| int | 创建地图机器id|
| machine_name| string | 创建地图机器|
| image_size | int | 地图文件尺寸大|
| file_size| int | 地图文件大小|
| status| int | 地图状态|
| created_at| datetime | 地图创建时间|
| updated_at| datetime | 地图修改时间|
请求样例：
```
robot/map?page=1&limit=10&key=&status=0
```
返回样例：
```
{
    "code": 0,
    "msg": "",
    "data": {
        "data": [
            {
                "id": 2,
                "name": "楼房aaa",
                "area": null,
                "image": null,
                "user_id": 1,
                "user_name": "15113339677",
                "machine_id": 1,
                "machine_name": "3",
                "image_size": null,
                "file_size": null,
                "status": 0,
                "created_at": "2021-10-11T07:30:25.000000Z",
                "updated_at": "2021-10-11T07:30:25.000000Z"
            },
            {
                "id": 1,
                "name": "楼房00000000",
                "area": {
                    "dd": "5"
                },
                "image": "000",
                "user_id": 1,
                "user_name": "15113339677",
                "machine_id": 1,
                "machine_name": "3",
                "image_size": null,
                "file_size": "00",
                "status": 0,
                "created_at": null,
                "updated_at": "2021-10-11T07:31:59.000000Z"
            }
        ],
        "total": 2,
        "page": 1,
        "limit": 10
    },
    "timestamp": 1633937526
}
```

### 添加/修改地图
接口地址：/robot/map 
返回格式:josn 
是否需要授权：是 
请求方式：post添加/put修改 
请内容：

| 参数 | 类型| 方式 | 是否必填 | 说明 |
|-|-|-|-|-|
| id | int | josn | 是 | 地图id，存在时为修改|
| name| string| josn | 是 | 机器名 |
| machine_id| int| josn | 是 | 机器id |
| area| json| josn | 是 | 地图区域 |

请求样例：
```
{
    "id":1,
    "name":"楼房2",
    "machine_id":1,
    "area":{"dd":"5"}
}
```
返回样例：
```
{
    "code": 0,
    "data": "",
    "msg": "操作成功",
    "timestamp": 1631245833
}
```


### 删除地图
接口地址：/robot/map 
返回格式:josn 
是否需要授权：是 
请求方式：delete 
请内容：

| 参数 | 类型| 方式 | 是否必填 | 说明 |
|-|-|-|-|-|
|id| array| josn | 是 | 地图id |

请求样例：
```
{
    "id":[3,4]
}
```
返回样例：
```
{
    "code": 0,
    "msg": "删除成功",
    "data": [],
    "timestamp": 1633935664
}
```

### 所有任务

接口地址：/robot/job 
返回格式:josn 
是否需要授权：是 
请求方式：get 
请求内容：

| 参数 | 数据类型| 请求方式 | 是否必填 | 说明 |
|-|-|-|-|-|
|page| int| request | 否 | 当前页，默认为1 |
|limit| int| request | 否 | 一页条数，默认10 |
|key| string| request | 否 | 搜索关键字 |
|status| boolen| request | 否 | 任务状态 |
|machine_id| int| request | 否 | 设备 |
|start_at| datetime| request | 否 | 起始时间 任务开始时间大于此值|
|end_at| datetime| request | 否 | 结束时间 任务开始时间小于此值|
|type_id| int| request | 否 | 功能,消毒模式 |

返回data说明

| 字段 | 类型 | 说明 |
|-|-|-|
| data | array | 用户数据|
| total | int | 总条数|
| page | int | 当前页数|
| limit | int | 一页条数|

返回data说明

| 字段 | 类型 | 说明 |
|-|-|-|
| id | int | 任务id|
| name | string | 任务名称|
| user_id | int | 创建者id|
| user_name | string | 创建者名称|
| machine_id | string | 机器id|
| machine_name | string | 机器名|
| map_id | string | 地图id|
| map_name | string | 地图名称|
| map_area | array | 执行区域|
| rate_type | int | 执行频率|
| work | array | 执行任务|
| is_clean | int | 是否扫地|
| is_test | int | 是否巡检|
| start_at | datetime | 开始时间|
| end_at | datetime | 结束时间|
| status | string | 任务状态|
| deleted_at | datetime | 删除时间|
| created_at | datetime | 创建时间|
| updated_at | datetime | 更新时间|

请求样例：
```
robot/job?page=1&limit=10&key=&status=0
```
返回样例：
```
{
    "code": 0,
    "msg": "",
    "data": {
        "id": 1,
        "name": "二楼扫地",
        "user_id": 1,
        "user_name": "15113339677",
        "machine_id": 1,
        "machine_name": null,
        "map_id": 12,
        "map_name": null,
        "map_area": {
            "区域名1": 20,
            "区域名2": 20
        },
        "rate_type": 1,
        "work": [
            1,
            2
        ],
        "is_clean": 0,
        "is_test": 0,
        "start_at": "2021-09-17 00:00:00",
        "end_at": "2021-09-18 00:00:00",
        "deleted_at": null,
        "created_at": "2021-10-14T08:53:24.000000Z",
        "updated_at": "2021-10-14T08:53:24.000000Z"
    },
    "timestamp": 1634201609
}
```

### 添加/修改任务
接口地址：/robot/job  
返回格式:josn  
是否需要授权：是  
请求方式：post添加/put修改  
请求内容：

| 参数 | 类型| 方式 | 是否必填 | 说明 |
|-|-|-|-|-|
| id | string | josn | 是 | 用户id，存在时为修改|
| name| string| josn | 是 | 任务名 |
| map_id| int| josn | 是 | 所选用地图 |
| map_area| string| josn | 是 | 地图区域，待确认格式 |
| machine_id| int| josn | 是 | 所使用机器 |
| start_at| string| josn | 是 | 任务开始时间  |
| rate_type| string| josn | 是 | 执行频率，0,默契认执行一次 |
| work| array| josn | 是 | 执行任务,0喷雾 1.0版本，2.0已取消 |
| is_clean| boolen| josn | 否 | 是否扫地 |
| is_test| boolen| josn | 否 | 是否巡检 |
| type_id | array| josn | 是 | 任务类型2.0版本 |

请求样例：
```
{
    "name":"二楼扫地",
    "map_id":"12",
    "map_area":{
        "区域名1":20,
        "区域名2":20
    },
    "machine_id":"1",
    "start_at":"2021-09-17",
    "end_at":"2021-09-18",
    "rate_type":"1",
    "work":[1,2],
    "is_clean":0,
    "is_test":0,
    "type_id":1
}
```
返回样例：
```
{
    "code": 0,
    "data": "",
    "msg": "操作成功",
    "timestamp": 1631245833
}
```
### 更改任务状态
接口地址：/robot/job  
返回格式:josn  
是否需要授权：是  
请求方式：patch  
请求头：

| 参数 | 类型| 方式 | 是否必填 | 说明 |
|-|-|-|-|-|
| id | array | josn | 是 | 任务id|
| status| string| josn | 是 | 任务状态，1-5 |

请求样例：
```
{
    "id":[1,2],
    "status":1
}
```
返回样例：
```
{
    "code": 0,
    "data": "",
    "msg": "操作成功",
    "timestamp": 1631245833
}
```


### 删除任务
接口地址：/robot/job 
返回格式:josn 
是否需要授权：是 
请求方式：delete 
请求头：

| 参数 | 类型| 方式 | 是否必填 | 说明 |
|-|-|-|-|-|
|id| array| josn | 是 | 任务id |

请求样例：
```
{
    "id":[3,4]
}
```
返回样例：
```
{
    "code": 0,
    "msg": "删除成功",
    "data": [],
    "timestamp": 1633935664
}
```
## 系统配置

### 系统权限
接口地址：/system/access  
返回格式:josn  
是否需要授权：是 
请求方式：get  
返回格式:

| 字段 | 类型 | 说明 |
|-|-|-|
| id | string | 权限id|
| parent_id | int | 权限所依赖上一级权限|
| name | string | 权限名|
| code | string | 权限标识，为了后续扩展肜|
| path | string | 权限路径|
| desc | string | 权限描述|
| created_at | string | 创建时间|
| updated_at | string | 更新时间|

请求样例：
```
/system/access
```
返回样例：
```
{
    "code": 0,
    "msg": "",
    "data": [
        {
            "id": 1,
            "parent_id": 0,
            "name": "用户管理",
            "code": "safe",
            "path": "/member/user",
            "method": null,
            "desc": "",
            "created_at": null,
            "updated_at": null
        },
        {
            "id": 2,
            "parent_id": 1,
            "name": "添加用户",
            "code": "user",
            "path": "/member/user",
            "method": null,
            "desc": "",
            "created_at": null,
            "updated_at": null
        }
    ],
    "timestamp": 1633944670
}
```
### 添加/修改权限
接口地址：/system/access 
返回格式:josn 
是否需要授权：是 
请求方式：post 
请内容:
| 字段 | 类型 | 必填 | 说明 |
|-|-|-|
| id | string | 否|如果带id是修改|
| parent_id | int | 否|权限所依赖上一级权限,默认为0，根权限|
| name | string | 是 |权限名|
| code | string | 否 |权限标识，为了后续扩展|
| path | string | 是 | 权限路径|
| desc | string | 否 | 权限描述|

请求样例：
```
{
    "id": 1,
    "parent_id": 0,
    "name": "用户管理",
    "code": "safe",
    "path": "/member/user",
    "method": null,
    "desc": "",
},
```
返回样例：
```
{
    "code": 0,
    "data": "",
    "msg": "操作成功",
    "timestamp": 1631245833
}
```
### 删除权限
接口地址：/system/access/{id}  
返回格式:josn  
是否需要授权：是  
请求方式：delete  
请求样例：
```
delete：/system/access/1
```
返回样例：
```
{
    "code": 0,
    "msg": "删除成功",
    "data": [],
    "timestamp": 1633935664
}
```
### 系统路由
接口地址：/system/uris  
返回格式:josn  
是否需要授权：是  
请求方式：get  
返回格式:

| 字段 | 类型 | 说明 |
|-|-|-|
| host | string | 域名|
| method | int | 方法|
| path | string | 路径|

请求样例：
```
/system/uris
```
返回样例：
```
{
    "code": 0,
    "msg": "",
    "data": [
        {
            "host": null,
            "method": "GET|HEAD",
            "path": "api/member/user"
        },
        {
            "host": null,
            "method": "GET|HEAD",
            "path": "api/member/user/{id}"
        },
    ],
    "timestamp": 1633945328
}
```

## 权限管理

### 所有成员
接口地址：/member/user  
返回格式:josn  
是否需要授权：是  
请求方式：get  
请求内容：

| 参数 | 数据类型| 请求方式 | 是否必填 | 说明 |
|-|-|-|-|-|
|page| string| request | 否 | 当前页 |
|limit| string| request | 否 | 一页条数 |
|key| string| request | 否 | 搜索关键字 |
|status| boolen| request | 否 | 用户状态 |

返回data说明

| 字段 | 类型 | 说明 |
|-|-|-|
| data | array | 用户数据|
| total | int | 总条数|
| page | int | 当前页数|
| limit | int | 一页条数|

返回data说明

| 字段 | 类型 | 说明 |
|-|-|-|
| id | string | 用户id|
| nickname | string | 用户昵称|
| phone | string | 用户手机|
| avatar | string | 用户头像|
| roles | array | 用户所在角色|
| last_at | datetime | 上次登录时间|
| last_ip | string | 上次登录ip|
| login_times | int | 登录次数|
| passed | boolen | 审核状态|
| desc | string | 用户描述|
| is_system | boolen | 是否系统用户|
| created_at | datetime | 创建时间|
| updated_at | datetime | 更新时间|

roles 请参考 添加/修改角色接口

| 字段 | 类型 | 说明 |
|-|-|-|
| id | int | 角色id|
| name | string | 角色名|
| desc | string | 角色描述|
| access | array | 权限|
| created_at | datetime | 创建时间|
| updated_at | datetime | 更新时间|

请求样例：
```
member/user?page=1&limit=10&key=&status=0
```
返回样例：
```
{
    "code": 0,
    "msg": "",
    "data": {
        "data": [
            {
                "id": 2,
                "name": null,
                "nickname": "管理员",
                "phone": "15113339677",
                "avatar": "/img/nopic.jpg",
                "roles": [
                    {
                        "id": 1,
                        "name": "000",
                        "desc": "000",
                        "status": 1,
                        "is_system": 0,
						"level": 0,
                        "created_at": null,
                        "updated_at": null,
                        "pivot": {
                            "user_id": 4,
                            "role_id": 1
                        }
                    },
                    {
                        "id": 2,
                        "name": "111",
                        "desc": "",
                        "status": 1,
                        "is_system": 0,
						"level": 0,
                        "created_at": null,
                        "updated_at": null,
                        "pivot": {
                            "user_id": 4,
                            "role_id": 2
                        }
                    }
                ],
                "last_at": "2019-05-20 00:00:00",
                "last_ip": "127.0.0.1",
                "login_times": 0,
                "passed": 1,
                "desc": "系统用户",
                "is_system": 1,
                "created_at": null,
                "updated_at": null
            },
            {
                "id": 1,
                "name": null,
                "nickname": "管理员",
                "phone": "15113339677",
                "avatar": "/img/nopic.jpg",
                "roles": [],
                "last_at": "2019-05-20 00:00:00",
                "last_ip": "127.0.0.1",
                "login_times": 0,
                "passed": 1,
                "desc": "系统用户",
                "is_system": 1,
                "created_at": null,
                "updated_at": null
            }
        ],
        "total": 2,
        "page": 1,
        "limit": "10"
    },
    "timestamp": 1633931214
}
```

### 添加/修改用户
接口地址：/member/user  
返回格式:josn  
是否需要授权：是 
请求方式：post添加/put修改  
请内容：

| 参数 | 类型| 方式 | 是否必填 | 说明 |
|-|-|-|-|-|
| id | int | josn | 是 | 用户id，存在时为修改|
| phone| string| josn | 是 | 用户手机 |
| password| string| josn | 是 | 登录密码 |
| code| string| josn | 是 | 邀请码 |
| nickname| string| josn | 否 | 用户昵称 |
| avatar| string| josn | 否 | 用户头像 |
| roles| array| josn | 否 | 用户所在角色 |
| passed| string| josn | 否 | 是否审核，0待审核，1审核通过。默认审核通过 |
| desc| string| josn | 否 | 用户描述 |

请求样例：
```
{
    "phone":"13500000088",
    "password":"123456",
    "code":"000",
    "roles":[1,2],
    "passed":1,
    "nickname":"测试用户",
    "avatar":"/img/aa.jpg",
    "desc":"这只是一个测试用户"
}
```
返回样例：
```
{
    "code": 0,
    "data": "",
    "msg": "操作成功",
    "timestamp": 1631245833
}
```


### 删除用户
接口地址：/member/user 
返回格式:josn 
是否需要授权：是 
请求方式：delete 
请求头：

| 参数 | 类型| 方式 | 是否必填 | 说明 |
|-|-|-|-|-|
|id| array| josn | 是 | 删除的用户 |

请求样例：
```
{
    "id":[3,4]
}
```
返回样例：
```
{
    "code": 0,
    "msg": "删除成功",
    "data": [],
    "timestamp": 1633935664
}
```

### 所有角色
接口地址：/member/role  
返回格式:josn  
是否需要授权：是 
请求方式：get 
请求内容：

| 参数 | 数据类型| 请求方式 | 是否必填 | 说明 |
|-|-|-|-|-|
|page| string| request | 否 | 当前页，默认1 |
|limit| string| request | 否 | 一页条数，默认10 |
|key| string| request | 否 | 搜索关键字 |

返回data说明

| 字段 | 类型 | 说明 |
|-|-|-|
| data | array | 用户数据|
| total | int | 总条数|
| page | int | 当前页数|
| limit | int | 一页条数|

返回data说明

| 字段 | 类型 | 说明 |
|-|-|-|
| id | int | 角色id|
| name | string | 角色名|
| desc | string | 角色描述|
| access | array | 权限|
| created_at | datetime | 创建时间|
| updated_at | datetime | 更新时间|

请求样例：
```
member/role?page=1&limit=10&key=
```
返回样例：
```
{
    "code": 0,
    "msg": "",
    "data": {
        "data": [
            {
                "id": 2,
                "name": "111",
                "desc": "",
                "is_system": 0,
                "access": [
                    {
                        "id": 1,
                        "parent_id": 0,
                        "name": "用户管理",
                        "code": "safe",
                        "path": "/member/user",
                        "method": null,
                        "desc": "",
                        "created_at": null,
                        "updated_at": null,
                        "pivot": {
                            "role_id": 1,
                            "access_id": 1
                        }
                    },
                    {
                        "id": 2,
                        "parent_id": 1,
                        "name": "添加用户",
                        "code": "user",
                        "path": "/member/user",
                        "method": null,
                        "desc": "",
                        "created_at": null,
                        "updated_at": null,
                        "pivot": {
                            "role_id": 1,
                            "access_id": 2
                        }
                    }
                ],
                "created_at": null,
                "updated_at": null
            },
            {
                "id": 1,
                "name": "000",
                "desc": "000",
                "is_system": 0,
                "access": [],
                "created_at": null,
                "updated_at": null
            }
        ],
        "total": 2,
        "page": 1,
        "limit": 10
    },
    "timestamp": 1633935760
}
```

### 添加/修改角色
接口地址：/member/role 
返回格式:josn 
是否需要授权：是 
请求方式：post（添加）put(修改)  
请求头：

| 参数 | 类型| 方式 | 是否必填 | 说明 |
|-|-|-|-|-|
| id | int | josn | 是 | 角色id，修改时必填，添加不能填|
| name| string| josn | 是 | 角色名 |
| access| array| josn | 否 | 角色权限 |
| level| int| josn | 否 | 角色等级 0为普通角色，1管理角色 |
| desc| string| josn | 否 | 用户描述 |

请求样例：
```
{
    "name":"1293",
    "access":[3,4]
}
```
返回样例：
```
{
    "code": 0,
    "data": "",
    "msg": "操作成功",
    "timestamp": 1631245833
}
```


### 删除角色  
接口地址：/member/role  
返回格式:josn  
是否需要授权：是  
请求方式：delete  

请内容：

| 参数 | 类型| 方式 | 是否必填 | 说明 |
|-|-|-|-|-|
|id| array| josn | 是 | 删除的角色id |

请求样例：
```
{
    "id":[3,4]
}
```
返回样例：
```
{
    "code": 0,
    "msg": "删除成功",
    "data": [],
    "timestamp": 1633935664
}
```
## 问题反馈

### 问题反馈
接口地址：/me/feedback  
返回格式:josn  
是否需要授权：是  
请求方式：get  
请求内容：

| 参数 | 数据类型| 请求方式 | 是否必填 | 说明 |
|-|-|-|-|-|
|page| int| request | 否 | 当前页，默认为1 |
|limit| int| request | 否 | 一页条数，默认为10 |

返回data说明

| 字段 | 类型 | 说明 |
|-|-|-|
| data | array | 反馈数据|
| total | int | 总条数|
| page | int | 当前页数|
| limit | int | 一页条数|

返回data说明

| 字段 | 类型 | 说明 |
|-|-|-|
| id | int | 反馈id|
| user_id | int | 反馈用户id|
| user_name | string | 反馈用户名|
| phone | string | 联系电话|
| desc | string | 反馈内容|
| pics | array | 反馈图片|
| status | int | 预留字段|
| created_at | datetime | 创建时间|
| updated_at | datetime | 更新时间|

请求样例：
```
me/feedback?page=1&limit=10
```
返回样例：
```
{
    "code": 0,
    "msg": "",
    "data": {
        "data": [
            {
                "id": 56,
                "user_id": 1,
                "user_name": "15113339677",
                "phone": "13800138000",
                "desc": "怎么用这个功能",
                "pics": [
                    "/upload/freeback/hoCyXaUrl3zX3NhyaBENNJiOOJE41NhY3FlRmwv0.jpg",
                    "/upload/freeback/hoCyXaUrl3zX3NhyaBENNJiOOJE41NhY3FlRmwv2.jpg"
                ],
                "status": null,
                "created_at": "2021-11-15T06:18:15.000000Z",
                "updated_at": "2021-11-15T06:18:15.000000Z",
                "company_id": null
            },
            {
                "id": 55,
                "user_id": 1,
                "user_name": "15113339677",
                "phone": "13800138000",
                "desc": "怎么用这个功能",
                "pics": [
                    "/upload/freeback/hoCyXaUrl3zX3NhyaBENNJiOOJE41NhY3FlRmwv0.jpg",
                    "/upload/freeback/hoCyXaUrl3zX3NhyaBENNJiOOJE41NhY3FlRmwv2.jpg"
                ],
                "status": null,
                "created_at": "2021-11-15T01:19:20.000000Z",
                "updated_at": "2021-11-15T01:19:20.000000Z",
                "company_id": null
            }
        ],
        "total": 54,
        "page": 1,
        "limit": 10
    },
    "timestamp": 1636958581
}
```

### 添加反馈
接口地址：/me/feedback  
返回格式:josn  
是否需要授权：是  
请求方式：post  
请内容： 

| 参数 | 类型| 方式 | 是否必填 | 说明 |
|-|-|-|-|-|
|phone| string| josn | 是 | 联系方式 |
|desc| string| josn | 是 | 问题功述 |
|pics| array| josn | 否 | 上传的图片,可调用上传反馈图片等到的图片数据 |

请求样例：
```
{
    "phone":"13800138000",
    "desc":"怎么用这个功能",
    "pics":["/upload/freeback/hoCyXaUrl3zX3NhyaBENNJiOOJE41NhY3FlRmwv0.jpg","/upload/freeback/hoCyXaUrl3zX3NhyaBENNJiOOJE41NhY3FlRmwv2.jpg"]
}
```
返回样例：
```
{
    "code": 0,
    "data": "",
    "msg": "反馈成功",
    "timestamp": 1631245833
}
```
### 删除反馈 
接口地址：/me/feedback 
返回格式:josn 
是否需要授权：是 
请求方式：delete 

请内容：

| 参数 | 类型| 方式 | 是否必填 | 说明 |
|-|-|-|-|-|
|id| array| josn | 是 | 删除的角色id |

请求样例：
```
{
    "id":[3,4,5]
}
```
返回样例：
```
{
    "code": 0,
    "msg": "删除成功",
    "data": [],
    "timestamp": 1633935664
}
```

### 上传反馈图片
接口地址：/me/feedback/upload
返回格式:josn  
是否需要授权：是  
请求方式：post  

请内容：

| 参数 | 类型| 方式 | 是否必填 | 说明 |
|-|-|-|-|-|
|file| media| josn | 是 | 图片 |

返回样例：

```
/upload/freeback/hoCyXaUrl3zX3NhyaBENNJiOOJE41NhY3FlRmwv0.jpg
```

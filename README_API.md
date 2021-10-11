# 扫地机器人接口文档
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
|100 | 失败 |
|501  | 服务器繁忙 |
|500| 服务务器错误 |
|401| 请求资源不存在 |
|403| 请求下级依赖资源不存在 |
|409| 已经存在该资源了 |
|422| 字段验证失败 |
|401| 没有授权 |
|405| 权限不足，没有权限操作此资源 |
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
是否需要授权：否
请求方式：post
请求头：

| 参数 | 类型| 方式 | 是否必填 | 说明 |
|-|-|-|-|-|
|phone| string| josn | 是 | 手机号 |
|type| string| josn | 是 | 要获取验证码类型 |

返回格式:
| 字段 | 类型 | 说明 |
|-|-|-|
| token_type | string | token类型|
| expires_in | int | token到期时间|
| access_token | string | token值|
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
用用户名帐号密码登录拿到token值，
### 用户注册
接口地址：/auth/find/password
返回格式:josn
是否需要授权：否
请求方式：post
请求头：

| 参数 | 类型| 方式 | 是否必填 | 说明 |
|-|-|-|-|-|
|phone| string| josn | 是 | 手机号，要更改帐号的手机号 |
|phone_code| string| josn | 是 | 手机验证码 |
|invite_code| string| josn | 是 | 手机验证码 |
|password| string| josn | 是 | 新密码 |
|password_confirmation| string| josn | 是 | 确认新密码 |

返回data说明
| 字段 | 类型 | 说明 |
|-|-|-|
| token_type | string | token类型|
| expires_in | int | token到期时间|
| access_token | string | token值|
| refresh_token | string | 刷新token到期时间的值|
请求样例：
```
{
    "phone":"15113339677",
    "code":"1848306182",
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
### 用户帐号名密码登录
接口地址：/auth/login/token
返回格式:josn
是否需要授权：否
请求方式：post
请求头：

| 参数 | 类型| 方式 | 是否必填 | 说明 |
|-|-|-|-|-|
|username| string| josn | 是 | 登录帐号 |
|password| string| josn | 是 | 登录密码 |

返回格式:
| 字段 | 类型 | 说明 |
|-|-|-|
| token_type | string | token类型|
| expires_in | int | token到期时间|
| access_token | string | token值|
请求样例：
```
{
    "username": "admin",
    "password": "admin888"
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
请求头：

| 参数 | 类型| 方式 | 是否必填 | 说明 |
|-|-|-|-|-|
|phone| string| josn | 是 | 手机号 |
|code| string| josn | 是 | 手机验证码 |

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
    "password": "admin888"
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
请求头：

| 参数 | 类型| 方式 | 是否必填 | 说明 |
|-|-|-|-|-|
|code| string| josn | 是 | 小程序code值 |
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
    "username": "admin",
    "password": "admin888"
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
请求头：

| 参数 | 类型| 方式 | 是否必填 | 说明 |
|-|-|-|-|-|
|phone| string| josn | 是 | 手机号，要更改帐号的手机号 |
|code| string| josn | 是 | 手机验证码 |
|password| string| josn | 是 | 新密码 |
|password_confirmation| string| josn | 是 | 确认新密码 |

返回data说明
| 字段 | 类型 | 说明 |
|-|-|-|
| token_type | string | token类型|
| expires_in | int | token到期时间|
| access_token | string | token值|
| refresh_token | string | 刷新token到期时间的值|
请求样例：
```
{
    "phone":"15113339677",
    "code":"1848306182",
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
## 个人信息

### 获取个人信息
接口地址：/profile/user
返回格式:josn
是否需要授权：是
请求方式：get
返回data说明
| 字段 | 类型 | 说明 |
|-|-|-|
| id | string | 用户id，存在时为修改|
| nickname| string| 用户昵称 |
| name| string| 用户帐号 |
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
        "login_times": 0,
        "passed": 1,
        "is_system": 1,
        "desc": "系统用户",
        "created_at": null,
        "updated_at": null
    },
    "timestamp": 1633941348
}
```
### 修改个人信息
接口地址：/profile/user
返回格式:josn
是否需要授权：是
请求方式：post

请求头：
| 参数 | 类型| 方式 | 是否必填 | 说明 |
|-|-|-|-|-|
| nickname| string| josn | 否 | 用户帐号 |
| avatar| string| josn | 否 | 用户手机 |
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

请求头：
| 参数 | 类型| 方式 | 是否必填 | 说明 |
|-|-|-|-|-|
| file| blob| josn | 是 | 文件 |
### 修改手机
接口地址：/profile/phone
返回格式:josn
是否需要授权：是
请求方式：post

请求头：
| 参数 | 类型| 方式 | 是否必填 | 说明 |
|-|-|-|-|-|
| oldcode| string| josn | 否 | 旧手机验证码 |
| phone| string| josn | 否 | 新手机号 |
| code| string| josn | 否 | 新手机验证码 |
请求样例：
```
{
    "oldcode":"123456",
    "phone":"13800011380",
    "code":"234567"
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
接口地址：/profile/phone
返回格式:josn
是否需要授权：是
请求方式：post

请求头：
| 参数 | 类型| 方式 | 是否必填 | 说明 |
|-|-|-|-|-|
| code| string| josn | 是 | 手机验证码 |
| password| string| josn | 是 | 新密码 |
请求样例：
```
{
    "code":"123456",
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

## 权限管理

### 所有成员
接口地址：/member/user
返回格式:josn
是否需要授权：是
请求方式：get
请求 request：

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
| name | string | 用户帐号|
| nickname | string | 用户昵称|
| phone | string | 用户手机|
| avatar | string | 用户头像|
| roles | josn | 用户所在角色|
| last_at | datetime | 上次登录时间|
| last_ip | string | 上次登录ip|
| login_times | int | 登录次数|
| passed | boolen | 审核状态|
| desc | string | 用户描述|
| is_system | boolen | 是否系统用户|
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
是否需要授权：否
请求方式：post
请求头：

| 参数 | 类型| 方式 | 是否必填 | 说明 |
|-|-|-|-|-|
| id | string | josn | 是 | 用户id，存在时为修改|
| name| string| josn | 是 | 用户帐号 |
| phone| string| josn | 是 | 用户手机 |
| password| string| josn | 是 | 登录密码 |
| code| string| josn | 是 | 邀请码 |
| nickname| string| josn | 否 | 用户昵称 |
| avatar| string| josn | 否 | 用户头像 |
| roles| string| josn | 否 | 用户所在角色 |
| passed| string| josn | 否 | 是否审核，默认审核通过 |
| desc| string| josn | 否 | 用户描述 |

请求样例：
```
{
    "name":"test1",
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
是否需要授权：否
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
请求 request：

| 参数 | 数据类型| 请求方式 | 是否必填 | 说明 |
|-|-|-|-|-|
|page| string| request | 否 | 当前页 |
|limit| string| request | 否 | 一页条数 |
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
| id | string | 角色id|
| name | string | 角色名|
| desc | string | 角色描述|
| access | array | 权限|
| is_system | boolen | 是否系统用户|
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
是否需要授权：否
请求方式：post
请求头：

| 参数 | 类型| 方式 | 是否必填 | 说明 |
|-|-|-|-|-|
| id | int | josn | 是 | 角色id，存在时为修改|
| name| string| josn | 是 | 角色名 |
| access| array| josn | 否 | 角色权限 |
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
请求头：

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

## 机器人管理

### 所有机器
接口地址：/robot/machine
返回格式:josn
是否需要授权：是
请求方式：get
请求 request：

| 参数 | 数据类型| 请求方式 | 是否必填 | 说明 |
|-|-|-|-|-|
|page| string| request | 否 | 当前页 |
|limit| string| request | 否 | 一页条数 |
|key| string| request | 否 | 搜索关键字 |
|status| boolen| request | 否 | 机器状态 |

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
| name | string | 机器名|
| sn | string | 机器序列号|
| status | string | 机器状态|
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
                "id": 2,
                "name": "机器一",
                "sn": "000001",
                "status": 1
                "created_at": null,
                "updated_at": null
            },
            {
                "id": 1,
                "name": "机器二",
                "sn": "000000",
                "status": 1
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

### 添加/修改机器
接口地址：/robot/machine
返回格式:josn
是否需要授权：否
请求方式：post
请求头：

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
是否需要授权：否
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
请求 request：

| 参数 | 数据类型| 请求方式 | 是否必填 | 说明 |
|-|-|-|-|-|
|page| string| request | 否 | 当前页 |
|limit| string| request | 否 | 一页条数 |
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
| id | string | 用户id|
| name | string | 机器名|
| sn | string | 机器序列号|
| status | string | 机器状态|
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
是否需要授权：否
请求方式：post
请求头：

| 参数 | 类型| 方式 | 是否必填 | 说明 |
|-|-|-|-|-|
| id | string | josn | 是 | 用户id，存在时为修改|
| name| string| josn | 是 | 机器名 |
| sn| string| josn | 是 | 机器序列号 |
| area| string| josn | 是 | 地图区域 |
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
是否需要授权：否
请求方式：delete
请求头：

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
请求 request：

| 参数 | 数据类型| 请求方式 | 是否必填 | 说明 |
|-|-|-|-|-|
|page| string| request | 否 | 当前页 |
|limit| string| request | 否 | 一页条数 |
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
| id | string | 用户id|
| name | string | 机器名|
| sn | string | 机器序列号|
| status | string | 机器状态|
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

### 添加/修改任务
接口地址：/robot/job
返回格式:josn
是否需要授权：否
请求方式：post
请求头：

| 参数 | 类型| 方式 | 是否必填 | 说明 |
|-|-|-|-|-|
| id | string | josn | 是 | 用户id，存在时为修改|
| name| string| josn | 是 | 任务名 |
| map_id| int| josn | 是 | 所选用地图 |
| map_area| string| josn | 是 | 地图区域 |
| machine_id| string| josn | 是 | 所使用机器 |
| start_at| string| josn | 是 | 任务开始时间  |
| rate_type| string| josn | 是 | 执行频率，0,默契认执行一次 |
| work| array| josn | 是 | 消毒模式,0喷雾 |
| is_clean| boolen| josn | 否 | 是否扫地 |
| is_test| boolen| josn | 否 | 是否巡检 |
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
    "is_test":0
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
是否需要授权：否
请求方式：patch
请求头：

| 参数 | 类型| 方式 | 是否必填 | 说明 |
|-|-|-|-|-|
| id | array | josn | 是 | 任务id|
| status| string| josn | 是 | 任务名 |
请求样例：
```
{
    "work":[1,2],
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
是否需要授权：否
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
是否需要授权：否
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
是否需要授权：否
请求方式：post
请求头:
| 字段 | 类型 | 必填 | 说明 |
|-|-|-|
| id | string | 否|如果带id是修改|
| parent_id | int | 否|权限所依赖上一级权限|
| name | string | 是 |权限名|
| code | string | 否 |权限标识，为了后续扩展肜|
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
：/system/access/1
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
是否需要授权：否
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

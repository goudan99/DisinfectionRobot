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

### 前端报错提交
接口地址：/public/mobile/code
返回格式:josn
是否需要授权：否
请求方式：post
请求头：
| 参数 | 类型| 方式 | 是否必填 | 说明 |
|-|-|-|-|-|
|code| string| josn | 是 | 响应码 |
|msg| string| josn | 是 | 响应内容 |
|type| string| josn | 是 | 类型 |
|url| string| josn | 是 | 链接 |

请求样例：
```
{
    "phone":"15113339677",
    "code":"404",
    "msg":"内容找不到",
    "method":"post",
    "url":"http://wwww.heekit.com/api/myabcde"
}
```
返回样例：
```
 "提交成功"
```

### 验证码
接口地址：/public/mobile/code
返回格式:josn
是否需要授权：否
请求方式：post
请求头：
| 参数 | 类型| 方式 | 是否必填 | 说明 |
|-|-|-|-|-|
|phone| string| josn | 是 | 手机号 |
|type| string| josn | 是 | 类型0用户注册，1找密码，2更改密码，3更改手机确认验证码，4更改确认新手机 |

请求样例：
```
{
    "phone":"15113339677",
    "code":"0"
}
```
返回样例：
```
"验证码已发送"
```
### 公开的配置文件
接口地址：/public/config
返回格式:josn
是否需要授权：否
请求方式：get
开发过程中协调公开部分配置

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
## 权限管理

### 所有成员
接口地址：/member/user
返回格式:josn
是否需要授权：是
请求方式：get
请求body头：

| 参数 | 类型| 方式 | 是否必填 | 说明 |
|-|-|-|-|-|
|page| string| josn | 是 | 当前页 |
|limit| string| josn | 是 | 一页有几条 |
|key| string| josn | 是 | 搜索关键字 |
|status| string| josn | 是 | 状态-1为所有，0未审核，1审核 |

返回data说明
| 字段 | 类型 | 说明 |
|-|-|-|
| data | array | 数组|
| total | int | 总条数|
| page | int | 当前页|
| limit | int | 一页有几条|
请求样例：
```
member/user?page=1&limit=10&key=&status=0
```
返回样例：
```
"data": [
	{
		"id": 2,
		"name": null,
		"nickname": "",
		"phone": "18318174637",
		"avatar": "",
		"roles": [],
		"last_at": null,
		"last_ip": "",
		"login_times": 0,
		"passed": 1,
		"desc": "",
		"is_system": 0,
		"created_at": "2021-09-23T06:39:12.000000Z",
		"updated_at": "2021-09-23T06:39:12.000000Z"
	},
	{
		"id": 1,
		"name": null,
		"nickname": "管理员",
		"phone": "15113339677",
		"avatar": "http://localhost:8081/upload/avatar/7i5y1R3jiVtNR3LpbJbSBN64v24exabhGcBo7KnO.jpg",
		"roles": [],
		"last_at": "2019-05-20 00:00:00",
		"last_ip": "127.0.0.1",
		"login_times": 0,
		"passed": 1,
		"desc": "系统用户",
		"is_system": 1,
		"created_at": null,
		"updated_at": "2021-09-23T07:21:17.000000Z"
	}
],
"total": 2,
"page": 1,
"limit": "10"
```
### 所有成员
接口地址：/member/user
返回格式:josn
是否需要授权：是
请求方式：get
请求body头：

| 参数 | 类型| 方式 | 是否必填 | 说明 |
|-|-|-|-|-|
|page| string| josn | 是 | 当前页 |
|limit| string| josn | 是 | 一页有几条 |
|key| string| josn | 是 | 搜索关键字 |
|status| string| josn | 是 | 状态-1为所有，0未审核，1审核 |

返回data说明
| 字段 | 类型 | 说明 |
|-|-|-|
| data | array | 数组|
| total | int | 总条数|
| page | int | 当前页|
| limit | int | 一页有几条|
请求样例：
```
member/user?page=1&limit=10&key=&status=0
```
返回样例：
```
"data": [
	{
		"id": 2,
		"name": null,
		"nickname": "",
		"phone": "18318174637",
		"avatar": "",
		"roles": [],
		"last_at": null,
		"last_ip": "",
		"login_times": 0,
		"passed": 1,
		"desc": "",
		"is_system": 0,
		"created_at": "2021-09-23T06:39:12.000000Z",
		"updated_at": "2021-09-23T06:39:12.000000Z"
	},
	{
		"id": 1,
		"name": null,
		"nickname": "管理员",
		"phone": "15113339677",
		"avatar": "http://localhost:8081/upload/avatar/7i5y1R3jiVtNR3LpbJbSBN64v24exabhGcBo7KnO.jpg",
		"roles": [],
		"last_at": "2019-05-20 00:00:00",
		"last_ip": "127.0.0.1",
		"login_times": 0,
		"passed": 1,
		"desc": "系统用户",
		"is_system": 1,
		"created_at": null,
		"updated_at": "2021-09-23T07:21:17.000000Z"
	}
],
"total": 2,
"page": 1,
"limit": "10"
```

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
## 公共接口

## 授权
授权流程
用用户名帐号密码登录拿到token值，
### 用户注册
接口地址：/auth/find/password
返回格式:josn
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


      const field = this.$refs['phoneForm'].fields.filter(field => field.prop === 'phone')[0]
	  field.validateMessage = 'aaaaaaaaaaaaa'
	  field.validateState = 'error'

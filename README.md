# 扫地机器人接口文档
## api接口说明
 本接口文档api文档返回格式请求成功统一为
### 成功格式为
|名称|类型|说明|
|-|-|-|
|code| int | 状态码，0为成功|
|data| json| 返回内容 |
|msg | string | 返回说明 |
样例
```
{
    "code": 0,
    "msg": "请求成功",
    "data": [],
    "timestamp": 1631254154
}
```
### 失败格式为
|名称|类型|说明|
|-|-|-|
|code| int | 状态码，0为成功|
|data| json| 返回内容,为空 |
|msg | string | 返回说明 |
|error | josn | 返回内容 |
样例
```
{
    "code": 422,
    "msg": "数据验证不正确",
    "error": {
        "phone": [
            "国内的手机号码长度为11位"
        ]
    },
    "data": ""
}
```
### 状态说明：
|code|说明|
|-|-|-|
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

## 授权
授权流程
用用户名帐号密码登录拿到token值，

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
|名称|类型|说明|
|-|-|-|
|code| int | 状态码，0为成功|
|data| json| 返回内容 |
|msg | string | 返回说明 |
data说明
| 字段 | 类型 | 说明 |
|-|-|-|
| token_type | string | token类型|
| expires_in | intint | token到期时间|
| access_token | string | token值|
| refresh_token | string | 刷新token到期时间的值|
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
        "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiI5NDNjNzk2Mi1kYmYyLTQ3ZTQtYTA3OC1mNDcwMTY3NGRiNDYiLCJqdGkiOiIwZDU4ODE5MjA0ZjEzOWViOWQxNmJhNTUyZThiNGIyNzU1MjllOGNhZGE1NDc2YjI0YTI0ZmQxM2FjMDEwZDYxNzdiNDRjNTMyOGM4YzU2NSIsImlhdCI6MTYzMTI0NTgzMywibmJmIjoxNjMxMjQ1ODMzLCJleHAiOjE2NjI3ODE4MzMsInN1YiI6IjEiLCJzY29wZXMiOltdfQ.LYE80c7IQe9qqLc5Kb0qPdoCouHDC13zWgqBNRjsD133UyB_hSJLPftzb2RP4HEzwcvdFs1WmurWIk5iWSxFkwDqdZSNeIPxXp6qMubN1zVwD-X-B2-dh0Hu7tS9LcAraOhZDz0_Wqf8YoOn4NyMp_ds2gvaADP9Xkpxexeg3eoV78lJb4Sx89L00aEiAxn2HattueA_fatVKxztueU_iH8u-25sB-vJFKdmoXIV-VF9EH4inxDh6hPvFBPT_iH6YFzBFHBSln7bu7JBudXamFT4fg0d5dubDVs78ZX4uSD0CPEyda7CY39UDFkICT8ltKCcF_zHsCc0FcSjU2G2KomB9eHo7Ga3L99M4I0KqrXnFKAHq44G0vOP1k4PYlxsISqOPeqILYck30iszttRbxpBSu4YIf0-i2nO07vsjrVW-LXKXQPqeUQTebgnTgPi0nZz7Svh7BWrBhFP3iaERQKUbAnLOSuy-zLPf3j10L-Ap9PGBJMny6w6T-7Okld7WTYjpv5R3TT6i7PnyatBQosLbxkSXuiOpilsMNOaWa0Yv73c31TLHwX1u70rPXPq5p9VRHnZJPzxveWdBP5atBNELpiTXiZwup8eThj64O80QbN86SAuCJF9Sl6Yhim6BMQIwVDUnaWxKFhgTuChgK5KqkoYPymnQZj5heGl1mM",
        "refresh_token": "def50200c3bb9358a8dcf05b0abef2860c1457d304bbac4339b08dfed3c17873224c9d40882b6f476d05634c63a5ae73ad11f3327beb414fd258870fb2af55f91a6c1cdddc6f37bffd68bc91bce4fbcb04817ea9a361799fff7d27ab2764ceb8b72690187f4227f85cc312ab4efedfa8281516682e8bf71bae0e56e43790bd67b5f133d6433c8c2579e2573d2304b88edf6287825781d5b9ad111eaf02cba5bd6786e5401fbffc638e2f6b37180741586a13301ad5a93a978e03bab400d174f5188db7031c88b8cef3a21afd264130d21f6fcca71a154854a864ce4a49a5d651b1b8696ed060a3538d44ac265290b97f12e3d61b693e25436e99731b55e0beba187c61dfdd08c7b3b2ac242c478fffae4a2ede2f99e3e721cfa42f28b9a3bc4bf1ccd2ddc75e13d7aac834f6b94c71dc71b63fbaf71e9ad5a83c52efb3c8be12a48a0a6c4dcb8a5540d3f9653c1721b58df2f6af97332f68a8216fd17444c44afb7fc596cf8b01aa72eb51b4dcb768df1e757aa762b503d7b90cbfe7f46db610c0a20451"
    },
    "error": "",
    "msg": "success",
    "timestamp": 1631245833
}
```

### 找密码
接口地址：/auth/login/password
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
| expires_in | intint | token到期时间|
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
    "data": {
        "token_type": "Bearer",
        "expires_in": 31536000,
        "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiI5NDNjNzk2Mi1kYmYyLTQ3ZTQtYTA3OC1mNDcwMTY3NGRiNDYiLCJqdGkiOiIwZDU4ODE5MjA0ZjEzOWViOWQxNmJhNTUyZThiNGIyNzU1MjllOGNhZGE1NDc2YjI0YTI0ZmQxM2FjMDEwZDYxNzdiNDRjNTMyOGM4YzU2NSIsImlhdCI6MTYzMTI0NTgzMywibmJmIjoxNjMxMjQ1ODMzLCJleHAiOjE2NjI3ODE4MzMsInN1YiI6IjEiLCJzY29wZXMiOltdfQ.LYE80c7IQe9qqLc5Kb0qPdoCouHDC13zWgqBNRjsD133UyB_hSJLPftzb2RP4HEzwcvdFs1WmurWIk5iWSxFkwDqdZSNeIPxXp6qMubN1zVwD-X-B2-dh0Hu7tS9LcAraOhZDz0_Wqf8YoOn4NyMp_ds2gvaADP9Xkpxexeg3eoV78lJb4Sx89L00aEiAxn2HattueA_fatVKxztueU_iH8u-25sB-vJFKdmoXIV-VF9EH4inxDh6hPvFBPT_iH6YFzBFHBSln7bu7JBudXamFT4fg0d5dubDVs78ZX4uSD0CPEyda7CY39UDFkICT8ltKCcF_zHsCc0FcSjU2G2KomB9eHo7Ga3L99M4I0KqrXnFKAHq44G0vOP1k4PYlxsISqOPeqILYck30iszttRbxpBSu4YIf0-i2nO07vsjrVW-LXKXQPqeUQTebgnTgPi0nZz7Svh7BWrBhFP3iaERQKUbAnLOSuy-zLPf3j10L-Ap9PGBJMny6w6T-7Okld7WTYjpv5R3TT6i7PnyatBQosLbxkSXuiOpilsMNOaWa0Yv73c31TLHwX1u70rPXPq5p9VRHnZJPzxveWdBP5atBNELpiTXiZwup8eThj64O80QbN86SAuCJF9Sl6Yhim6BMQIwVDUnaWxKFhgTuChgK5KqkoYPymnQZj5heGl1mM",
        "refresh_token": "def50200c3bb9358a8dcf05b0abef2860c1457d304bbac4339b08dfed3c17873224c9d40882b6f476d05634c63a5ae73ad11f3327beb414fd258870fb2af55f91a6c1cdddc6f37bffd68bc91bce4fbcb04817ea9a361799fff7d27ab2764ceb8b72690187f4227f85cc312ab4efedfa8281516682e8bf71bae0e56e43790bd67b5f133d6433c8c2579e2573d2304b88edf6287825781d5b9ad111eaf02cba5bd6786e5401fbffc638e2f6b37180741586a13301ad5a93a978e03bab400d174f5188db7031c88b8cef3a21afd264130d21f6fcca71a154854a864ce4a49a5d651b1b8696ed060a3538d44ac265290b97f12e3d61b693e25436e99731b55e0beba187c61dfdd08c7b3b2ac242c478fffae4a2ede2f99e3e721cfa42f28b9a3bc4bf1ccd2ddc75e13d7aac834f6b94c71dc71b63fbaf71e9ad5a83c52efb3c8be12a48a0a6c4dcb8a5540d3f9653c1721b58df2f6af97332f68a8216fd17444c44afb7fc596cf8b01aa72eb51b4dcb768df1e757aa762b503d7b90cbfe7f46db610c0a20451"
    },
    "error": "",
    "msg": "success",
    "timestamp": 1631245833
}
```
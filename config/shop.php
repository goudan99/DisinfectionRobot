<?php
return [
  //头像引存储位置(驱动)
  'avatar' => "public",//头像位置
  'system' => "public",//头像位置
  //用于登录api的oauth
  'auth' => [
    'client' => env('AUTH_CLIENT', "942cab94-3842-4d97-8d66-e329a691fa12"),
    'secret' => env('AUTH_SECRET', "5xbPe1EFwpX9MZajo5i9V066mHC5qXvfp0ri4PBP"),
  ],
];

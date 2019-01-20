<?php
/**
 * @link http://simpleforum.org/
 * @copyright Copyright (c) 2015 Simple Forum
 * @author Jiandong Yu admin@simpleforum.org
 */

return [
    '/' => 'topic/index',
    'tab/all' => 'topic/home',
    'tab/members' => 'topic/members',
    'tab/nodes' => 'topic/nodes',
    'recent' => 'topic/recent',
    'tab/<name:(\w|-)+>' => 'topic/navi',
    'nodes' => 'node/index',
    't/<id:\d+>' => 'topic/view',
    'new' => 'topic/new',
    'post' => 'topic/post',
    'search' => 'topic/search',
    'new/<node:(\w|-)+>' => 'topic/add',
    'go/<name:(\w|-)+>' => 'topic/node',
    'tag/<name>' => 'tag/index',
    'page/<name:(\w|-)+>' => 'page/index',
    'notifications' => 'my/notifications',
    'sms' => 'my/sms',
    'send' => 'service/sms',
    'settings' => 'my/settings',
    'settings/<action:(avatars|email|password|auth|privacy)>' => 'my/<action>',
    'member/<username:\w+>' => 'user/view',
    'member/<username:\w+>/topics' => 'user/topics',
    'member/<username:\w+>/comments' => 'user/comments',
    'site/auth-<authclient:(?!(signup|bind-account))\w+>' => 'site/auth',
    'signup'=>'site/signup',
    'signin'=>'site/signin',
    'login'=>'site/login',
    'signout'=>'site/signout',
    'forgot'=>'site/forgot-password',
    'admin/setting/all' => 'admin/setting/all',
    'more' => 'site/more',
    'mission/daily' => 'service/signin',
    'balance' => 'my/balance',
    'balance/add' => 'my/add',
    'mission/complete' =>'my/balance',
];

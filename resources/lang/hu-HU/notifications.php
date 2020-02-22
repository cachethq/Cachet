<?php

/*
 * This file is part of Cachet.
 *
 * (c) Alt Three Services Limited
 *
 * For the full copyright and license information, please Megjelen�t the LICENSE
 * file that was distributed with this source code.
 */

return [
    'component' => [
        'status_update' => [
            'mail' => [
                'subject'  => 'Komponens �llapota friss�tve.',
                'greeting' => 'Komponens �llapota friss�tve lett!',
                'content'  => ':name �llapota megv�ltozott errol :old_status erre :new_status.',
                'action'   => 'Megjelen�t',
            ],
            'slack' => [
                'title'   => 'Komponens �llapota friss�tve',
                'content' => ':name �llapota megv�ltozott errol :old_status erre :new_status',
            ],
            'sms' => [
                'content' => ':name �llapota megv�ltozott errol :old_status erre :new_status',
            ],
        ],
    ],
    'incident' => [
        'new' => [
            'mail' => [
                'subject'  => '�j incidens bejelentve',
                'greeting' => '�j incidens lett bejelentve a k�vetkezon�l :app_name.',
                'content'  => 'Incidens :name bejelentve',
                'action'   => 'Megjelen�t',
            ],
            'slack' => [
                'title'   => 'Incidens :name bejelentve',
                'content' => '�j incidens lett bejelentve a k�vetkezon�l :app_name',
            ],
            'sms' => [
                'content' => '�j incidens lett bejelentve a k�vetkezon�l :app_name',
            ],
        ],
        'update' => [
            'mail' => [
                'subject' => '�j incidens bejelentve',
                'content' => ':name friss�tve',
                'title'   => ':name friss�tve erre :new_status',
                'action'  => 'Megjelen�t',
            ],
            'slack' => [
                'title'   => ':name friss�tve',
                'content' => ':name friss�tve erre :new_status',
            ],
            'sms' => [
                'content' => 'Incidens :name friss�tve',
            ],
        ],
    ],
    'schedule' => [
        'new' => [
            'mail' => [
                'subject' => '�j �temez�s l�trehozva',
                'content' => ':name �temezve erre a d�tumra :date',
                'title'   => '�temezett karbantart�s l�trehozva.',
                'action'  => 'Megjelen�t',
            ],
            'slack' => [
                'title'   => '�j �temez�s l�trehozva!',
                'content' => ':name �temezve erre a d�tumra :date',
            ],
            'sms' => [
                'content' => ':name �temezve erre a d�tumra :date',
            ],
        ],
    ],
    'subscriber' => [
        'verify' => [
            'mail' => [
                'subject' => 'Eros�tsd meg a feliratkoz�sod',
                'content' => 'Kattints ide, hogy megeros�tsd a feliratkoz�sod a :app_name �llapotoldalra.',
                'title'   => 'Eros�tsd meg a feliratkoz�sod a(z) :app_name �llapotoldalra.',
                'action'  => 'Megeros�t',
            ],
        ],
    ],
    'system' => [
        'test' => [
            'mail' => [
                'subject' => 'Ping a Cachet-tol!',
                'content' => 'Teszt �rtes�t�s a Cachet-tol!',
                'title'   => 'Title',
            ],
        ],
    ],
    'user' => [
        'invite' => [
            'mail' => [
                'subject' => 'Itt a megh�v�d...',
                'content' => 'Meglett�l h�vva a(z) :app_name �llapotoldalra.',
                'title'   => 'Meglett�l h�vva, hogy csatlakozz a  :app_name �llapotoldal�hoz.',
                'action'  => 'Elfogad�s',
            ],
        ],
    ],
];

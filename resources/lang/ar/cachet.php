<?php

/*
 * This file is part of Cachet.
 *
 * (c) Alt Three Services Limited
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

return [
    // Components
    'components' => [
        'last_updated' => 'آخر تحديث :timestamp',
        'status'       => [
            0 => 'مجهول',
            1 => 'Operational',
            2 => 'مشاكل أداء',
            3 => 'إنقطاع جزئي',
            4 => 'إنقطاع أساسي',
        ],
        'group' => [
            'other' => 'مكونات أخرى',
        ],
    ],

    // Incidents
    'incidents' => [
        'none'         => 'لا توجد حالات تم الإبلاغ عنها',
        'past'         => 'حالات الحوادث السابقة',
        'stickied'     => 'حالات الحوادث المثبتة',
        'scheduled'    => 'صيانة مجدولة',
        'scheduled_at' => ', مجدولة :timestamp',
        'posted'       => 'تم الإرسال :timestamp',
        'posted_at'    => 'تم الإرسال :timestamp',
        'status'       => [
            1 => 'تحقيق',
            2 => 'تم التعرف عليه',
            3 => 'مراقبة',
            4 => 'تمّ اصلاحها',
        ],
    ],

    // Schedule
    'schedules' => [
        'status' => [
            0 => 'القادم',
            1 => 'جار المعالجة',
            2 => 'مكتملة',
        ],
    ],

    // Service Status
    'service' => [
        'good'  => '[0,1]System operational|[2,*] All systems are operational',
        'bad'   => '[0,1]The system is experiencing issues|[2,*]Some systems are experiencing issues',
        'major' => '[0,1]The system is experiencing major issues|[2,*]Some systems are experiencing major issues',
    ],

    'api' => [
        'regenerate' => 'إعادة إنشاء مفتاح الواجهة البرمجية',
        'revoke'     => 'إزالة مفتاح الواجهة البرمجية',
    ],

    // Metrics
    'metrics' => [
        'filter' => [
            'last_hour' => 'الساعة الأخيرة',
            'hourly'    => 'آخر 12 ساعة',
            'weekly'    => 'أسبوع',
            'monthly'   => 'شهر',
        ],
    ],

    // Subscriber
    'subscriber' => [
        'subscribe'   => 'إشترك للحصول على التحديثات',
        'unsubscribe' => 'إلغاء الإشتراك في :link',
        'button'      => 'اشتراك',
        'manage'      => [
            'no_subscriptions' => 'أنت الآن مشترك للحصول على جميع التحديثات.',
            'my_subscriptions' => 'أنت كنت مشترك حاليا بالتحديثات التالية.',
        ],
        'email' => [
            'subscribe'          => 'إشترك في تحديثات البريد الإلكتروني.',
            'subscribed'         => 'تم تسجيلك في تنبيهات البريد الإلكتروني، الرجاء تفقد بريدك الإلكتروني لتأكيد الإشتراك.',
            'verified'           => 'تم تأكيد بريدك الإلكتروني. شكراً لك !',
            'manage'             => 'تحكم في الاشتراكات الخاص بك',
            'unsubscribe'        => 'إلغاء الإشتراك من تحديثات البريد الإلكتروني.',
            'unsubscribed'       => 'تم إلغاء إشتراك بريدك الإلكتروني.',
            'failure'            => 'حدث خلل أثناء الإشتراك.',
            'already-subscribed' => 'لا يمكن الاشتراك: البريد الإلكتروني نظراً لأنها كنت الاشتراك مسبقاً.',
        ],
    ],

    'signup' => [
        'title'    => 'تسجيل حساب',
        'username' => 'إسم المستخدم',
        'email'    => 'عنوان البريد الإلكتروني',
        'password' => 'كلمة السر',
        'success'  => 'لقد تم إنشاء حسابك.',
        'failure'  => 'لقد حدث خطأ أثناء إنشاء الحساب.',
    ],

    'system' => [
        'update' => 'There is a newer version of Cachet available. You can learn how to update <a href="https://docs.cachethq.io/docs/updating-cachet">here</a>!',
    ],

    // Modal
    'modal' => [
        'close'     => 'إغلاق',
        'subscribe' => [
            'title'  => 'الإشتراك في تحديثات المكونات',
            'body'   => 'Enter your email address to subscribe to updates for this component. If you\'re already subscribed, you\'ll already receive emails for this component.',
            'button' => 'إشتراك',
        ],
    ],

    // Meta descriptions
    'meta' => [
        'description' => [
            'incident'  => 'Details and updates about the :name incident that occurred on :date',
            'schedule'  => 'Details about the scheduled maintenance period :name starting :startDate',
            'subscribe' => 'Subscribe to :app in order to receive updates of incidents and scheduled maintenance periods',
            'overview'  => 'Stay up to date with the latest service updates from :app.',
        ],
    ],

    // Other
    'home'            => 'الصفحة الرئيسية',
    'powered_by'      => 'مدعوم بواسطة <a href="https://cachethq.io" class="links">Cachet</a>.',
    'timezone'        => 'Times are shown in :timezone.',
    'about_this_site' => 'عن هذا الموقع',
    'rss-feed'        => 'RSS',
    'atom-feed'       => 'Atom',
    'feed'            => 'Status Feed',

];

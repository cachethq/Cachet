<?php

/*
 * This file is part of Cachet.
 *
 * (c) Alt Three Services Limited
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace CachetHQ\Cachet\Bus\Commands\Subscriber;

/**
 * This is the subscribe subscriber command.
 *
 * @author James Brooks <james@alt-three.com>
 */
final class SubscribeSubscriberCommand
{
    /**
     * The subscriber email.
     *
     * @var string
     */
    public $email;

    /**
     * The subscriber auto verification.
     *
     * @var bool
     */
    public $verified;

    /**
     * The list of subscriptions to set the subscriber up with.
     *
     * @var array|null
     */
    public $subscriptions;

    /**
     * If the subscriber accepted the privacy statement.
     *
     * @var bool
     */
    public $acceptPrivacyStatement;

    /**
     * The validation rules.
     *
     * @var array
     */
    public $rules = [
        'email'                  => 'required|email',
        'acceptPrivacyStatement' => 'required|accepted',
    ];

    /**
     * Create a new subscribe subscriber command instance.
     *
     * @param string     $email
     * @param bool       $verified
     * @param array|null $subscriptions
     * @param bool       $acceptPrivacyStatement
     *
     * @return void
     */
    public function __construct($email, $verified = false, $subscriptions = null, $acceptPrivacyStatement = null)
    {
        $this->email = $email;
        $this->verified = $verified;
        $this->subscriptions = $subscriptions;
        $this->acceptPrivacyStatement = $acceptPrivacyStatement;
    }
}

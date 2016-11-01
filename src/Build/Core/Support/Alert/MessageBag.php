<?php

namespace Build\Core\Support\Alert;

/*
 * This file is part of the Build package.
 *
 * (c) Centagon <contact@centagon.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Illuminate\Session\Store as Session;
use Illuminate\Config\Repository as Config;

class MessageBag extends \Illuminate\Support\MessageBag
{

    /**
     * Available message levels.
     * @var array
     */
    protected $levels = [
        'secondary',
        'primary',
        'success',
        'warning',
        'alert'
    ];

    /**
     * @var Session
     */
    protected $session;

    /**
     * @var Config
     */
    protected $config;

    /**
     * MessageBag constructor.
     *
     * @param  Session  $session
     * @param  Config   $config
     * @param  array    $messages
     */
    public function __construct(Session $session, Config $config, array $messages = [])
    {
        $this->session = $session;
        $this->config = $config;

        if ($session->has($this->getSessionKey())) {
            $messages = array_merge_recursive($session->get($this->getSessionKey()), $messages);
        }

        parent::__construct($messages);
    }

    /**
     * Dynamically handle alert additions.
     *
     * @param  string  $method
     * @param  array   $arguments
     *
     * @return $this
     * @throws \BadMethodCallException
     */
    public function __call($method, array $arguments = [])
    {
        // Check if the method is an allowed alert level.
        if (in_array($method, $this->levels)) {
            if (is_array($arguments[0])) {
                foreach ($arguments[0] as $argument) {
                    $this->add($method, $arguments);
                }

                return $this;
            }

            return $this->add($method, $arguments[0]);
        }

        throw new \BadMethodCallException(sprintf('Cannot add alert of type %s.', $method));
    }

    /**
     * Flash the alert for the next response.
     *
     * @return $this
     */
    public function flash()
    {
        $this->session->flash($this->getSessionKey(), $this->messages);

        return $this;
    }

    /**
     * Format an array of messages.
     *
     * @param  array   $messages
     * @param  string  $format
     * @param  string  $messageKey
     *
     * @return array
     */
    protected function transform($messages, $format, $messageKey)
    {
        $messages = (array) $messages;

        // We will simply spin through the given messages and transform each one
        // replacing the :message placeholder with the real message allowing
        // the messages to be easily formatted to each developer's desires.
        foreach ($messages as $key => &$message) {
            $replace = [':message', ':key'];

            if ($messages instanceof \Illuminate\Support\MessageBag) {
                continue;
            }

            if (is_array($message)) {
                foreach ($message as &$msg) {
                    $msg = str_replace($replace, [$msg, $messageKey], $format);
                }
            } else {
                $message = str_replace($replace, [$message, $messageKey], $format);
            }
        }

        return $messages;
    }

    /**
     * Get the alert session key.
     *
     * @return string
     */
    protected function getSessionKey()
    {
        return 'build.core.alert';
    }
}

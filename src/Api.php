<?php

/**
 * Part of the Pushy package.
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the 3-clause BSD License.
 *
 * This source file is subject to the 3-clause BSD License that is
 * bundled with this package in the LICENSE file.
 *
 * @package    Pushy
 * @version    1.0.0
 * @author     Jose Lorente
 * @license    BSD License (3-clause)
 * @copyright  (c) 2019, Jose Lorente
 */

namespace Jlorente\Pushy;

use Jlorente\Pushy\Core\Api as CoreApi;

/**
 * Class DeviceInfo.
 * 
 * @author Jose Lorente <jose.lorente.martin@gmail.com>
 * @see https://pushy.me/docs/api/device
 */
class Api extends CoreApi
{

    /**
     * Gets the device info.
     *
     * @param string $token
     * @return array
     * @see https://pushy.me/docs/api/device
     */
    public function deviceInfo(string $token)
    {
        return $this->_get("devices/$token");
    }

    /**
     * Use this endpoint to check the presence and connectivity status of multiple devices.
     * 
     * @param array $tokens
     * @return array
     * @see https://pushy.me/docs/api/device-presence
     */
    public function devicePresence(array $tokens = [])
    {
        return $this->_post('devices/presence', [
                    RequestOptions::JSON => [
                        'tokens' => $tokens
                    ]
        ]);
    }

    /**
     * Use this API to permanently delete a pending notification.
     *
     * @param string $pushId
     * @return array
     * @see https://pushy.me/docs/api/notification-deletion
     */
    public function notificationDeletion(string $pushId)
    {
        return $this->_delete("pushes/$pushId");
    }

    /**
     * Use this API to check the delivery status of your push notifications.
     *
     * @param string $pushId
     * @return array
     * @see https://pushy.me/docs/api/notification-status
     */
    public function notificationStatus(string $pushId)
    {
        return $this->_get("pushes/$pushId");
    }

    /**
     * Subscribe a device to topics from your backend server.
     *
     * @param array $parameters
     * @return array
     * @see https://pushy.me/docs/api/pubsub-subscribe
     */
    public function pubSubSubscribe(array $parameters = [])
    {
        return $this->_post('devices/subscribe', [
                    RequestOptions::JSON => $parameters
        ]);
    }

    /**
     * Unsubscribe a device from topics from your backend server.
     *
     * @param array $parameters
     * @return array
     * @see https://pushy.me/docs/api/pubsub-unsubscribe
     */
    public function pubSubUnsubscribe(array $parameters = [])
    {
        return $this->_post('devices/unsubscribe', [
                    RequestOptions::JSON => $parameters
        ]);
    }

    /**
     * Returns a list of device tokens subscribed to a certain topic.
     *
     * @param string $topic
     * @return array
     * @see https://pushy.me/docs/api/pubsub-subscribers
     */
    public function pubSubSubscribers(string $topic)
    {
        return $this->_get("topics/$topic");
    }

    /**
     * Returns a list of your app's topics and subscribers count.
     *
     * @return array
     * @see https://pushy.me/docs/api/pubsub-topics
     */
    public function pubSubTopics()
    {
        return $this->_get('topics');
    }

    /**
     * Instantly send push notifications to devices and more with this powerful API.
     * 
     * @param array $parameters
     * @return array
     * @see https://pushy.me/docs/api/send-notifications
     */
    public function sendNotifications(array $parameters = [])
    {
        return $this->_post('push', [
                    RequestOptions::JSON => $parameters
        ]);
    }

}

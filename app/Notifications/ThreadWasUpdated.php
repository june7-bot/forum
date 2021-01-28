<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;

class ThreadWasUpdated extends Notification
{

    protected $thread, $reply;

    /**
     * Create a new notification instance.
     *
     * @param $thread
     * @param $reply
     */
    public function __construct($thread, $reply)
    {
        $this->thread = $thread;
        $this->reply = $reply;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array
     */
    public function via()
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *`
     * @return array
     */
    public function toArray()
    {
        return [
            'message' => $this->reply->owner->name . ' replied to ' . $this->thread->title,
            'link' => $this->reply->path(),
        ];
    }
}

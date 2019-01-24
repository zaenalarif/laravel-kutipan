<?php

namespace App\Listeners;

use App\Models\Quote;
use App\Mail\ForumPosted;
use Illuminate\Support\Facades\Mail;
use App\Events\ForumCreated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendUserEmail implements ShouldQueue
{
    protected $quote;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(Quote $quote)
    {
        $this->quote = $quote;
    }

    /**
     * Handle the event.
     *
     * @param  ForumCreated  $event
     * @return void
     */
    public function handle(ForumCreated $event)
    {
        Mail::to('test@test.com')->send(new ForumPosted($event->quote));
    }
}
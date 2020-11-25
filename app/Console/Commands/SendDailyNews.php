<?php

namespace App\Console\Commands;

use App\Post;
use App\User;
use App\Notifications\DailyNews;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Notification;

class SendDailyNews extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'matrix:send-daily-news';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch the posts for the current date and send an '
                           . ' email with them to the whole school.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct() { parent::__construct(); }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $posts = Post::where('publish_date', today())->get();

        if ($posts->isNotEmpty()) {
            Notification::send(
                User::all()->except(1),
                new DailyNews(
                    $posts->where('type', 'announcement'),
                    $posts->where('type', 'reminder')
                )
            );
        }
    }
}

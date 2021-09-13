<?php

namespace App\Console\Commands;

use App\Models\Notification;
use Illuminate\Console\Command;

class NotifyUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:notify';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'user:notify';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $Notifications = Notification::where('status','!=',1)->where('type',1)->get();
        foreach($Notifications as $Notification) {
            $client = new \GuzzleHttp\Client([
                'timeout'  => 2.0,
            ]);
            $response =  $client->post('https://www.msegat.com/gw/sendsms.php', [
                'json' => [
                    'userName' => 'test',
                    'apiKey' => 'test',
                    'numbers' => $Notification->receiver,
                    'userSender' =>  "BASS",
                    'msg' =>   $Notification->body,
                    'msgEncoding' =>  "UTF8"]
            ]);

            $body = json_decode($response->getBody());

            if($body->code==1)
            {
                    $Notification->update([
                        'number_of_attempts' => $Notification->number_of_attempts + 1,
                        'status' => 1
                    ]);
            }else{
                $Notification->update([
                    'number_of_attempts' => ($Notification->number_of_attempts) + 1,
                    'status' => 2
                ]);
            }
        }
}
}

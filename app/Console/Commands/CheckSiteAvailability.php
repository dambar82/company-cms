<?php

namespace App\Console\Commands;

use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\SiteDownNotification;

class CheckSiteAvailability extends Command
{
    protected array $sites = [
        'https://dnevnik.rubin-kazan.ru',
        'https://tatarcartoon.ru/'
    ];

    protected string $notificationEmail = 'dmitrij.m.183@yandex.ru';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:sites';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check availability of remote sites';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        foreach ($this->sites as $site) {
            try {
                $response = Http::timeout(10)->get($site);
                $status = $response->status();

                if ($status !== 200) {
                    $this->sendNotification($site, $status);
                }
            } catch (Exception $e) {
                $this->sendNotification($site, $e->getMessage());
            }
        }

        Log::info('Site availability check completed.');
        return 0;
    }

    /**
     * Send notification email
     *
     * @param string $site
     * @param mixed $error
     */
    protected function sendNotification(string $site, mixed $error): void
    {
        $errorMessage = is_numeric($error)
            ? "HTTP Status: $error"
            : "Error: $error";

        $subject = "Site $site is down";
        $message = "Site: $site\nProblem: $errorMessage\nTime: ".now();

        Mail::to($this->notificationEmail)
            ->send(new SiteDownNotification($subject, $message));

        $this->error("Problem detected with $site: $errorMessage");
    }
}

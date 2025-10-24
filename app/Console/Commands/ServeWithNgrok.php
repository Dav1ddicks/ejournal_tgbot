<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use JnJairo\Laravel\Ngrok\NgrokWebService;
use RuntimeException;
use Symfony\Component\Process\Process;

class ServeWithNgrok extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bot:start';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $port = null;
        $tgBotToken = env("TELEGRAM_BOT_TOKEN");

        $serve = new Process(['php', 'artisan', 'serve']);
        $serve->start();

        sleep(2);

        $output = $serve->getOutput();

        if (!empty($output)) {
            if (preg_match('/http:\/\/127\.0\.0\.1:(\d+)/', $output, $match)) {
                $port = $match[1];
            } else {
                throw new RuntimeException("Не вдалося визначити порт з виводу:\n{$output}");
            }
        } else {
            return self::FAILURE;
        }

        $this->info("Laravel server started at port: {$port}");
        
        $ngrokProcess = new Process(['php', 'artisan', 'ngrok', '--port=' . $port]);
        $ngrokProcess->start();

        sleep(1);

        $webService = app(NgrokWebService::class);

        try {
            $tunnels = $webService->getTunnels();
        } catch (\Throwable $th) {
            return self::FAILURE;
        }

        $url = null;

        foreach ($tunnels as $tunnel) {
            if (isset($tunnel['proto']) && $tunnel['proto'] === 'https' && !empty($tunnel['public_url'])) {
                $url = $tunnel['public_url'];
                break;
            }
        }

        if (!$url) {
            return self::FAILURE;
        }

        $this->info("Ngrok url: {$url}");

        declare(ticks = 1);

        $webhookUrl = $url . '/webhook';
        $response = Http::post("https://api.telegram.org/bot{$tgBotToken}/setWebhook", [
            'url' => $webhookUrl,
        ]);

        if (!$response->successful()) {
            $this->error('Помилка при встановленні webhook: ' . $response->body());
            exit;
        }

        $this->info('Telegram webhook set');

        pcntl_signal(SIGINT, function() {
            echo "\nBye!\n";
            exit;
        });

        while(true) {
            sleep(60);
        }
    }
}
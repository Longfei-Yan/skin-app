<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use function Termwind\ask;

class GenerateToken extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'skin:generate-token';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '快速生成长效token';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $userId = $this->ask('输入用户 id');
        $user = User::find($userId);

        if (!$user) {
            return $this->error('用户不存在');
        }

        // 一年以后过期，单位分钟
        $ttl = 365*24*60;
        $this->info(auth('api')->setTTL($ttl)->login($user));
    }
}

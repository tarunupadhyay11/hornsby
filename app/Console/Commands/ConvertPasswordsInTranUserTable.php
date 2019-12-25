<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

use App\User;

class ConvertPasswordsInTranUserTable extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tran_user:convert_plain_passwords_to_hashes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Convert plain passwords in tran_user table into Hashes';

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
     * @return mixed
     */
    public function handle()
    {

        $this->info('Converting plain passwords started...');

        /**
         * Laravel uses Hash::make function for passwords, length is 60 symbols
         * To convert passwords needed to get all users who have passwords length less
         * than 60 symbols
         */
        $usersSql = User::select('*')
            ->whereRaw('LENGTH(password) < 60')
        ;

        $users = $usersSql->get();

        if ($users->count() > 0) {
            $bar = $this->output->createProgressBar($users->count());
            foreach ($users as $user)
            {
                $newPassword = Hash::make($user->password);
                $user->update(['password' => $newPassword]);

                $bar->advance();
            }

            $bar->finish();
            $this->line('');
        } else {
            $this->info('Passwords already converted');
        }
    }
}












<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Bouncer;
use App\User;

class InitBouncer extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'init:bouncer';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Assign Roles';

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
        $admin = Bouncer::role()->create([
          'name' => 'admin',
          'title' => 'Administrator'
        ]);

        $member = Bouncer::role()->create([
            'name' => 'member',
            'title' => 'Member',
        ]);

        $manageMovies = Bouncer::ability()->create([
            'name' => 'manage-movies',
            'title' => 'Manage Movies',
        ]);

        $viewMovies = Bouncer::ability()->create([
            'name' => 'view-movies',
            'title' => 'View Movies',
        ]);

        Bouncer::allow($admin)->to($manageMovies);
        Bouncer::allow($admin)->to($viewMovies);

        Bouncer::allow($member)->to($viewMovies);

        $user = User::where('email', 'admin@mylib.info')->first();
        Bouncer::assign($admin)->to($user);

        $user = User::where('email', 'user1@mylib.info')->first();
        Bouncer::assign($member)->to($user);

        $user = User::where('email', 'user2@mylib.info')->first();
        Bouncer::assign($member)->to($user);

    }
}

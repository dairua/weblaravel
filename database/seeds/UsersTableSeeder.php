<?php

use Illuminate\Database\Seeder;
use App\Admin;
use App\Roles;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Admin::truncate();
        DB::table('admin_roles')->truncate();

        $adminRoles = Roles::where('name','admin')->first();
        $authorRoles = Roles::where('name','author')->first();
        $userRoles = Roles::where('name','user')->first();

        $admin = Admin::create([
            'admin_name' => 'Phạm Đại ADMIN',
            'admin_email' => 'phamdaiadmin@gmail.com',
            'admin_phone' => '0832905658',
            'admin_password' => md5('200311')
        ]);
        $author = Admin::create([
            'admin_name' => 'Phạm Đại AUTHOR',
            'admin_email' => 'phamdaiauthor@gmail.com',
            'admin_phone' => '0832905658',
            'admin_password' => md5('200311')
        ]);
        $user = Admin::create([
            'admin_name' => 'Phạm Đại USER',
            'admin_email' => 'phamdaiuser@gmail.com',
            'admin_phone' => '0832905658',
            'admin_password' => md5('200311')
        ]);

        $admin->roles()->attach($adminRoles);
        $author->roles()->attach($authorRoles);
        $user->roles()->attach($userRoles);

        factory(App\Admin::class,5)->create();
    }
}

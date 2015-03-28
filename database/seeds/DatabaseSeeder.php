<?php

    use Illuminate\Database\Seeder;
    use Illuminate\Database\Eloquent\Model;

    use App\User;
    use App\Setting;

    class DatabaseSeeder extends Seeder {

        /**
         * Run the database seeds.
         *
         * @return void
         */
        public function run()
        {
            Model::unguard();

            $this->call('UserTableSeeder');
            $this->command->info('User table seeded');

            $this->call('SettingTableSeeder');
            $this->command->info('Setting table seeded');

        }
    }

    class UserTableSeeder extends Seeder {

        public function run()
        {
            DB::table('users')->delete();

            User::create(['name' => 'Sean Pollock',
                'email' => 'ryliedaddy@gmail.com',
                'password' => Hash::make('password')]);

        }

    }

    class SettingTableSeeder extends Seeder {

        public function run()
        {

            DB::table('settings')->delete();

            Setting::create(['company' => 'Cubix Solutions',
                'slogan' => 'An IT Service Company',
                'address1' => '',
                'address2' => '',
                'city' => '',
                'state' => '',
                'postal_code' => '']);

        }
    }


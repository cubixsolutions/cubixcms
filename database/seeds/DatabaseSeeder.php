<?php

    use Illuminate\Database\Seeder;
    use Illuminate\Database\Eloquent\Model;

    use App\User;
    use App\Setting;
    use App\ProductType;
    use App\ProductCategory;
    use App\Product;
    use Carbon\Carbon;

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

            $this->call('ProductTypeTableSeeder');
            $this->command->info('Product Type table seeded!');

            $this->call('ProductCategoriesTableSeeder');
            $this->command->info('Product Categories table seeded!');

            $this->call('ProductTableSeeder');
            $this->command->info('Product Table Seeded!');

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

    class ProductTypeTableSeeder extends Seeder {

        public function run()
        {

            DB::table('product_types')->delete();

            ProductType::create(['product_type' => 'Product']);
            ProductType::create(['product_type' => 'Service']);

        }

    }

    class ProductCategoriesTableSeeder extends Seeder {

        public function run()
        {

            DB::table('product_categories')->delete();

            ProductCategory::insert(array('image' => 'web-development.png',
                'category' => 'Web Development',
                'slug' => 'web-development',
                'description' => 'Do you need a website for you or your business?  We can build any website that you may want from static five page sites to dynamic corporate websites.',
                'active' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()));

            ProductCategory::insert(array('image' => 'logo-design-and-branding.png',
                'category' => 'Logo Design and Branding',
                'slug' => 'logo-design-and-branding',
                'description' => 'Do you need a logo for your business or website?  We have the experience to bring your business to life.',
                'active' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()));

            ProductCategory::insert(array('image' => 'business-printing.png',
                'category' => 'Business Printing',
                'slug' => 'business-printing',
                'description' => 'Do you need business cards, flyers, signs, banners or anything printed?  We can help and we have the experience to help you with all of your printing needs.',
                'active' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()));

            ProductCategory::insert(array('image' => 'computer-services.png',
                'category' => 'Computer Services',
                'slug' => 'computer-services',
                'description' => 'Are you having computer problems? Do you need help cleaning your computer or removing malware from your system?  We can help.',
                'active' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()));

            ProductCategory::insert(array('image' => 'web-hosting.png',
                'category' => 'Web Hosting',
                'slug' => 'web-hosting',
                'description' => 'Do you need a super fast web host?  We can provide shared hosting or virtual servers on our blazing fast network.',
                'active' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()));
        }

    }

    class ProductTableSeeder extends Seeder {

        public function run()
        {

            DB::table('products')->delete();

            Product::insert(array('sku'                 => 'WEB-DEV-01',
                'image'               => 'web-development.png',
                'category_id'         => 1,
                'product'             => 'Personal Website',
                'product_type'        => 1,
                'description'         => 'Basic static website for the beginner or hobbiest.  Contains five pages which can include an About page, Gallery page, Contact page, etc.\r\n\r\nAll Web Development Packages include 1 FREE domain name',
                'price'               => '199.99',
                'created_at'          => Carbon::now(),
                'updated_at'          => Carbon::now()));

            Product::insert(array('sku'                 => 'WEB-DEV-02',
                'image'               => 'web-development.png',
                'category_id'         => 1,
                'product'             => 'Business Website',
                'product_type'        => 1,
                'description'         => 'This package is for small businesses who needs a little more than a static website.  Included is a contact_us page that allows visitors to fill out a form and submit it.',
                'price'               => '399.99',
                'created_at'          => Carbon::now(),
                'updated_at'          => Carbon::now()));

            Product::insert(array('sku'                 => 'WEB-DEV-03',
                'image'               => 'web-development.png',
                'category_id'         => 1,
                'product'             => 'E-Commerce Website',
                'product_type'        => 1,
                'description'         => 'Do you need to sell something online?  We can build you a store that makes use of a variety of payment processors.',
                'price'               => '599.99',
                'created_at'          => Carbon::now(),
                'updated_at'          => Carbon::now()));

            Product::insert(array('sku'                 => 'WEB-DEV-CUSTOM',
                'image'               => 'web-development.png',
                'category_id'         => 1,
                'product'             => 'Custom Website',
                'product_type'        => 1,
                'description'         => 'Do you need something unique that does not fit our other packages?  Lets talk.',
                'price'               => '',
                'created_at'          => Carbon::now(),
                'updated_at'          => Carbon::now()));


        }
    }


<?php

use App\ProductCategory;
use Illuminate\Database\Seeder;

class ProductCategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ProductCategory::query()->updateOrCreate(
            ['pcdx' => 1],
            [
                'sequence' => 1,
                'cname' => '해양심층수',
                'parent' => 0,
                'state' => 10,
            ]
        );
    }
}

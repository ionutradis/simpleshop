<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $products_seed_data = [
            [
                'name'  => 'Iphone 8 Plus Black 64GB',
                'image' => 'https://store.storeimages.cdn-apple.com/4982/as-images.apple.com/is/refurb-iphone8plus-spacegray?wid=1144&hei=1144&fmt=jpeg&qlt=95&.v=1564083513793',
                'quantity'      => '3',
                'price'         => 298.99,
                'status'        => (string)1
            ],
            [
                'name'  => 'Samsung Galaxy S10 Midnight Black 128GB',
                'quantity'      => '1',
                'image'         => 'https://p1.akcdn.net/full/715774614.samsung-galaxy-s10-5g-256gb-dual-g977.jpg',
                'price'         => 300,
                'status'        => (string)1
            ],
            [
                'name'  => 'Samsung Galaxy S7 WHITE 32GB',
                'image' =>  'https://fdn2.gsmarena.com/vv/pics/samsung/samsung-galaxy-s7-edge-1.jpg',
                'quantity'      => '0',
                'price'         => 100,
                'status'        => (string)1
            ]
        ];
        foreach($products_seed_data as $product_seed_data) {
            Product::create(
                $product_seed_data
            );
        }
    }
}

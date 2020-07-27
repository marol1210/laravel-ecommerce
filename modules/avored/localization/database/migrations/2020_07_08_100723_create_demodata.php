<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use AvoRed\Framework\Database\Models\Category;
use AvoRed\Framework\Database\Models\Product;
use AvoRed\Framework\Database\Models\ProductImage;
use Faker\Factory;
use AvoRed\Framework\Database\Models\Menu;
use AvoRed\Framework\Database\Models\ProductPropertyIntegerValue;
use AvoRed\Framework\Database\Models\Property;
use AvoRed\Framework\Database\Models\Attribute;
use AvoRed\Framework\Database\Models\CategoryFilter;
use AvoRed\Framework\Database\Models\MenuGroup;
use AvoRed\Framework\Database\Models\Page;
use AvoRed\Framework\Database\Models\PropertyDropdownOption;


class CreateDemodata extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $faker = Factory::create();
        //商品分类
        $category_mobile = Category::create([
            'name' => '手机',
            'slug' => 'mobile'
        ]);
        $category_laptop = Category::create([
            'name' => '笔记本',
            'slug' => 'laptop'
        ]);
        $category_display = Category::create([
            'name' => '显示器',
            'slug' => 'display'
        ]);
        
        //商城商品自有属性
        $colorAttribute = Attribute::create(
                [
                    'name' => 'Color',
                    'slug' => 'color',
                    'display_as' => 'IMAGE'
                ]
        );
        $attrbute_color_red = $colorAttribute->dropdownOptions()->create(['display_text' => 'Red', 'path' => 'uploads/catalog/attributes/red-attribute.jpg']);
        $attrbute_color_blue = $colorAttribute->dropdownOptions()->create(['display_text' => 'Blue', 'path' => 'uploads/catalog/attributes/blue-attribute.png']);
        $attrbute_color_yellow = $colorAttribute->dropdownOptions()->create(['display_text' => 'Yellow', 'path' => 'uploads/catalog/attributes/yellow-attribute.png']);
        
        /*商城商品通用属性*/
        //品牌属性
        $brandProperty = Property::create(
                [
                    'name' => '品牌',
                    'slug' => 'brand',
                    'data_type' => 'INTEGER',
                    'field_type' => 'SELECT',
                    'use_for_all_products' => 1,
                    'use_for_category_filter' => 1,
                    'is_visible_frontend' => 1,
                    'sort_order' => 10
                ]
        );
        $property_brand_huawei = $brandProperty->dropdownOptions()->create(['display_text' => '华为']);
        $property_brand_xiaomi = $brandProperty->dropdownOptions()->create(['display_text' => '小米']);
        
        
        //显示器
        $displayBrandProperty = Property::create(
            [
                'name' => '显示器',
                'slug' => 'brand-display',
                'data_type' => 'INTEGER',
                'field_type' => 'SELECT',
                'use_for_all_products' => 1,
                'use_for_category_filter' => 1,
                'is_visible_frontend' => 1,
                'sort_order' => 10
            ]
        );
        $property_brand_jdf = $displayBrandProperty->dropdownOptions()->create(['display_text' => '京东方']);
        
        
        //商品类型过滤——关联商城商品通用属性  （一个商品可属于1个或多个商品类型）
        CategoryFilter::create(
                [
                    'category_id' => $category_mobile->id,
                    'filter_id' => $brandProperty->id,
                    'type' => 'PROPERTY'
                ]
        );
        CategoryFilter::create(
                [
                    'category_id' => $category_laptop->id,
                    'filter_id' => $brandProperty->id,
                    'type' => 'PROPERTY'
                ]
        );
        CategoryFilter::create(
                [
                    'category_id' => $category_display->id,
                    'filter_id' => $displayBrandProperty->id,
                    'type' => 'PROPERTY'
                ]
        );
        
        //创建商品
        $price = rand(500, 1000) / 10;
        $product = Product::create([
            'type' => 'BASIC',
            'name' => 'Huawei P40',
            'slug' => 'mobile-huawei-p40',
            'sku' => 'huawei-p40',
            'barcode' => '123456789',
            'description' => $faker->text,
            'status' => 1,
            'in_stock' => 1,
            'track_stock' => 1,
            'qty' => rand(50, 100),
            'is_taxable' => 1,
            'price' => $price,
            'cost_price' => $price - (rand(50, 100) / 10),
            'weight' => rand(1, 10),
            'height' => rand(1, 10),
            'length' => rand(1, 10),
            'width' => rand(1, 10),
        ]);
        

        $xiaomi = [
                'name'=>'Xiaomi 10', 
                'price'=>rand(500, 1000) / 10,
                'qty' => rand(50, 100), 
                'cost_price' => $price - (rand(50, 100) / 10),
                'description' => $faker->text, 
                'slug' => 'mobile-xiaomik-10',
                'sku' => 'xiaomik-10',
                'barcode' => $faker->countryCode
        ];
        $replicate_product_xiaomi = $product->replicate()->fill($xiaomi);
        $replicate_product_xiaomi->save();
        
        $replicate_product_xiaomi->categories()->sync([$category_mobile->id]);
        ProductImage::create(['path' => 'uploads/catalog/'. $replicate_product_xiaomi->id .'/x-10.jpg', 'product_id' => $replicate_product_xiaomi->id, 'is_main_image' => 1]);
        $replicate_product_xiaomi->productPropertyIntegerValues()->create(['property_id' => $brandProperty->id, 'value' => $property_brand_xiaomi->id]);
        $replicate_product_xiaomi->properties()->sync([$brandProperty->id]);
        
        
        $jdf = [
            'name'=>'京东方 27” 4K',
            'price'=>rand(500, 1000) / 10,
            'qty' => rand(50, 100),
            'cost_price' => $price - (rand(50, 100) / 10),
            'description' => $faker->text,
            'slug' => 'display-jdf-27',
            'sku' => 'jdf-27',
            'barcode' => $faker->countryCode
        ];
        $replicate_product_jdf = $product->replicate()->fill($jdf);
        $replicate_product_jdf->save();
        $replicate_product_jdf->categories()->sync([$category_display->id]);
        ProductImage::create(['path' => 'uploads/catalog/'. $replicate_product_jdf->id .'/jdf.jpg', 'product_id' => $replicate_product_jdf->id, 'is_main_image' => 1]);
        $replicate_product_jdf->productPropertyIntegerValues()->create(['property_id' => $displayBrandProperty->id, 'value' => $property_brand_jdf->id]);
        $replicate_product_jdf->properties()->sync([$displayBrandProperty->id]);
        
        
        $huawei_pc = [
            'name'=>'huawei-pc',
            'price'=>rand(500, 1000) / 10,
            'qty' => rand(50, 100),
            'cost_price' => $price - (rand(50, 100) / 10),
            'description' => $faker->text,
            'slug' => 'laptop-huawei-pc',
            'sku' => 'huawei-pc',
            'barcode' => $faker->countryCode
        ];
        $replicate_product_huawei_pc = $product->replicate()->fill($xiaomi);
        $replicate_product_huawei_pc->save();
        
        $replicate_product_huawei_pc->categories()->sync([$category_laptop->id]);
        ProductImage::create(['path' => 'uploads/catalog/'. $replicate_product_huawei_pc->id .'/huawei-pc1.png', 'product_id' => $replicate_product_huawei_pc->id, 'is_main_image' => 1]);
        $replicate_product_huawei_pc->productPropertyIntegerValues()->create(['property_id' => $brandProperty->id, 'value' => $property_brand_huawei->id]);
        $replicate_product_huawei_pc->properties()->sync([$brandProperty->id]);
        
        
        $xiaomi_pc = [
            'name'=>'xiaomi-pc',
            'price'=>rand(500, 1000) / 10,
            'qty' => rand(50, 100),
            'cost_price' => $price - (rand(50, 100) / 10),
            'description' => $faker->text,
            'slug' => 'laptop-xiaomi-pc',
            'sku' => 'xiaomi-pc',
            'barcode' => $faker->countryCode
        ];
        $replicate_product_xiaomi_pc = $product->replicate()->fill($xiaomi);
        $replicate_product_xiaomi_pc->save();
        
        $replicate_product_xiaomi_pc->categories()->sync([$category_laptop->id]);
        ProductImage::create(['path' => 'uploads/catalog/'. $replicate_product_xiaomi_pc->id .'/xiaomi-pc1.jpg', 'product_id' => $replicate_product_xiaomi_pc->id, 'is_main_image' => 1]);
        $replicate_product_xiaomi_pc->productPropertyIntegerValues()->create(['property_id' => $brandProperty->id, 'value' => $property_brand_xiaomi->id]);
        $replicate_product_xiaomi_pc->properties()->sync([$brandProperty->id]);
        
        
        $product->categories()->sync([$category_mobile->id]);
        ProductImage::create(['path' => 'uploads/catalog/'. $product->id .'/p40.png', 'product_id' => $product->id, 'is_main_image' => 1]);
        $product->productPropertyIntegerValues()->create(['property_id' => $brandProperty->id, 'value' => $property_brand_huawei->id]);
        $product->properties()->sync([$brandProperty->id]);
        
        //创建菜单组
        $mainMenu = MenuGroup::create(['name' => 'Main Menu', 'identifier' => 'main-menu', 'is_default' => 1]);
        
        $mainMenu->menus()->create(['name' => $category_mobile->name, 'url' => '/category/' . $category_mobile->slug]);
        $mainMenu->menus()->create(['name' => $category_laptop->name, 'url' => '/category/' . $category_laptop->slug]);
        $mainMenu->menus()->create(['name' => $category_display->name, 'url' => '/category/' . $category_display->slug]);
        $mainMenu->menus()->create(['name' => '购物车', 'url' => '/cart']);
        $mainMenu->menus()->create(['name' => '结账', 'url' => '/checkout']);
        $mainMenu->menus()->create(['name' => '登录', 'url' => '/login']);
        $mainMenu->menus()->create(['name' => '注册', 'url' => '/register-cn']);
        
        $mainAuthMenu = MenuGroup::create(['name' => 'Main Auth Menu', 'identifier' => 'main-auth-menu']);
        
        $mainAuthMenu->menus()->create(['name' => $category_mobile->name, 'url' => '/category/' . $category_mobile->slug]);
        $mainAuthMenu->menus()->create(['name' => $category_laptop->name, 'url' => '/category/' . $category_laptop->slug]);
        $mainAuthMenu->menus()->create(['name' => $category_display->name, 'url' => '/category/' . $category_display->slug]);
        $mainAuthMenu->menus()->create(['name' => '购物车', 'url' => '/cart']);
        $mainAuthMenu->menus()->create(['name' => '结账', 'url' => '/checkout']);
        $accountMenu = $mainAuthMenu->menus()->create(['name' => '我的', 'url' => '/account']);
        $mainAuthMenu->menus()->create(['name' => '登出', 'url' => '/logout', 'parent_id' => $accountMenu->id]);
        
        Page::create(
            ['name' => 'HomePage',
                'slug' => 'home-page',
                'content' => '%%%avored-banner%%%']
            );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Category::truncate();
        MenuGroup::truncate();
        Attribute::truncate();
        Menu::truncate();
        CategoryFilter::truncate();
        Page::truncate();
        ProductImage::truncate();
        Property::truncate();
        ProductPropertyIntegerValue::truncate();
        PropertyDropdownOption::truncate();
        Product::truncate();
        Schema::enableForeignKeyConstraints();
    }
    
    
    /**
     * 完整过滤条件
     */
    protected function addCategory($category_id)
    {
        $property =  Property::all();
        
        foreach ($property as $p){
             CategoryFilter::create(
                 ['category_id' => $category_id,
                     'filter_id' => $p->id,
                 'type' => 'PROPERTY']
             );
        }
    }
}

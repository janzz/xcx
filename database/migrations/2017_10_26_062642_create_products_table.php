<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->string('intro');//简介
            $table->decimal('sales_price', 10, 2); //售价  最长十位， 小数点后面两位
            $table->decimal('market_price', 10, 2);//市场价
            $table->integer('store'); //库存
            $table->integer('weight');//重量
            $table->integer('sort');//排序
            $table->integer('sales_base');//销售基数
            $table->text('details'); //详情
            $table->tinyInteger('racking'); //是否上架
            $table->integer('operator');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}

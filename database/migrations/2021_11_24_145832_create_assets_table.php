<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assets', function (Blueprint $table) {
            $table->id();
            $table->string('content_type');
            $table->string('file_type');
            $table->text('caption')->nullable();
            $table->string('file')->nullable();
            $table->integer('asset_status_id');
            $table->boolean('caption_approved')->default(0);
            $table->boolean('file_approved')->default(0);
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::table('assets', function (Blueprint $table)
        {
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('campaign_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('campaign_id')->references('id')->on('campaigns');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('assets');
    }
}

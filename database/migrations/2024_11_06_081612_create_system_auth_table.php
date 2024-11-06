<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('system_auth', function (Blueprint $table) {
            $table->integer('id', true, true);
            $table->string('title', 20)->comment("权限名称")->nullable(false)->default('');
            $table->integer('sort', false)->comment("排序")->unique()->nullable()->default(0);
            $table->tinyInteger('status', false, true)->comment("状态(1:禁用,2:启用)")->nullable()->default(1);
            $table->string('remark', 255)->comment("备注说明")->nullable()->default(null);
            $table->integer('create_time', false, true)->comment("创建时间")->nullable()->default(null);
            $table->integer('update_time', false, true)->comment("更新时间")->nullable()->default(null);
            $table->integer('delete_time', false, true)->comment("删除时间")->nullable()->default(null);
            $table->charset = "utf8mb4";
            $table->collation = "utf8mb4_general_ci";
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('system_auth');
    }
};

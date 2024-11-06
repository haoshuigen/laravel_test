<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('system_admin', function (Blueprint $table) {
            $table->integer('id', true, true);
            $table->string('auth_ids', 255)->comment("角色权限ID")->nullable()->default(null);
            $table->string('head_img', 255)->comment("头像")->nullable()->default(null);
            $table->string('username', 20)->unique()->comment("用户登录名")->nullable(false)->default("");
            $table->char('password', 40)->comment("用户登录密码")->nullable(false)->default("");
            $table->string('phone', 11)->unique()->comment("联系手机号")->nullable()->default(null);
            $table->string('remark', 255)->comment("备注说明")->nullable()->default("");
            $table->integer('login_num', false, true)->comment("登录次数")->nullable()->default(0);
            $table->integer('sort', false)->comment("排序")->nullable()->default(0);
            $table->tinyInteger('status', false, true)->comment("状态(0:禁用,1:启用)")->nullable(false)->default(1);
            $table->integer('create_time', false, true)->comment("创建时间")->nullable(true)->default(null);
            $table->integer('update_time', false, true)->comment("更新时间")->nullable(true)->default(null);
            $table->integer('delete_time', false, true)->comment("删除时间")->nullable(true)->default(null);
            $table->charset = "utf8mb4";
            $table->collation = "utf8mb4_general_ci";
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('system_admin');
    }
};

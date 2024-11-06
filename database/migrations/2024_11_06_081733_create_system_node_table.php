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
        Schema::create('system_node', function (Blueprint $table) {
            $table->integer('id', true)->unsigned();
            $table->string('node', 100)->comment("节点代码")->nullable()->index('node')->default(null);
            $table->string('title', 500)->comment("节点标题")->nullable()->default(null);
            $table->tinyInteger('type')->comment("节点类型（1：控制器，2：节点）")->nullable()->default(3);
            $table->tinyInteger('is_auth', false, true)->comment("是否启动RBAC权限控制")->nullable()->default(1);
            $table->integer('create_time', false, true)->comment("创建时间")->nullable()->default(null);
            $table->integer('update_time', false, true)->comment("更新时间")->nullable()->default(null);
            $table->charset = "utf8mb4";
            $table->collation = "utf8mb4_general_ci";
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('system_node');
    }
};

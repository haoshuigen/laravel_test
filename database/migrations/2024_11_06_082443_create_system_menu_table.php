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
        /*       CREATE TABLE `test_system_menu` (
           `id` bigint(20) UNSIGNED NOT NULL,
         `pid` bigint(20) UNSIGNED NOT NULL DEFAULT '0' COMMENT '父id',
         `title` varchar(100) NOT NULL DEFAULT '' COMMENT '名称',
         `icon` varchar(100) NOT NULL DEFAULT '' COMMENT '菜单图标',
         `href` varchar(100) NOT NULL DEFAULT '' COMMENT '链接',
         `params` varchar(500) DEFAULT '' COMMENT '链接参数',
         `target` varchar(20) NOT NULL DEFAULT '_self' COMMENT '链接打开方式',
         `sort` int(11) DEFAULT '0' COMMENT '菜单排序',
         `status` tinyint(1) UNSIGNED NOT NULL DEFAULT '1' COMMENT '状态(0:禁用,1:启用)',
         `remark` varchar(255) DEFAULT NULL,
         `create_time` int(11) DEFAULT NULL COMMENT '创建时间',
         `update_time` int(11) DEFAULT NULL COMMENT '更新时间',
         `delete_time` int(11) DEFAULT NULL COMMENT '删除时间'
       ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='系统菜单表' ROW_FORMAT=COMPACT;*/

        Schema::create('system_menu', function (Blueprint $table) {
            $table->integer('id', true, true);
            $table->integer('pid', false, true)->comment('父id')->nullable(false)->default(0);
            $table->string('title', 100)->comment('名称')->nullable(false)->default('');
            $table->string('icon', 100)->comment('菜单图标')->nullable(false)->default('');
            $table->string('href', 100)->comment('链接')->nullable(false)->default('');
            $table->string('params', 500)->comment('链接参数')->nullable()->default('');
            $table->string('target', 20)->comment('链接打开方式')->nullable(false)->default('_self');
            $table->integer('sort')->comment('菜单排序')->nullable()->default(0);
            $table->tinyInteger('status', false, true)->comment('状态(0:禁用,1:启用)')->nullable(false)->default(1);
            $table->string('remark', 255)->comment('备注')->nullable(false)->default(null);
            $table->integer('create_time', false, true)->comment('创建时间')->nullable()->default(null);
            $table->integer('update_time', false, true)->comment('更新时间')->nullable()->default(null);
            $table->integer('delete_time', false, true)->comment('删除时间')->nullable()->default(null);

            $table->charset = 'utf8mb4';
            $table->collation = "utf8mb4_general_ci";
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('system_menu');
    }
};

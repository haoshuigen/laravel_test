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
        Schema::create('system_auth_node', function (Blueprint $table) {
            $table->integer('id', true, true);
            $table->integer('auth_id',false,true)->nullable()->comment("角色ID")->default(null)->index("index_system_auth_auth");
            $table->integer('node_id', false, true)->nullable()->comment("节点ID")->default(null)->index("index_system_auth_node");
            $table->charset = "utf8mb4";
            $table->collation = "utf8mb4_general_ci";
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('system_auth_node');
    }
};

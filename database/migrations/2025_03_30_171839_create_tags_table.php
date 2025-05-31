<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tag', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->string('description');
            $table->bigInteger('action_user');
            $table->longText('reason');
            $table->enum('status', ['accept', 'inactive', 'reject', 'request']);
            $table->timestamps();

            $table->foreign('action_user')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::create('tag_log', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('tag_id')->unsigned();
            $table->string('code');
            $table->string('description');
            $table->bigInteger('action_user');
            $table->longText('reason');
            $table->string('status');
            $table->timestamp('updated_at');


            $table->foreign('tag_id')->references('id')->on('tag')->onDelete('cascade');
        });

        // Membuat fungsi untuk trigger INSERT
        DB::unprepared('CREATE OR REPLACE FUNCTION log_tag_insert() RETURNS TRIGGER AS $$
            BEGIN
                INSERT INTO tag_log (tag_id, code, description, action_user, reason, status, updated_at)
                VALUES (NEW.id, NEW.code, NEW.description, NEW.action_user, NEW.reason, NEW.status, NEW.updated_at);
                RETURN NEW;
            END;
        $$ LANGUAGE plpgsql;');

        // Membuat trigger setelah INSERT
        DB::unprepared('CREATE TRIGGER trigger_insert_tag_log
            AFTER INSERT ON tag
            FOR EACH ROW
            EXECUTE FUNCTION log_tag_insert();');

        // Membuat fungsi untuk trigger UPDATE
        DB::unprepared('CREATE OR REPLACE FUNCTION log_tag_update() RETURNS TRIGGER AS $$
            BEGIN
                INSERT INTO tag_log (tag_id, code, NEW.description, action_user, reason, status, updated_at)
                VALUES (NEW.id, NEW.code, NEW.description, NEW.action_user, NEW.reason, NEW.status, NEW.updated_at);
                RETURN NEW;
            END;
        $$ LANGUAGE plpgsql;');

        // Membuat trigger setelah UPDATE
        DB::unprepared('CREATE TRIGGER trigger_update_tag_log
            AFTER UPDATE ON tag
            FOR EACH ROW
            EXECUTE FUNCTION log_tag_update();');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP TRIGGER IF EXISTS trigger_insert_tag_log ON tag;');
        DB::unprepared('DROP FUNCTION IF EXISTS log_tag_insert();');
        DB::unprepared('DROP TRIGGER IF EXISTS trigger_update_tag_log ON tag;');
        DB::unprepared('DROP FUNCTION IF EXISTS log_tag_update();');
        Schema::dropIfExists('tag_log');
        Schema::dropIfExists('tag');
    }
};

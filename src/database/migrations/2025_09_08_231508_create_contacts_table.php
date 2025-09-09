<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->id(); // id bigint unsigned, PRIMARY KEY, AUTO_INCREMENT
            $table->foreignId('category_id')->constrained('categories'); // category_id bigint unsigned, FOREIGN KEY categories(id)
            $table->string('first_name'); // varchar(255), NOT NULL
            $table->string('last_name');  // varchar(255), NOT NULL
            $table->tinyInteger('gender'); // tinyint, NOT NULL (1:男性, 2:女性, 3:その他)
            $table->string('email'); // varchar(255), NOT NULL
            $table->string('tel');   // varchar(255), NOT NULL
            $table->string('address'); // varchar(255), NOT NULL
            $table->string('building')->nullable(); // varchar(255), NULL
            $table->text('detail'); // text, NOT NULL
            $table->timestamps(); // created_at & updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contacts');
    }
}

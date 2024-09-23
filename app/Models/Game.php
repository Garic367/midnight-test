<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{


    public function up()
    {
        Schema::create('games', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('link');
            $table->string('genres')->nullable();
            $table->date('release_date')->nullable();
            $table->string('publisher')->nullable();
            $table->integer('us_position')->nullable();
            $table->integer('gb_position')->nullable();
            $table->integer('de_position')->nullable();
            $table->integer('jp_position')->nullable();
            $table->integer('reviews_count')->nullable();
            $table->decimal('average_rating', 3, 2)->nullable();
            $table->decimal('price', 8, 2)->nullable();
            $table->timestamps();
        });
    }

}

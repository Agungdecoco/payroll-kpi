<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onUpdate('cascade');
            $table->text('tunjangan');
            $table->foreignId('tax_id')->constrained()->onUpdate('cascade');
            $table->integer('bpjs_tk');
            $table->integer('bpjs_jp');
            $table->integer('bpjs_Kes');
            $table->float('skor_kedisiplinan');
            $table->float('skor_sikap');
            $table->float('skor_kesehatan');
            $table->integer('salary_per_hour');
            $table->integer('deduction_total');
            $table->integer('salary_total');
            $table->integer('absent_total');
            $table->timestamp('date');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}

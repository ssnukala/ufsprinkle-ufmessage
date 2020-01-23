<?php

/**
 * SN DB Forms (http://www.srinivasnukala.com)
 *
 * @link      https://github.com/ssnukala/ufsprinkle-ufmessage/
 * @copyright Copyright (c) 2013-2016 Srinivas Nukala
 */

namespace UserFrosting\Sprinkle\UfMessage\Database\Migrations\v430;

use Illuminate\Database\Schema\Blueprint;
use UserFrosting\Sprinkle\Core\Database\Migration;

/**
 * Formfields table migration
 * Version 4.0.0
 *
 * See https://laravel.com/docs/5.4/migrations#tables
 * @extends Migration
 * @author Srinivas Nukala (https://srinivasnukala.com)
 */
class UfMessageTable extends Migration
{
    /**
     * {@inheritDoc}
     */
    public static $dependencies = [];

    public function up()
    {
        //'message_date', 'message_event', 'subject', 'from', 'to', 'cc', 'message', 'attachment', 'status'
        if (!$this->schema->hasTable('uf_message')) {
            $this->schema->create('uf_message', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('user_id')->unsigned()->nullable();
                $table->dateTime('message_date')->nullable();
                $table->dateTime('expire_date')->nullable();
                $table->char('type', 1)->nullable();
                $table->string('event', 256)->nullable();
                $table->string('subject', 256)->nullable();
                $table->string('from', 500)->nullable();
                $table->string('to', 500)->nullable();
                $table->string('cc', 1000)->nullable();
                $table->string('bcc', 500)->nullable();
                $table->text('body')->nullable();
                $table->string('attachment', 255)->nullable();
                $table->char('visible', 1)->default('Y');
                $table->char('notification', 1)->default('N');
                $table->char('status', 1)->default('A');
                $table->string('created_by', 20)->nullable();
                $table->string('updated_by', 20)->nullable();
                $table->timestamps();
                $table->softDeletes();

                $table->engine = 'InnoDB';
                $table->collation = 'utf8_unicode_ci';
                $table->charset = 'utf8';
                $table->foreign('user_id')->references('id')->on('users');
            });
        }
    }

    /**
     * {@inheritDoc}
     */
    public function down()
    {
        $this->schema->drop('uf_message');
    }
}

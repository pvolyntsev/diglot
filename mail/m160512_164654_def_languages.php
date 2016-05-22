<?php

use yii\db\Migration;

class m160512_164654_def_languages extends Migration
{
    public function up()
    {
        $this->insert('language', [
            'id' => 1,
            'language' => 'english',
        ]);
        $this->insert('language', [
            'id' => 2,
            'language' => 'russian',
        ]);
    }

    public function down()
    {
        $this->delete('language', [
            'id' => 1,
        ]);
        $this->delete('language', [
            'id' => 2,
        ]);
        return true;
    }
}

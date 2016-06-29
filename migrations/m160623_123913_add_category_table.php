<?php

use yii\db\Migration;
use app\models\Category;

class m160623_123913_add_category_table extends Migration
{	
	// Use safeUp/safeDown to run migration code within a transaction
	public function safeUp()
    {
		$this->insert('category', [
            'id' => 1,
            'category' => 'Design',
		]);
		$this->insert('category', [
            'id' => 2,
            'category' => 'Development',
		]);
		$this->insert('category', [
            'id' => 3,
            'category' => 'User Interface (UI)',
		]);
		$this->insert('category', [
            'id' => 4,
            'category' => 'Startups',
		]);
		$this->insert('category', [
            'id' => 5,
            'category' => 'Management',
		]);
		$this->insert('category', [
            'id' => 6,
            'category' => 'Time Management',
		]);
		$this->insert('category', [
            'id' => 7,
            'category' => 'Marketing',
		]);
		$this->insert('category', [
            'id' => 8,
            'category' => 'Web Analytics',
		]);
		$this->insert('category', [
            'id' => 9,
            'category' => 'Productivity',
		]);
		$this->insert('category', [
            'id' => 10,
            'category' => 'User Experience (UX)',
		]);
		$this->insert('category', [
            'id' => 11,
            'category' => 'Growth Hack',
		]);
		$this->insert('category', [
            'id' => 12,
            'category' => 'Mobile',
		]);
		$this->insert('category', [
            'id' => 13,
            'category' => 'Web Development',
		]);
    }

    public function safeDown()
    {
		$this->delete('category', ['id' => 13]);
		$this->delete('category', ['id' => 12]);
		$this->delete('category', ['id' => 11]);
		$this->delete('category', ['id' => 10]);
		$this->delete('category', ['id' => 9]);
		$this->delete('category', ['id' => 8]);
		$this->delete('category', ['id' => 7]);
        $this->delete('category', ['id' => 6]);
        $this->delete('category', ['id' => 5]);
        $this->delete('category', ['id' => 4]);
        $this->delete('category', ['id' => 3]);
        $this->delete('category', ['id' => 2]);
        $this->delete('category', ['id' => 1]);
    }
}


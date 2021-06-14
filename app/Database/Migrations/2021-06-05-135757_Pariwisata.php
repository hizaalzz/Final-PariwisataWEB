<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Pariwisata extends Migration
{
	public function up()
	{
		$this->db->enableForeignKeyChecks();
		$this->forge->addField([
				'id' => [
					'type'				=> 'INT',
					'constraint'		=> 11,
					'unsigned'			=> TRUE,
					'auto_increment'	=> TRUE
				],
				'nama_pariwisata' => [
					'type'				=> 'VARCHAR',
					'constraint'		=> 50,
				],
				'harga' => [
					'type'				=> 'INT',
					'constraint'		=> 20,
				],
				'deskripsi' => [
					'type'				=> 'TEXT',
				],
				'gambar' => [
					'type'				=> 'TEXT',
				],
				'status' => [
					'type'				=> 'VARCHAR',
					'constraint'		=> 50,
				],
				'kategori' => [
					'type'				=> 'ENUM',
					'constraint'		=> ['0', '1'],
				],
				'created_at' => [
					'type'				=> 'DATETIME',
				],
				'updated_at' => [
					'type'				=> 'DATETIME',
				],
			]);
			$this->forge->addKey('id', TRUE);
			$this->forge->createTable('pariwisata');
	}

	public function down()
	{
		$this->forge->dropTable('pariwisata');
	}
}
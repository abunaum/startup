<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Migrate1 extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'id'               => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
			'email'            => ['type' => 'varchar', 'constraint' => 255],
			'username'         => ['type' => 'varchar', 'constraint' => 30, 'null' => true],
			'fullname'         => ['type' => 'varchar', 'constraint' => 30, 'null' => true],
			'user_image'       => ['type' => 'varchar', 'constraint' => 30, 'default' => 'default.svg'],
			'status_toko'      => ['type' => 'tinyint', 'constraint' => 2, 'null' => 0, 'default' => 0],
			'balance'			=> ['type' => 'bigint', 'constraint' => 255, 'null' => 0, 'default' => 0],
			'teleid'    => ['type' => 'varchar', 'constraint' => 14],
			'telecode'    => ['type' => 'varchar', 'constraint' => 32],
			'password_hash'    => ['type' => 'varchar', 'constraint' => 255],
			'reset_hash'       => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
			'reset_at'         => ['type' => 'datetime', 'null' => true],
			'reset_expires'    => ['type' => 'datetime', 'null' => true],
			'activate_hash'    => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
			'status'           => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
			'status_message'   => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
			'active'           => ['type' => 'tinyint', 'constraint' => 1, 'null' => 0, 'default' => 0],
			'force_pass_reset' => ['type' => 'tinyint', 'constraint' => 1, 'null' => 0, 'default' => 0],
			'created_at'       => ['type' => 'datetime', 'null' => true],
			'updated_at'       => ['type' => 'datetime', 'null' => true],
			'deleted_at'       => ['type' => 'datetime', 'null' => true],
		]);

		$this->forge->addKey('id', true);
		$this->forge->addUniqueKey('email');
		$this->forge->addUniqueKey('username');

		$this->forge->createTable('users', true);
		/*
         * Auth Login Attempts
         */
		$this->forge->addField([
			'id'         => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
			'ip_address' => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
			'email'      => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
			'user_id'    => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'null' => true], // Only for successful logins
			'date'       => ['type' => 'datetime'],
			'success'    => ['type' => 'tinyint', 'constraint' => 1],
		]);
		$this->forge->addKey('id', true);
		$this->forge->addKey('email');
		$this->forge->addKey('user_id');
		// NOTE: Do NOT delete the user_id or email when the user is deleted for security audits
		$this->forge->createTable('auth_logins', true);

		/*
         * Auth Tokens
         * @see https://paragonie.com/blog/2015/04/secure-authentication-php-with-long-term-persistence
         */
		$this->forge->addField([
			'id'              => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
			'selector'        => ['type' => 'varchar', 'constraint' => 255],
			'hashedValidator' => ['type' => 'varchar', 'constraint' => 255],
			'user_id'         => ['type' => 'int', 'constraint' => 11, 'unsigned' => true],
			'expires'         => ['type' => 'datetime'],
		]);
		$this->forge->addKey('id', true);
		$this->forge->addKey('selector');
		$this->forge->addForeignKey('user_id', 'users', 'id', false, 'CASCADE');
		$this->forge->createTable('auth_tokens', true);

		/*
         * Password Reset Table
         */
		$this->forge->addField([
			'id'         => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
			'email'      => ['type' => 'varchar', 'constraint' => 255],
			'ip_address' => ['type' => 'varchar', 'constraint' => 255],
			'user_agent' => ['type' => 'varchar', 'constraint' => 255],
			'token'      => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
			'created_at' => ['type' => 'datetime', 'null' => false],
		]);
		$this->forge->addKey('id', true);
		$this->forge->createTable('auth_reset_attempts');

		/*
         * Activation Attempts Table
         */
		$this->forge->addField([
			'id'         => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
			'ip_address' => ['type' => 'varchar', 'constraint' => 255],
			'user_agent' => ['type' => 'varchar', 'constraint' => 255],
			'token'      => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
			'created_at' => ['type' => 'datetime', 'null' => false],
		]);
		$this->forge->addKey('id', true);
		$this->forge->createTable('auth_activation_attempts');

		/*
         * Groups Table
         */
		$fields = [
			'id'          => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
			'name'        => ['type' => 'varchar', 'constraint' => 255],
			'description' => ['type' => 'varchar', 'constraint' => 255],
		];

		$this->forge->addField($fields);
		$this->forge->addKey('id', true);
		$this->forge->createTable('auth_groups', true);

		/*
         * Permissions Table
         */
		$fields = [
			'id'          => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
			'name'        => ['type' => 'varchar', 'constraint' => 255],
			'description' => ['type' => 'varchar', 'constraint' => 255],
		];

		$this->forge->addField($fields);
		$this->forge->addKey('id', true);
		$this->forge->createTable('auth_permissions', true);

		/*
         * Groups/Permissions Table
         */
		$fields = [
			'group_id'      => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
			'permission_id' => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
		];

		$this->forge->addField($fields);
		$this->forge->addKey(['group_id', 'permission_id']);
		$this->forge->addForeignKey('group_id', 'auth_groups', 'id', false, 'CASCADE');
		$this->forge->addForeignKey('permission_id', 'auth_permissions', 'id', false, 'CASCADE');
		$this->forge->createTable('auth_groups_permissions', true);

		/*
         * Users/Groups Table
         */
		$fields = [
			'group_id' => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
			'user_id'  => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
		];

		$this->forge->addField($fields);
		$this->forge->addKey(['group_id', 'user_id']);
		$this->forge->addForeignKey('group_id', 'auth_groups', 'id', false, 'CASCADE');
		$this->forge->addForeignKey('user_id', 'users', 'id', false, 'CASCADE');
		$this->forge->createTable('auth_groups_users', true);

		/*
         * Users/Permissions Table
         */
		$fields = [
			'user_id'       => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
			'permission_id' => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
		];

		$this->forge->addField($fields);
		$this->forge->addKey(['user_id', 'permission_id']);
		$this->forge->addForeignKey('user_id', 'users', 'id', false, 'CASCADE');
		$this->forge->addForeignKey('permission_id', 'auth_permissions', 'id', false, 'CASCADE');
		$this->forge->createTable('auth_users_permissions');

		/*
         * Apipayment
         */
		$this->forge->addField([
			'id'				 => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
			'apikey'			 => ['type' => 'varchar', 'constraint' => 255],
			'apiprivatekey'      => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
			'urlpaymentchannel'  => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
			'urlfeekalkulator'   => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
			'urlcreatepayment'   => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
			'urldetailtransaksi' => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
			'kodemerchant'	     => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
			'callback'		     => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
			'created_at'         => ['type' => 'datetime', 'null' => true],
			'updated_at'         => ['type' => 'datetime', 'null' => true],
			'deleted_at'         => ['type' => 'datetime', 'null' => true],
		]);

		$this->forge->addKey('id', true);

		$this->forge->createTable('apipayment', true);

		/*
         * item
         */
		$this->forge->addField([
			'id'		=> ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
			'nama'	 	=> ['type' => 'varchar', 'constraint' => 255],
			'status'	=> ['type' => 'int', 'constraint' => 11,  'null' => 0, 'default' => 0],
			'sub'		=> ['type' => 'int', 'constraint' => 11,  'null' => 0, 'default' => 0],
			'created_at' => ['type' => 'datetime', 'null' => true],
			'updated_at' => ['type' => 'datetime', 'null' => true],
			'deleted_at' => ['type' => 'datetime', 'null' => true],
		]);

		$this->forge->addKey('id', true);

		$this->forge->createTable('item', true);

		/*
         * subitem
         */
		$this->forge->addField([
			'id'		=> ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
			'item'		=> ['type' => 'int', 'constraint' => 11,  'unsigned' => true, 'default' => 0],
			'nama'	 	=> ['type' => 'varchar', 'constraint' => 255],
			'status'	=> ['type' => 'int', 'constraint' => 11,  'null' => 0, 'default' => 0],
			'created_at' => ['type' => 'datetime', 'null' => true],
			'updated_at' => ['type' => 'datetime', 'null' => true],
			'deleted_at' => ['type' => 'datetime', 'null' => true],
		]);

		$this->forge->addKey('id', true);
		$this->forge->addForeignKey('item', 'item', 'id', false, 'CASCADE');
		$this->forge->createTable('sub_item', true);

		/*
         * toko
         */
		$this->forge->addField([
			'id'		=> ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
			'userid'		=> ['type' => 'int', 'constraint' => 11,  'unsigned' => true, 'default' => 0],
			'username'	 	=> ['type' => 'varchar', 'constraint' => 255],
			'logo'	 	=> ['type' => 'varchar', 'constraint' => 255],
			'selogan'	 	=> ['type' => 'varchar', 'constraint' => 255],
			'metode'	 	=> ['type' => 'varchar', 'constraint' => 255],
			'nama_rek'	 	=> ['type' => 'varchar', 'constraint' => 255],
			'no_rek'	 	=> ['type' => 'varchar', 'constraint' => 255],
			'kartu'	 	=> ['type' => 'varchar', 'constraint' => 255],
			'selfi'	 	=> ['type' => 'varchar', 'constraint' => 255],
			'status'	=> ['type' => 'int', 'constraint' => 11,  'null' => 0, 'default' => 0],
			'created_at' => ['type' => 'datetime', 'null' => true],
			'updated_at' => ['type' => 'datetime', 'null' => true],
			'deleted_at' => ['type' => 'datetime', 'null' => true],
		]);

		$this->forge->addKey('id', true);
		$this->forge->addForeignKey('userid', 'users', 'id', false, 'CASCADE');
		$this->forge->createTable('toko', true);

		/*
         * transaksi_saldo
         */
		$this->forge->addField([
			'id'		=> ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
			'owner'		=> ['type' => 'varchar', 'constraint' => 255],
			'jenis'	 	=> ['type' => 'varchar', 'constraint' => 30],
			'order_number'	 	=> ['type' => 'varchar', 'constraint' => 30],
			'nominal'	 	=> ['type' => 'varchar', 'constraint' => 30],
			'fee'	 	=> ['type' => 'int', 'constraint' => 30],
			'metode'	 	=> ['type' => 'varchar', 'constraint' => 50],
			'status'	 	=> ['type' => 'varchar', 'constraint' => 20],
			'reference'	 	=> ['type' => 'varchar', 'constraint' => 255],
			'created_at' => ['type' => 'datetime', 'null' => true],
			'updated_at' => ['type' => 'datetime', 'null' => true],
			'deleted_at' => ['type' => 'datetime', 'null' => true],
		]);

		$this->forge->addKey('id', true);
		$this->forge->addForeignKey('owner', 'users', 'username', false, 'CASCADE');
		$this->forge->createTable('transaksi_saldo', true);

		/*
         * produk
         */
		$this->forge->addField([
			'id'		=> ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
			'jenis'	 	=> ['type' => 'int', 'constraint' => 11, 'unsigned' => true],
			'owner'		=> ['type' => 'int', 'constraint' => 11, 'unsigned' => true],
			'gambar'	 	=> ['type' => 'varchar', 'constraint' => 255],
			'nama'	 	=> ['type' => 'varchar', 'constraint' => 255],
			'harga'	 	=> ['type' => 'int', 'constraint' => 11],
			'keterangan'	 	=> ['type' => 'varchar', 'constraint' => 255],
			'slug'	 	=> ['type' => 'varchar', 'constraint' => 255],
			'stok'	 	=> ['type' => 'int', 'constraint' => 11],
			'created_at' => ['type' => 'datetime', 'null' => true],
			'updated_at' => ['type' => 'datetime', 'null' => true],
			'deleted_at' => ['type' => 'datetime', 'null' => true],
		]);

		$this->forge->addKey('id', true);
		$this->forge->addForeignKey('jenis', 'sub_item', 'id', false, 'CASCADE');
		$this->forge->addForeignKey('owner', 'users', 'id', false, 'CASCADE');
		$this->forge->createTable('produk', true);

		/*
         * keranjang
         */
		$this->forge->addField([
			'id'		=> ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
			'buyer'	 	=> ['type' => 'int', 'constraint' => 11, 'unsigned' => true],
			'produk'	=> ['type' => 'int', 'constraint' => 11, 'unsigned' => true],
			'jumlah'	=> ['type' => 'int', 'constraint' => 11],
			'pesan'	 	=> ['type' => 'varchar', 'constraint' => 255],
			'invoice'	=> ['type' => 'varchar', 'constraint' => 255],
			'status'	=> ['type' => 'int', 'constraint' => 11],
			'created_at' => ['type' => 'datetime', 'null' => true],
			'updated_at' => ['type' => 'datetime', 'null' => true],
			'deleted_at' => ['type' => 'datetime', 'null' => true],
		]);

		$this->forge->addKey('id', true);
		$this->forge->addForeignKey('buyer', 'users', 'id', false, 'CASCADE');
		$this->forge->addForeignKey('produk', 'produk', 'id', false, 'CASCADE');
		$this->forge->createTable('keranjang', true);

		/*
         * invoice
         */
		$this->forge->addField([
			'id'		=> ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
			'kode'	 	=> ['type' => 'varchar', 'constraint' => 255],
			'channel'	 	=> ['type' => 'varchar', 'constraint' => 255],
			'nominal'	 	=> ['type' => 'int', 'constraint' => 255],
			'fee'	 	=> ['type' => 'int', 'constraint' => 255],
			'referensi'	 	=> ['type' => 'varchar', 'constraint' => 255],
			'status'	 	=> ['type' => 'varchar', 'constraint' => 255],
			'created_at' => ['type' => 'datetime', 'null' => true],
			'updated_at' => ['type' => 'datetime', 'null' => true],
			'deleted_at' => ['type' => 'datetime', 'null' => true],
		]);

		$this->forge->addKey('id', true);
		$this->forge->createTable('invoice', true);
	}

	public function down()
	{
		// drop constraints first to prevent errors
		if ($this->db->DBDriver != 'SQLite3') {
			$this->forge->dropForeignKey('auth_tokens', 'auth_tokens_user_id_foreign');
			$this->forge->dropForeignKey('auth_groups_permissions', 'auth_groups_permissions_group_id_foreign');
			$this->forge->dropForeignKey('auth_groups_permissions', 'auth_groups_permissions_permission_id_foreign');
			$this->forge->dropForeignKey('auth_groups_users', 'auth_groups_users_group_id_foreign');
			$this->forge->dropForeignKey('auth_groups_users', 'auth_groups_users_user_id_foreign');
			$this->forge->dropForeignKey('auth_users_permissions', 'auth_users_permissions_user_id_foreign');
			$this->forge->dropForeignKey('auth_users_permissions', 'auth_users_permissions_permission_id_foreign');
			$this->forge->dropForeignKey('subitem', 'subitem_item_foreign');
			$this->forge->dropForeignKey('toko', 'toko_userid_foreign');
			$this->forge->dropForeignKey('transaksi_saldo', 'transaksi_saldo_owner_foreign');
			$this->forge->dropForeignKey('produk', 'produk_jenis_foreign');
			$this->forge->dropForeignKey('produk', 'produk_owner_foreign');
			$this->forge->dropForeignKey('keranjang', 'keranjang_buyer_foreign');
			$this->forge->dropForeignKey('keranjang', 'keranjang_produk_foreign');
		}

		$this->forge->dropTable('users', true);
		$this->forge->dropTable('auth_logins', true);
		$this->forge->dropTable('auth_tokens', true);
		$this->forge->dropTable('auth_reset_attempts', true);
		$this->forge->dropTable('auth_activation_attempts', true);
		$this->forge->dropTable('auth_groups', true);
		$this->forge->dropTable('auth_permissions', true);
		$this->forge->dropTable('auth_groups_permissions', true);
		$this->forge->dropTable('auth_groups_users', true);
		$this->forge->dropTable('auth_users_permissions', true);
		$this->forge->dropTable('apipayment', true);
		$this->forge->dropTable('produk', true);
		$this->forge->dropTable('item', true);
		$this->forge->dropTable('subitem', true);
		$this->forge->dropTable('toko', true);
		$this->forge->dropTable('transaksi_saldo', true);
		$this->forge->dropTable('keranjang', true);
		$this->forge->dropTable('invoice', true);
	}
}

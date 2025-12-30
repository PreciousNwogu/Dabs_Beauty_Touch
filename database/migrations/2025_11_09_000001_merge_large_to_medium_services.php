<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

/**
 * Migration placeholder: MergeLargeToMediumServices
 *
 * This migration file was empty and caused the migrator to fail because the
 * expected class `MergeLargeToMediumServices` could not be found. Add a
 * minimal, idempotent migration class here so deployments won't break.
 *
 * IMPORTANT: If this migration was intended to perform data changes (merging
 * service rows), restore the original migration logic instead of this
 * placeholder. The placeholder intentionally performs no destructive actions.
 */
class MergeLargeToMediumServices extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * Idempotent no-op: the original migration content appears to be missing
	 * from the repository at deploy time. Applying a no-op prevents the
	 * Migrator from failing while preserving migration order.
	 *
	 * Replace this with the original migration logic if required.
	 *
	 * @return void
	 */
	public function up()
	{
		// Intentionally left blank — placeholder to satisfy migrator
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		// Intentionally left blank for safe rollback
	}
}


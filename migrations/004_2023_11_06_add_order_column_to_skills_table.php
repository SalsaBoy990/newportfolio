<?php

/* Create posts table */
return new class extends Model {
    public function up(): void
    {
        $this->exec("ALTER TABLE `skills` ADD COLUMN `order` INT NOT NULL DEFAULT 0 AFTER `bg_color`;");

    }

    public function down(): void
    {
        $this->exec("ALTER TABLE `skills` DROP COLUMN `order`;");
    }
};

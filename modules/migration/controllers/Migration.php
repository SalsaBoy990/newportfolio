<?php

class Migration extends Trongate
{
    const MIGRATIONS = 'migrations';

    public function __construct(?string $module_name = null)
    {
        if (strtolower(ENV) !== 'dev') {
            http_response_code(403); //forbidden
            echo "Migrations disabled since not in 'dev' mode.";
            die();
        }
        parent::__construct($module_name);
    }

    /**
     * Migration runner
     *
     * @param string $direction = 'up'|'down'
     *
     * @return void
     */
    public function run(string $direction): void
    {
        settype($direction, 'string');

        if ($direction === 'up') {
            if (!$this->_is_table_exists('migrations')) {
                // Create the migrations table to store migration records
                $this->_create_migrations_table();
            }
        }

        // Migration file list
        $migrations = array_filter(glob(__DIR__ . '/../../../migrations/*.php'));

        if (sizeof($migrations) > 0) {
            foreach ($migrations as $migration) {

                // Get the filename part
                $parts = explode('/', $migration);

                if (isset($parts)) {
                    $filename = $parts[count($parts) - 1];
                    $table_parts = explode('_', $filename);
                    $table = $table_parts[count($table_parts) - 2];

                    // Get the migration class
                    $run = require_once(__DIR__ . '/../../../migrations/' . $filename);

                    try {
                        if ($direction === 'up') {

                            $record = $this->model->get_where_custom('migration', $filename, '=', 'id',
                                self::MIGRATIONS, 1);

                            // Run migration
                            if (empty($record)) {
                                $run->up();
                                // Insert migration record
                                $this->_insert_migration($filename, 1);
                            } elseif ($record[0]->processed == 0) {
                                // Run migration
                                $run->up();
                                // update migration record
                                $this->_update_migration($filename, 1);
                            }

                        } elseif ($direction === 'down') {
                            // Reverse migration
                            $run->down();

                            // Update migration record
                            $this->_update_migration($filename, 0);
                        }
                    } catch (\Exception $ex) {
                        var_dump($ex);
                    }
                }
            }
        }
        echo 'OK';
    }


    /**
     * Check if table needs to be created (initially)
     *
     * @param string $table
     * @return bool
     */
    private function _is_table_exists(string $table): bool
    {
        $sql = "SHOW TABLES LIKE :table";
        $rows = $this->model->query_bind($sql, ['table' => $table], 'array');
        if (!isset($rows)) {
            return false;
        }

        return true;
    }


    /**
     * Insert migration record
     *
     * @param string $filename
     * @param int $is_processed
     *
     * @return void
     */
    private function _insert_migration(string $filename, int $is_processed): void
    {
        $this->model->insert([
            'migration' => $filename,
            'processed' => $is_processed,
        ], self::MIGRATIONS);
    }


    /**
     * Update migration record
     *
     * @param string $filename
     * @param int $is_processed
     *
     * @return void
     */
    private function _update_migration(string $filename, int $is_processed): void
    {
        $this->model->update_where('migration', $filename, [
            'processed' => $is_processed,
        ], self::MIGRATIONS);
    }


    /**
     * Creates the migrations table if it exists
     *
     * @return void
     */
    private function _create_migrations_table(): void
    {
        $this->model->exec(
            "CREATE TABLE IF NOT EXISTS `migrations` (
                `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
                `migration` varchar(255) NOT NULL,
                `processed` TINYINT DEFAULT 0,
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE 'utf8mb4_general_ci' AUTO_INCREMENT=1;"
        );
    }

}

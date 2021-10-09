<?php

declare(strict_types=1);

namespace App\Infra\Repository;

use PDO;

abstract class RepositoryTransaction
{
    protected PDO $pdo;

    public function beginTransaction(): void
    {
        if (! $this->pdo->inTransaction()) {
            $this->pdo->beginTransaction();
        }
    }

    public function commitTransaction(): void
    {
        if ($this->pdo->inTransaction()) {
            $this->pdo->commit();
        }
    }

    public function rollBackTransaction(): void
    {
        if ($this->pdo->inTransaction()) {
            $this->pdo->rollBack();
        }
    }
}

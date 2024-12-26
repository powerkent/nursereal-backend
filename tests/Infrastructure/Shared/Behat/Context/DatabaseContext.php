<?php

declare(strict_types=1);

namespace Nursery\Tests\Infrastructure\Shared\Behat\Context;

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\TableNode;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\DBAL\Exception;
use Doctrine\ORM\EntityManagerInterface;
use LogicException;
use Nursery\Domain\Shared\Model\Config;
use Ramsey\Uuid\Uuid;
use function implode;
use function in_array;
use function sprintf;
use function Zenstruck\Foundry\faker;

final class DatabaseContext implements Context
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {
    }

    /**
     * @BeforeScenario
     * @throws Exception
     */
    public function cleanDatabase(): void
    {
        (new ORMPurger($this->entityManager))->purge();
        $config = new Config(Uuid::uuid4(), Config::AGENT_LOGIN_WITH_PHONE, true);
        $this->entityManager->persist($config);
        $this->entityManager->flush();
    }


    /**
     * @Then /^the table (?<table>[^ ]+) has (?<count>\d+) entr(?:y|ies)$/
     * @throws Exception
     */
    public function theTableHasCountEntries(string $table, int $count = 0): void
    {
        $query = sprintf('SELECT COUNT(1) FROM %s', $table);

        $databaseCount = (int) $this->entityManager->getConnection()->executeQuery($query)->fetchOne();

        if ($count !== $databaseCount) {
            throw new LogicException(sprintf('%d "%s" entries found but %d expected.', $databaseCount, $table, $count));
        }
    }

    /**
     * @Given /^the table (?<table>[^ ]+) has the following values:$/
     * @Given /^the table (?<table>[^ ]+) has (?<count>\d+) rows with the following values:$/
     * @throws Exception
     * @throws \Exception
     */
    public function insertInTable(TableNode $nodes, string $table, int $count = 1): void
    {
        if ([] === $nodesTable = $nodes->getTable()) {
            throw new LogicException('The nodes table cannot be empty.');
        }

        for ($i = 0; $i < $count; ++$i) {
            $values = [];
            foreach ($nodesTable as $row) {
                [$column, $value, $type] = $row;

                if (in_array($type, ['string', 'text'], true)) {
                    $isText = 'text' === $type;
                    $values[] = sprintf(
                        ' %s = "%s"',
                        $column,
                        'fake' === $value ? faker()->text($isText ? 300 : 40) : $value,
                    );
                } elseif ('datetime' === $type) {
                    $values[] = sprintf(' %s = "%s"', $column, (new \DateTimeImmutable($value))->format('Y-m-d h:i:s'));
                } else {
                    $values[] = sprintf(' %s = %s', $column, $value);
                }
            }
            $sql = sprintf('INSERT INTO %s SET %s;', $table, implode(', ', $values));

            $this->entityManager->getConnection()->prepare($sql)->executeQuery();
        }
    }

    /**
     * @param TableNode<array> $nodes
     *
     * @Then /the table (?<table>[^ ]+) has (?<count>\d+) entr(?:y|ies) with the following values:/
     * @Then the table :table has no entry with the following values:
     *
     * @throws Exception
     */
    public function theTableHasCountEntriesWithValues(TableNode $nodes, string $table, int $count = 0): void
    {
        $query = sprintf('SELECT COUNT(1) FROM %s WHERE ', $table);

        $i = 0;
        $params = [];
        $query .= implode(' AND ', array_map(static function ($row) use (&$i, &$params) {
            [$key, $value] = $row;
            ++$i;
            if ('null' === $value) {
                return " $key IS NULL";
            }

            if ('not_null' === $value) {
                return " $key IS NOT NULL";
            }

            $params['value_'.$i] = $value;

            return " CAST($key AS CHAR) = :value_$i";
        }, $nodes->getTable()));

        $tableCount = (int) $this->entityManager->getConnection()->executeQuery($query, $params)->fetchOne();

        if ($count !== $tableCount) {
            throw new LogicException(sprintf('%d "%s" entries found but %s expected', $tableCount, $table, $count));
        }
    }
}

<?php

namespace App\Tests\Functional\Repository;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use App\Entity\Client;

class ClientRepositoryTest extends KernelTestCase
{

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $entityManager;

    protected function setUp(): void
    {
        $kernel = self::bootKernel();

        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();
    }

    public function testAddForNewRecordIntoTheDatabase()
    {
        $testRow = [
            'name' => 'Yoda',
            'height' => 66,
            'mass' => 13,
            'hair_color' => 'silver',
            'skin_color' => 'green',
            'eye_color' => 'black',
            'birth_year' => '896BBY',
            'gender' => 'male',
        ];

        $testClientQuery = Client::build($testRow);
        $repository = $this->entityManager->getRepository(Client::class);
        $repository->add($testClientQuery, true);
        $records = $repository->findAll();

        $this->assertCount(1, $records);
        $this->assertEquals($testRow['name'], $records[0]->getName());
        $this->assertEquals($testRow['height'], $records[0]->getHeight());
        $this->assertEquals($testRow['mass'], $records[0]->getMass());
        $this->assertEquals($testRow['hair_color'], $records[0]->getHairColor());
        $this->assertEquals($testRow['skin_color'], $records[0]->getSkinColor());
        $this->assertEquals($testRow['eye_color'], $records[0]->getEyeColor());
        $this->assertEquals($testRow['birth_year'], $records[0]->getBirthYear());
        $this->assertEquals($testRow['gender'], $records[0]->getGender());
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        $repository = $this->entityManager->getRepository(Client::class);
        $records = $repository->findAll();
        foreach ($records as $record) {
            $repository->remove($record, true);
        }

        $this->entityManager->close();
        $this->entityManager = null;
    }
}

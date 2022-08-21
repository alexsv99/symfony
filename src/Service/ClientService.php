<?php

namespace App\Service;

use App\Entity\Client;
use App\Infrastructure\Reader\DataFormat;
use App\Infrastructure\Reader\ReaderFactory;
use App\Repository\ClientRepository;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validation;
use Exception;

class ClientService
{
    private $repository;

    public function __construct(ClientRepository $repository) {
        $this->repository = $repository;
    }

    public function processFile(string $filePath): array
    {
        try {
            $dataFormat = new DataFormat();
            $type = $dataFormat->getType($filePath);

            $readerFactory = new ReaderFactory();
            $reader = $readerFactory->initialize($type);
            $data = $reader->getData($filePath);

            $this->validateRows($data);
            $this->saveRows($data);
        } catch (Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }

        return [
            'success' => true,
            'message' => 'Data uploaded successfully',
        ];
    }

    private function saveRows(array $data): void
    {
        foreach ($data as $row) {
            $client = Client::build($row);
            $this->repository->add($client, true);
        }
    }

    private function validateRows(array $data): void
    {
        $validator = Validation::createValidator();

        $constraints = new Assert\Collection([
            'name' => new Assert\Type('string'),
            'height' => new Assert\Type('int'),
            'mass' => new Assert\Type('int'),
            'hair_color' => new Assert\Type('string'),
            'skin_color' => new Assert\Type('string'),
            'eye_color' => new Assert\Type('string'),
            'birth_year' => new Assert\Type('string'),
            'gender' => new Assert\Type('string'),
        ]);

        foreach ($data as $row) {
            $violations = $validator->validate($row, $constraints);

            if ($violations->count() > 0) {
                throw new Exception('Incorrect data fields or values');
            }
        }
    }
}

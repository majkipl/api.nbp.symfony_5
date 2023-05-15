<?php

namespace App\Service;

use App\Entity\Currency;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Uid\Uuid;

class CurrencyManagerService
{


    /**
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(private EntityManagerInterface $entityManager) {}

    /**
     * @param array $currencyRates
     * @return void
     */
    public function updateCurrencyExchangeRates(array $currencyRates): void
    {
        foreach ($currencyRates as $currencyRate) {
            $currency = $this->entityManager->getRepository(Currency::class)->findOneBy(['currencyCode' => $currencyRate['code']]);

            if (!$currency) {
                $currency = new Currency();
                $currency->setUuid(Uuid::v4());
                $currency->setName($currencyRate['currency']);
                $currency->setCurrencyCode($currencyRate['code']);
            }

            $currency->setExchangeRate($currencyRate['mid']);

            $this->entityManager->persist($currency);
        }

        $this->entityManager->flush();
    }
}
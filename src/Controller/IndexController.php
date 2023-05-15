<?php

namespace App\Controller;

use App\Service\CurrencyApiService;
use App\Service\CurrencyManagerService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class IndexController extends AbstractController
{
    /**
     * @param CurrencyApiService $currencyApiService
     * @param CurrencyManagerService $currencyManagerService
     * @return Response
     * @throws ClientExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    #[Route('/', name: 'app_index')]
    public function index(CurrencyApiService $currencyApiService, CurrencyManagerService $currencyManagerService): Response
    {
        $currencyRates = $currencyApiService->getCurrentExchangeRates();
        $currencyManagerService->updateCurrencyExchangeRates($currencyRates);

        return $this->render('index/index.html.twig', [
            'controller_name' => 'IndexController',
        ]);
    }
}

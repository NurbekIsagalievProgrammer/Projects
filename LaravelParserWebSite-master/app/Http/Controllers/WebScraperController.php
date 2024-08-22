<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Symfony\Component\DomCrawler\Crawler;
use Illuminate\Support\Facades\DB;

class WebScraperController extends Controller
{
    private function getMaxPages($html)
    {
        try {
            $crawler = new Crawler($html);

            // Ищем элемент с классом "pager"
            $pagerElement = $crawler->filter('.pager');

            // Если элемент найден, извлекаем номер последней страницы
            if ($pagerElement->count() > 0) {
                $lastPageLink = $pagerElement->filter('ul li:last-child span a')->text();

                return (int)$lastPageLink;
            }

            // Если не удалось найти информацию, возвращаем 1
            return 1;
        } catch (\Exception $e) {
            return 1;
        }
    }

    public function scrape()
    {
        $baseUrl = 'https://kolesa.kz/cars/?userId=22683244';
        $client = Http::timeout(60);

        // Извлекаем заголовок страницы
        $response = $client->get($baseUrl);
        $crawler = new Crawler($response->body());
        $pageTitle = $crawler->filter('title')->text();

        // Определяем максимальное количество страниц
        $maxPages = $this->getMaxPages($response->body());

        // Извлекаем информацию о каждой машине на всех страницах
        $allCars = [];

        for ($currentPage = 1; $currentPage <= $maxPages; $currentPage++) {
            $url = $currentPage === 1 ? $baseUrl : $baseUrl . '&page=' . $currentPage;


            try {
                // Добавляем задержку в 1 секунду между запросами
                sleep(1);

                // Устанавливаем User-Agent
                $response = $client->withHeaders([
                    'User-Agent' => 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/112.0.0.0 Safari/537.36'
                ])->get($url);

                $crawler = new Crawler($response->body());
            } catch (\Exception $e) {
                // Обрабатываем ошибку
                break;
            }

            // Проверяем наличие элементов на текущей странице
            $carNodes = $crawler->filter('.js__a-card');

            if ($carNodes->count() === 0) {
                break; // Если нет элементов на странице, выходим из цикла
            }

            // Извлекаем информацию о каждой машине на текущей странице
            $carsOnPage = $carNodes->each(function ($node) {
                $carMakeCrawler = $node->filter('.a-card__title a')->first();
                $carPriceCrawler = $node->filter('.a-card__price')->first();
                $carDescriptionCrawler = $node->filter('.a-card__description')->first();

                $carMake = $carMakeCrawler->count() > 0 ? $carMakeCrawler->text() : 'N/A';
                $carPrice = $carPriceCrawler->count() > 0 ? $carPriceCrawler->text() : 'N/A';
                $carDescription = $carDescriptionCrawler->count() > 0 ? $carDescriptionCrawler->text() : 'N/A';

                return [
                    'make' => $carMake,
                    'price' => $carPrice,
                    'description' => $carDescription,
                ];
            });


            // Объединяем данные с текущей страницы с общим массивом
            $allCars = array_merge($allCars, $carsOnPage);
        }

        // Удаляем старые записи перед вставкой новых данных
        DB::table('cars')->truncate();

        // Вставляем данные в базу данных
        foreach ($allCars as $car) {
            DB::table('cars')->insert([
                'make' => $car['make'],
                'price' => $car['price'],
                'description' => $car['description'],
            ]);
        }

        return view('welcome', compact('pageTitle', 'allCars'));
    }
}

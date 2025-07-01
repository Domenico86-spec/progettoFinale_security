<?php

namespace App\Livewire;

use GuzzleHttp\Client;
use Livewire\Component;
use App\Services\HttpService;

class LatestNews extends Component
{
    public $selectedCountry;
    public $selectedApi;
    public $news;
    protected $httpService;


    protected $apis = [
        'it' => 'https://newsapi.org/v2/top-headlines?country=it&apiKey=5fbe92849d5648eabcbe072a1cf91473',
        'gb' => 'https://newsapi.org/v2/top-headlines?country=gb&apiKey=5fbe92849d5648eabcbe072a1cf91473',
        'us' => 'https://newsapi.org/v2/top-headlines?country=us&apiKey=5fbe92849d5648eabcbe072a1cf91473',
    ];

    public function __construct()
    {
        $this->httpService = app(HttpService::class);
    }

    public function fetchNews()
    {
             if (!isset($this->apis[$this->selectedCountry])) {
            $this->news = ['error' => 'Invalid country selection'];
            return;
        }

        $url = $this->apis[$this->selectedCountry];
        $this->news = json_decode($this->httpService->getRequest($url), true);

    }
    public function render()
    {
        return view('livewire.latest-news');
    }
}

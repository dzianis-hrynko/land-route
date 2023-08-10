<?php

declare(strict_types=1);

namespace App\Client;

use App\Exception\CountryClientException;
use App\Mapper\CountryDtoMapper;
use Symfony\Component\Config\Definition\Exception\InvalidTypeException;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

final class CountryClient implements CountryClientInterface
{
    private HttpClientInterface $client;

    public function __construct(private readonly string $countryProviderUrl)
    {
        $this->client = HttpClient::create();
    }

    public function getCountyList(): array
    {
        try {
            $response = $this->client->request('GET', $this->countryProviderUrl);

            return CountryDtoMapper::mapList(json_decode($response->getContent(), true));
        } catch (
            TransportExceptionInterface
            | ClientExceptionInterface
            | RedirectionExceptionInterface $exception
        ) {
            throw new CountryClientException($exception->getMessage());
        }
    }
}

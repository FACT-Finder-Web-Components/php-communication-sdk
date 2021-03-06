<?php

declare(strict_types=1);

namespace spec\Omikron\FactFinder\Communication\Resource\Standard;

use Omikron\FactFinder\Communication\Client\ClientInterface;
use Omikron\FactFinder\Communication\Resource\Search;
use PhpSpec\ObjectBehavior;

class SearchAdapterSpec extends ObjectBehavior
{
    public function let(ClientInterface $client)
    {
        $this->beConstructedWith($client);
    }

    public function it_is_an_adapter()
    {
        $this->shouldHaveType(Search::class);
    }
}

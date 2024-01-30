<?php

namespace App\Tests\e2e\Context;

use App\Domain\Entity\Sorting;
use App\Infrastructure\Repository\SortingRepository;
use App\Kernel;
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use Behat\MinkExtension\Context\MinkContext;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertNotNull;

class SortingContext extends MinkContext implements Context
{
    private Response $response;
    private string $id = '';
    private Kernel $kernel;

    public function __construct(
        private readonly SortingRepository $sortingRepository
    ) {
        $this->kernel = new Kernel('test', true);
    }

    /**
     * @Given I am on the sorting page
     */
    public function iAmOnTheSortingPage(): void
    {
        $this->visit('/'); // Assuming the sorting page URL is '/'
    }

    /**
     * @Given /^I visit the sorting page without ID$/
     */
    public function iVisitTheSortingPageWithoutID(): void
    {
        $this->visit('/');
    }

    /**
     * @Given /^I send a POST request to "([^"]*)" with:$/
     */
    public function iSendAPOSTRequestToWith($url, PyStringNode $string): void
    {
        $request = Request::create(
            $url,
            'POST',
            [],
            [],
            [],
            [],
            $string->getRaw()
        );

        $this->response = $this->kernel->handle($request);
    }

    /**
     * @Given /^a sorting exists in the database with (.*) and (.*)$/
     */
    public function aSortingExistsInTheDatabaseWithIdAndAnd(string $data, string $dataHashed): void
    {
        $sorting = new Sorting();
        $sorting->setData($data);
        $sorting->setDataHash($dataHashed);
        $this->sortingRepository->save($sorting);

        $existent = $this->sortingRepository->getById($sorting->getId()->toRfc4122());
        assertNotNull($existent);
        $this->id = $sorting->getId()->toRfc4122();
    }

    /**
     * @When /^I visit the sorting page with ID$/
     */
    public function iVisitTheSortingPageWithEmptyID(): void
    {
        $this->visit("/$this->id");
    }

    /**
     * @Then /^the response should contain the sorting result (.*)$/
     */
    public function theResponseShouldContainTheSortingResult(string $expected): void
    {
        $content = $this->getSession()->getPage()->getContent();
        $dom = new \DOMDocument();
        $dom->loadHTML($content);
        $sortingData = $dom->getElementById('sorting_data');
        assertNotNull($sortingData);
        $sortingDataValue = $sortingData->getAttribute('value');
        assertEquals($expected, $sortingDataValue);
    }

    /**
     * @Then the response should contain a :key key
     */
    public function theResponseShouldContainAKey($key): void
    {
        $responseData = json_decode($this->response->getContent(), true);
        assert(array_key_exists($key, $responseData), "Expected response to contain the key '{$key}'.");
    }

    /**
     * @Then /^the response code should be (\d+)$/
     */
    public function theResponseCodeShouldBe(int $statusCode): void
    {
        assert($this->response->getStatusCode() === $statusCode, "Expected status code {$statusCode}, but got {$this->response->getStatusCode()}.");
    }
}

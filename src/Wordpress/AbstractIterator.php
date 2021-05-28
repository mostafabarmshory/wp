<?php
namespace Pluf\WP\Wordpress;

use GuzzleHttp\Client;
use Pluf\WP\SearchParams;
use Iterator;
use Pluf\WP\AssertTrait;
use Pluf\WP\CollectionInterface;

abstract class AbstractIterator implements Iterator
{
    use AssertTrait;

    public CollectionInterface $parent;

    public SearchParams $params;

    public int $currentPage = 0;

    public int $perPage;

    public int $index;

    public ?array $data;

    public $client;

    public bool $isValid;

    /**
     * Creats new instance of iterators
     *
     * @param PostCollection $parent
     * @param SearchParams $params
     */
    public function __construct(CollectionInterface $parent, SearchParams $params)
    {
        $this->params = $params;
        $this->parent = $parent;

        $this->client = new Client([
            // Base URI is used with relative requests
            'base_uri' => $parent->parent->url,
            // You can set any number of default request options.
            // 'timeout' => 2.0
            'cookies' => true,
            'headers' => [
                'accept-encoding' => 'gzip, deflate',
                'accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9',
                'user-agent' => 'Pluf/Bot/7.0 Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.150 Safari/537.36'
            ]
        ]);
        $this->rewind();
    }

    /**
     *
     * {@inheritdoc}
     * @see Iterator::next()
     */
    public function next()
    {
        if ($this->endOfPage()) {
            $this->loadNextPage();
        }
        $post = $this->current();
        $this->index ++;
        return $post;
    }

    /**
     *
     * {@inheritdoc}
     * @see Iterator::valid()
     */
    public function valid()
    {
        return $this->isValid && (! $this->endOfPage() || ! isset($this->data) || sizeof($this->data) == $this->perPage);
    }

    /**
     *
     * {@inheritdoc}
     * @see Iterator::current()
     */
    public function current()
    {
        $data = $this->data[$this->index];
        return $this->createNewInstance($data);
    }

    /**
     *
     * {@inheritdoc}
     * @see Iterator::rewind()
     */
    public function rewind()
    {
        $this->isValid = true;
        $this->currentPage = 0;
        $this->perPage = $this->params->perPage;
        $this->index = $this->params->perPage;
        $this->data = null;
    }

    /**
     *
     * {@inheritdoc}
     * @see Iterator::key()
     */
    public function key()
    {
        return $this->index + ($this->currentPage - 1) * $this->perPage;
    }

    /**
     * Check if this is the end of the page
     *
     * @return bool
     */
    private function endOfPage(): bool
    {
        return (! empty($this->data) && $this->index >= sizeof($this->data) - 1) || $this->index >= $this->perPage;
    }

    /**
     * Loads next page
     */
    private function loadNextPage(): void
    {
        $retry = 10;
        $count = 0;
        $error = null;
        $interval = 5;

        while ($count < $retry) {
            try {
                // Send a request to
                $response = $this->client->request('GET', $this->getApi(), [
                    'query' => [
                        'page' => $this->currentPage + 1,
                        'per_page' => $this->perPage
                    ]
                ]);

                if ($response->getStatusCode() >= 400) {
                    $this->isValie = false;
                }

                $this->assertTrue($response->getStatusCode() >= 200 && $response->getStatusCode() < 300, 'Fail to get response from {{url}}', [
                    'url' => $this->client->getConfig('base_uri')
                ]);
                $error = null;
                break;
            } catch (\Throwable $e) {
                $error = $e;
                $count ++;
                sleep($count * $interval);
                echo 'Retry to connect ' . PHP_EOL;
            }
        }

        if (isset($error)) {
            throw $error;
        }

        // on success
        $this->data = json_decode($response->getBody(), true);
        $this->currentPage ++;
        $this->index = 0;
    }

    protected abstract function createNewInstance($data);

    protected abstract function getApi(): string;
}


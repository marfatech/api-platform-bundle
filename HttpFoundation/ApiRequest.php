<?php

declare(strict_types=1);

namespace Wakeapp\Bundle\ApiPlatformBundle\HttpFoundation;

use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Request;

class ApiRequest extends Request
{
    /**
     * Request parameters from the content, which has been received as JSON.
     *
     * @var ParameterBag
     */
    public $body;

    /**
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        parent::__construct(
            $request->query->all(),
            $request->request->all(),
            $request->attributes->all(),
            $request->cookies->all(),
            $request->files->all(),
            $request->server->all(),
            $request->getContent()
        );
    }

    /**
     * {@inheritdoc}
     */
    public function __clone()
    {
        $this->body = clone $this->body;

        parent::__clone();
    }

    /**
     * {@inheritdoc}
     */
    public function get($key, $default = null)
    {
        if ($this !== $result = $this->body->get($key, $this)) {
            return $result;
        }

        return parent::get($key, $default);
    }

    /**
     * {@inheritdoc}
     */
    public function initialize(
        array $query = [],
        array $request = [],
        array $attributes = [],
        array $cookies = [],
        array $files = [],
        array $server = [],
        $content = null
    ): void {
        parent::initialize($query, $request, $attributes, $cookies, $files, $server, $content);

        $this->body = $this->createParameterBagFromJsonContent($content);
    }

    /**
     * @param array|null $query
     * @param array|null $request
     * @param array|null $attributes
     * @param array|null $cookies
     * @param array|null $files
     * @param array|null $server
     * @param null|string $content
     *
     * @return self
     */
    public function duplicate(
        ?array $query = null,
        ?array $request = null,
        ?array $attributes = null,
        ?array $cookies = null,
        ?array $files = null,
        ?array $server = null,
        ?string $content = null
    ): self {
        /** @var self $duplicate */
        $duplicate = parent::duplicate($query, $request, $attributes, $cookies, $files, $server);

        if (null !== $content) {
            $duplicate->body = $this->createParameterBagFromJsonContent($content);
        }

        return $duplicate;
    }

    /**
     * @param string|null $content
     *
     * @return ParameterBag
     */
    private function createParameterBagFromJsonContent(?string $content)
    {
        if (null === $content) {
            $content = [];
        }

        $data = json_decode($content, true);

        return new ParameterBag($data ?? []);
    }
}

<?php

class CurlRequest extends HttpRequestAbstract
{
    /**
     * @var CurlHandle|false
     */
    private CurlHandle|bool $handle;

    /**
     * @param string $url
     */
    public function __construct(public string $url)
    {
        $this->handle = curl_init($url);
    }

    /**
     * @param int $name
     * @param mixed $value
     * @return void
     */
    public function setOption(int $name, mixed $value): void
    {
        curl_setopt($this->handle, $name, $value);
    }

    /**
     * @return bool|string
     */
    public function execute(): bool|string
    {
        return curl_exec($this->handle);
    }

    /**
     * @return void
     */
    public function close(): void
    {
        curl_close($this->handle);
    }
}

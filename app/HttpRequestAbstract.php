<?php

abstract class HttpRequestAbstract
{
    /**
     * @var string
     */
    public string $url;

    /**
     * @param int $name
     * @param mixed $value
     * @return void
     */
    abstract public function setOption(int $name, mixed $value): void;

    /**
     * @return bool|string
     */
    abstract public function execute(): bool|string;

    /**
     * @return void
     */
    abstract public function close(): void;
}

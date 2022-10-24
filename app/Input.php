<?php

class Input
{
    /**
     * @param string $url
     */
    public function __construct(public string $url)
    {
    }

    /**
     * @return array
     */
    public function getInputData(): array
    {
        {
            $file = fopen($this->url, "r");
            $input = [];
            while (!feof($file)) {
                $content = fgets($file);
                if (!empty($content)) {
                    $input[] = json_decode($content);
                }
            }
            fclose($file);
            return $input;
        }
    }
}

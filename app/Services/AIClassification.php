<?php

namespace App\Services;


class AIClassification
{
    private $command = 'python3 app.py';
    private $path = '/Users/mariusz/Desktop/leadbrowser/app/packages/LeadBrowser/AIClassification';

    /**
     * Exec commmand
     * 
     * @param string $website
     * @return json
     */
    public function execCommand(string $website = '')
    {
        $command = 'cd ' . $this->path . ' && ' . $this->command . ' ' . $website;
        $output = exec($command);

        return json_decode($output, true);
    }
}
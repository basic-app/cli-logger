<?php

namespace BasicApp\ConsoleLogger;

use Psr\Log\LoggerTrait;
use Psr\Log\AbstractLogger;
use Psr\Log\LogLevel;
use CodeIgniter\CLI\CLI;

class ConsoleLogger extends AbstractLogger
{

    use LoggerTrait;

    public $debug = false;

    public function log($level, $message, array $context = [])
    {
        $replace = [];

        foreach($context as $key => $value)
        {
            if (!is_array($value))
            {
                $replace['{' . $key . '}'] = CLI::color($value, 'yellow');
            }
        }

        $message = strtr($message, $replace);

        switch ($level) {
            case LogLevel::EMERGENCY:
                
                $message = CLI::color('EMERGENCY:', 'red') . ' ' . $message;

                break;
            case LogLevel::ALERT:
                
                $message = CLI::color('ALERT:', 'red') . ' ' . $message;

                break;
            case LogLevel::CRITICAL:
                
                $message = CLI::color('CRITICAL:', 'red') . ' ' . $message;

                break;
            case LogLevel::ERROR:
                
                $message = CLI::color('ERROR:', 'red') . ' ' . $message;

                break;
            case LogLevel::WARNING:
                
                $message = CLI::color('WARNING:', 'yellow') . ' ' . $message;

                break;
            case LogLevel::NOTICE:
                
                $message = CLI::color('NOTICE:', 'yellow') . ' ' . $message; 

                break;
            case LogLevel::INFO:
                
                // nothing here
                
                break;
            case LogLevel::DEBUG:
                
                if (!$this->debug)
                {
                    return;
                }

                $message = CLI::color('DEBUG:', 'dark_gray') . ' ' . $message;

                break;
        }

        $segments = explode(': ', $message);

        if (count($segments) == 2)
        {
            $message = CLI::color($segments[0], 'green') . ': ' . $segments[1];
        }

        CLI::write($message);
    }

}
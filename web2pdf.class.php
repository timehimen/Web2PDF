<?php
/**
 * Web2PDF is a PHP wrapper for wkhtmltopdf. See wkhtmltopdf.org for details
 * Author: Timothy Ehimen
 * Email: tim@timothyehimen.com
 */

namespace Web2PDF;

require_once 'exceptions.class.php';

use Web2PDF\Exceptions\CommandFailedException;
use Web2PDF\Exceptions\CommandNotFoundException;

class Web2PDF {
    private $command, $url, $options, $output, $result;

    public function __construct(string $url) {
        $this->command = "";
        $this->url = $url;
        $this->options = [];
        $this->output = null;
        $this->result = null;
    }

    public function set_option(string $option, string $value = null): void {
        $this->options[$option] = $value;
    }

    public function exec(): self {
        $this->command = "wkhtmltopdf";

        foreach ($this->options as $option=>$value) {
            $this->command .= " --" . $option;

            if ($value != null) {
                $this->command .= " " . $value;
            }
        }

        $this->command .= " " . $this->url . " temp.pdf 2>&1"; //2>&1 added to redirect shell output to output array

        exec($this->command, $this->output, $this->result);

        if($this->get_result() == 127) {
            throw new CommandNotFoundException("Command not found. Check if wkhtmltopdf is installed.");
        }

        if($this->get_result() == 1) {
            throw new CommandFailedException("wkhtmltopdf command failed. Check output for more information");
        }

        return $this;
    }

    public function get_output(): string {
        $output = "";
        foreach ($this->output as $line) {
            $output .= $line . "\n";
        }
        return $output;
    }

    public function get_result(): int {
        return $this->result;
    }

    public function get_file(): string {
        if($this->get_result() == 0) {
            return "temp.pdf";
        }

        return "";
    }

}
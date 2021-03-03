<?php
namespace Web2PDF\Core;

/**
 * Web2PDF is a PHP wrapper for wkhtmltopdf. See wkhtmltopdf.org for details
 * Author: Timothy Ehimen
 * Email: tim@timothyehimen.com
 */

require_once 'exceptions.class.php';

class Web2PDF {
    private $command, $url, $options, $output, $result;

    public function __construct(string $url) {
        $this->command = "";
        $this->url = $url;
        $this->options = [];
        $this->output = null;
        $this->result = null;
    }

    public function set_option(string $option, string $value): void {
        $this->options[$option] = $value;
    }

    public function exec(): self {
        $this->command = "wkhtmltopdf";

        foreach ($this->options as $option=>$value) {
            $this->command .= " -- " . $option . " " . $value;
        }

        $this->command .= " " . $this->url . " temp.pdf 2>&1"; //2>&1 added to redirect shell output to output array

        exec($this->command, $this->output, $this->result);

        if($this->get_result() == 127) {
            throw new CommandNotFoundException($this->get_output());
        }

        if($this->get_result() == 1) {
            throw new CommandFailedException($this->get_output());
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
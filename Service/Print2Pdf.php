<?php

namespace Cravler\Print2PdfBundle\Service;

use Symfony\Component\Process\Process;

/**
 * @author Sergei Vizel <sergei.vizel@gmail.com>
 */
class Print2Pdf
{
    /**
     * @var string
     */
    private string $binary;

    /**
     * @var array
     */
    private array $options;

    /**
     * @var string
     */
    protected string $temporaryFolder;

    /**
     * Print2Pdf constructor.
     * @param string $binary
     * @param array $options
     * @param string|null $temporaryFolder
     */
    public function __construct(string $binary, array $options = array(), string $temporaryFolder = null)
    {
        $this->binary = $binary;
        $this->options = $options;
        $this->temporaryFolder = $temporaryFolder ?: sys_get_temp_dir();
    }

    /**
     * @param string $url
     * @param array $options
     * @return string
     */
    public function generate(string $url, array $options = array()): string
    {
        $allowed  = array_keys($this->options);
        $options = array_filter($options, fn ($key) => in_array($key, $allowed), ARRAY_FILTER_USE_KEY);

        $command = array(
            $this->binary,
        );
        foreach (array_merge($this->options, $options) as $key => $value) {
            $flag = '--' . str_replace('_', '-', $key);
            if (is_bool($value)) {
                if (true === $value) {
                    $command[] = $flag;
                }
            } else {
                $command[] = $flag;
                $command[] = $value;
            }
        }
        $command[] = $url;

        $process = new Process($command);

        $pdf = '';
        $err = '';
        $process->run(function ($type, $buffer) use (&$pdf, &$err) {
            if ('err' == $type) {
                $err .= $buffer;
            } else {
                $pdf .= $buffer;
            }
        });

        if ('' !== $err) {
            throw new \RuntimeException($err);
        }

        return $pdf;
    }

    /**
     * @param string $html
     * @param array $options
     * @return string
     * @throws \Exception
     */
    public function generateFromHtml(string $html, array $options = array()): string
    {
        $file = $this->createTemporaryFile($html, 'html');
        try {
            $pdf = $this->generate('file://' . $file, $options);
            @unlink($file);
            return $pdf;
        } catch (\Exception $e) {
            @unlink($file);
            throw $e;
        }
    }

    /**
     * @param string $content
     * @param string $extension
     * @return string
     */
    protected function createTemporaryFile(string $content, string $extension): string
    {
        $dir = rtrim($this->temporaryFolder, DIRECTORY_SEPARATOR);

        if (!is_dir($dir)) {
            if (false === @mkdir($dir, 0777, true) && !is_dir($dir)) {
                throw new \RuntimeException(sprintf('Unable to create directory: %s', $dir));
            }
        } else if (!is_writable($dir)) {
            throw new \RuntimeException(sprintf('Unable to write in directory: %s', $dir));
        }

        $filename = $dir . DIRECTORY_SEPARATOR . uniqid('print2pdf', true) . '.' . $extension;

        file_put_contents($filename, $content);

        return $filename;
    }
}
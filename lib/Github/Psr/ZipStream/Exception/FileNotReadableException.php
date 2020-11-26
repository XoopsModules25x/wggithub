<?php
declare(strict_types=1);

namespace PhpOffice\Psr\ZipStream\Exception;

use PhpOffice\Psr\ZipStream\Exception;

/**
 * This Exception gets invoked if a file wasn't found
 */
class FileNotReadableException extends Exception
{
    /**
     * Constructor of the Exception
     *
     * @param String $path - The path which wasn't found
     */
    public function __construct(string $path)
    {
        parent::__construct("The file with the path $path isn't readable.");
    }
}

<?php
/**
 * (c) Spryker Systems GmbH copyright protected
 */

namespace Spryker\Zed\Propel\Business\Model;

use Symfony\Component\Filesystem\Filesystem;

class PropelSchemaWriter implements PropelSchemaWriterInterface
{

    /**
     * @var \Symfony\Component\Filesystem\Filesystem
     */
    private $filesystem;

    /**
     * @var string
     */
    private $targetDirectory;

    /**
     * @param \Symfony\Component\Filesystem\Filesystem $filesystem
     * @param string $targetDirectory
     */
    public function __construct(Filesystem $filesystem, $targetDirectory)
    {
        $this->filesystem = $filesystem;
        $this->targetDirectory = $targetDirectory;
    }

    /**
     * @param string $fileName
     * @param string $content
     *
     * @return void
     */
    public function write($fileName, $content)
    {
        $this->filesystem->dumpFile(
            $this->targetDirectory . DIRECTORY_SEPARATOR . $fileName,
            $content
        );
    }

}
<?php

/*
 * This file is part of the Oryzone/MediaStorage package.
 *
 * (c) Luciano Mammino <lmammino@oryzone.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Oryzone\MediaStorage\Filesystem;


use League\Flysystem\Filesystem,
    Oryzone\MediaStorage\Exception\InvalidArgumentException,
    Oryzone\MediaStorage\Exception\InvalidConfigurationException;

/**
 * Factory for flysystem filesystems (to decouple the library from the symfony bundle for flysystem)
 */
class FilesystemFactory implements FilesystemFactoryInterface, \IteratorAggregate
{
    /**
     * Map of filesystems indexed by their name
     *
     * @var array
     */
    protected $map;

    /**
     * Instantiates a new filesystem map
     *
     * @param array $map
     */
    public function __construct(array $map)
    {
        $this->map = $map;
    }

    /**
     * {@inheritDoc}
     */
    public function get($filesystemName)
    {
        if (!isset($this->map[$filesystemName]))
            throw new InvalidArgumentException(sprintf('No filesystem register for name "%s"', $filesystemName));

        $filesystem = $this->map[$filesystemName];

        if(! $filesystem instanceof Filesystem)
            throw new InvalidConfigurationException(sprintf('The filesystem registered with the name "%s" is not an instance of "\League\Flysystem\Filesystem"', $filesystemName));

        return $filesystem;
    }

    /**
     * {@inheritDoc}
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->map);
    }
}

<?php

/*
 * This file is part of the Oryzone/MediaStorage package.
 *
 * (c) Luciano Mammino <lmammino@oryzone.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Oryzone\MediaStorage\Context;

use Oryzone\MediaStorage\Variant\VariantTree,
    Oryzone\MediaStorage\Variant\Variant,
    Oryzone\MediaStorage\Variant\VariantInterface;

class Context implements ContextInterface
{
    /**
     * @var string $name
     */
    protected $name;

    /**
     * @var string $providerName
     */
    protected $providerName;

    /**
     * @var array $providerOptions
     */
    protected $providerOptions;

    /**
     * @var string filesystemName
     */
    protected $filesystemName;

    /**
     * @var string $cdnName
     */
    protected $cdnName;

    /**
     * @var string $namingStrategyName
     */
    protected $namingStrategyName;

    /**
     * @var string $defaultVariant
     */
    protected $defaultVariant;

    /**
     * @var array $variants
     */
    protected $variants;

    /**
     * Used to cache the latest generated tree
     *
     * @var VariantTree $lastTree
     */
    private $lastTree;

    /**
     * Constructor
     *
     * @param string $name
     * @param string $providerName
     * @param array  $providerOptions
     * @param string $filesystemName
     * @param string $cdnName
     * @param string $namingStrategyName
     * @param array  $variants
     * @param string $defaultVariant
     */
    public function __construct($name, $providerName, $providerOptions, $filesystemName, $cdnName, $namingStrategyName, $variants = array(), $defaultVariant = 'default')
    {
        $this->cdnName = $cdnName;
        $this->filesystemName = $filesystemName;
        $this->name = $name;
        $this->providerName = $providerName;
        $this->providerOptions = $providerOptions;
        $this->namingStrategyName = $namingStrategyName;
        $this->variants = $variants;
        $this->defaultVariant = $defaultVariant;
    }

    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * {@inheritDoc}
     */
    public function getProviderName()
    {
        return $this->providerName;
    }

    /**
     * {@inheritDoc}
     */
    public function getProviderOptions()
    {
        return $this->providerOptions;
    }

    /**
     * {@inheritDoc}
     */
    public function getFilesystemName()
    {
        return $this->filesystemName;
    }

    /**
     * {@inheritDoc}
     */
    public function getCdnName()
    {
        return $this->cdnName;
    }

    /**
     * {@inheritDoc}
     */
    public function getNamingStrategyName()
    {
        return $this->namingStrategyName;
    }

    /**
     * {@inheritDoc}
     */
    public function getDefaultVariant()
    {
        return $this->defaultVariant;
    }

    /**
     * {@inheritDoc}
     */
    public function getVariants()
    {
        return $this->variants;
    }

    /**
     * {@inheritDoc}
     */
    public function hasVariant($variantName)
    {
        return array_key_exists($variantName, $this->variants);
    }

    /**
     * {@inheritDoc}
     */
    public function buildVariantTree()
    {
        if($this->lastTree)

            return $this->lastTree;

        $tree = new VariantTree();
        foreach ($this->variants as $name => $v) {
            //sets default values if any
            $mode = VariantInterface::MODE_INSTANT;
            if(isset($v['mode']))
                $mode = $v['mode'];

            $process = array();
            if(isset($v['process']))
                $process = $v['process'];

            $parent = NULL;
            if(isset($v['parent']))
                $parent = $v['parent'];

            //creates the variant instance
            $variant = new Variant();
            $variant->setName($name);
            $variant->setMode($mode);
            $variant->setOptions($process);
            $tree->add($variant, $parent);
        }

        $this->lastTree = $tree;

        return $tree;
    }
}

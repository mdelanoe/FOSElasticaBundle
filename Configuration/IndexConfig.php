<?php

/**
 * This file is part of the FOSElasticaBundle project.
 *
 * (c) Tim Nagel <tim@nagel.com.au>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FOS\ElasticaBundle\Configuration;

class IndexConfig
{
    /**
     * The name of the index for ElasticSearch.
     *
     * @var string
     */
    private $elasticSearchName;

    /**
     * The internal name of the index. May not be the same as the name used in ElasticSearch,
     * especially if aliases are enabled.
     *
     * @var string
     */
    private $name;

    /**
     * An array of settings sent to ElasticSearch when creating the index.
     *
     * @var array
     */
    private $settings;

    /**
     * All types that belong to this index.
     *
     * @var TypeConfig[]
     */
    private $types;

    /**
     * Indicates if the index should use an alias, allowing an index repopulation to occur
     * without overwriting the current index.
     *
     * @var bool
     */
    private $useAlias = false;

    /**
     * Constructor expects an array as generated by the Container Configuration builder.
     *
     * @param string $name
     * @param TypeConfig[] $types
     * @param array $config
     */
    public function __construct($name, array $types, array $config)
    {
        $this->elasticSearchName = isset($config['elasticSearchName']) ? $config['elasticSearchName'] : $name;
        $this->name = $name;
        $this->settings = isset($config['settings']) ? $config['settings'] : array();
        $this->types = $types;
        $this->useAlias = isset($config['useAlias']) ? $config['useAlias'] : false;
    }

    /**
     * @return string
     */
    public function getElasticSearchName()
    {
        return $this->elasticSearchName;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return array
     */
    public function getSettings()
    {
        return $this->settings;
    }

    /**
     * @param string $typeName
     * @return TypeConfig
     * @throws \InvalidArgumentException
     */
    public function getType($typeName)
    {
        if (!array_key_exists($typeName, $this->types)) {
            throw new \InvalidArgumentException(sprintf('Type "%s" does not exist on index "%s"', $typeName, $this->name));
        }

        return $this->types[$typeName];
    }

    /**
     * @return \FOS\ElasticaBundle\Configuration\TypeConfig[]
     */
    public function getTypes()
    {
        return $this->types;
    }

    /**
     * @return boolean
     */
    public function isUseAlias()
    {
        return $this->useAlias;
    }
}

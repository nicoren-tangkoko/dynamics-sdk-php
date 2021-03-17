<?php

/**
 * Copyright (c) Saint Systems, LLC.  All Rights Reserved.  Licensed under the MIT License.  See License in the project root for license information.
 * 
 * LanguageLocale File
 * PHP version 7
 *
 * @category  Library
 * @package   Microsoft.Dynamics
 * @copyright 2017 Saint Systems, LLC
 * @license   https://opensource.org/licenses/MIT MIT License
 * @version   GIT: 0.1.0
 * @link      https://www.microsoft.com/en-us/dynamics365/
 */

namespace Microsoft\Dynamics\Model;

use SaintSystems\OData\Entity;

/**
 * LanguageLocale class
 *
 * LanguageLocale entity
 *
 * @category  Model
 * @package   Microsoft.Dynamics
 * @license   https://opensource.org/licenses/MIT MIT License
 * @link      https://www.microsoft.com/en-us/dynamics365/
 */
class CustomObject extends Entity
{


    /**
     *
     * @param string $entity
     * @param string $primaryKey
     * @param array $properties
     */
    public function __construct(string $entity, string $primaryKey, $properties = array())
    {
        $this->entity = $entity;
        $this->$primaryKey = $primaryKey;
        parent::__construct($properties);
    }
}

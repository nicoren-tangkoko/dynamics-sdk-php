<?php

/**
 * Copyright (c) Saint Systems, LLC.  All Rights Reserved.  Licensed under the MIT License.  See License in the project root for license information.
 * 
 * SystemUser File
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
 * SystemUser class
 *
 * SystemUser entity
 *
 * @category  Model
 * @package   Microsoft.Dynamics
 * @license   https://opensource.org/licenses/MIT MIT License
 * @link      https://www.microsoft.com/en-us/dynamics365/
 */
class SystemUser extends Entity
{
    /**
     * The entity set name associated with the entity.
     * This is needed for API calls since this is the API endpoint for this Entity
     *
     * @var string
     */
    protected ?string $entity = 'systemusers';

    /**
     * The name of the attribute that is the primary id for the entity.
     * PrimaryIdAttribute from https://msdn.microsoft.com/en-us/library/mt607760.aspx
     *
     * @var string
     */
    protected ?string $primaryKey = 'systemuserid';
}

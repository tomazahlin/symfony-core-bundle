<?php

namespace TAhlin\Bundle\CoreBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;
use TAhlin\Bundle\CoreBundle\Exception\NotFoundException;

/**
 * Class AbstractRepository provides a more advanced implementation when finding entities
 */
abstract class AbstractRepository extends EntityRepository
{
    /**
     * This method tries to find an object by primary key
     * @param $id
     * @return object
     * @throws NotFoundException
     */
    public function find($id)
    {
        $entity = parent::find($id);
        if ($entity === null) {
            throw new NotFoundException('Entity ' . $this->_entityName . ' could not be found in the database.');
        }
        return $entity;
    }

    /**
     * @param array $criteria
     * @return object
     * @throws NotFoundException
     */
    public function findOneBy(array $criteria)
    {
        $entity = parent::findOneBy($criteria);

        if ($entity === null) {
            throw new NotFoundException('Entity ' . $this->_entityName . ' could not be found in the database.');
        }
        return $entity;
    }
}

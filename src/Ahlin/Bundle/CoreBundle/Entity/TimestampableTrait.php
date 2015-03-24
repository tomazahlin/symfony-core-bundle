<?php

namespace Ahlin\Bundle\CoreBundle\Entity;

use DateTime;

/**
 * Trait AbstractTimestampable serves as a trait for entities which should have timestampable behaviour, so they can have multiple behaviors.
 *
 */
trait TimestampableTrait
{
    /**
     * @var DateTime
     */
    protected $timeCreate;

    /**
     * @var DateTime
     */
    protected $timeUpdate;

    /**
     * @var DateTime
     */
    protected $timeDelete;

    /**
     * Set timeCreate
     *
     * @param DateTime $timeCreate
     * @return $this
     */
    public function setTimeCreate(DateTime $timeCreate)
    {
        $this->timeCreate = $timeCreate;
        return $this;
    }

    /**
     * Get timeCreate
     *
     * @return DateTime
     */
    public function getTimeCreate()
    {
        return $this->timeCreate;
    }

    /**
     * Set timeUpdate
     *
     * @param DateTime $timeUpdate
     * @return $this
     */
    public function setTimeUpdate(DateTime $timeUpdate)
    {
        $this->timeUpdate = $timeUpdate;
        return $this;
    }

    /**
     * Get timeUpdate
     *
     * @return DateTime
     */
    public function getTimeUpdate()
    {
        return $this->timeUpdate;
    }

    /**
     * Set timeDelete
     *
     * @param DateTime $timeDelete
     * @return $this
     */
    public function setTimeDelete(DateTime $timeDelete)
    {
        $this->timeDelete = $timeDelete;
        return $this;
    }

    /**
     * Get timeDelete
     *
     * @return DateTime
     */
    public function getTimeDelete()
    {
        return $this->timeDelete;
    }
}

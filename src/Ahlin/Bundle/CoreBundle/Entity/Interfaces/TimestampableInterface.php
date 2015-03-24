<?php

namespace Ahlin\Bundle\CoreBundle\Entity\Interfaces;

use DateTime;

interface TimestampableInterface
{
    /**
     * Set timeCreate
     *
     * @param DateTime $timeCreate
     * @return $this
     */
    public function setTimeCreate(DateTime $timeCreate);

    /**
     * Get timeCreate
     *
     * @return DateTime
     */
    public function getTimeCreate();

    /**
     * Set timeUpdate
     *
     * @param DateTime $timeUpdate
     * @return $this
     */
    public function setTimeUpdate(DateTime $timeUpdate);

    /**
     * Get timeUpdate
     *
     * @return DateTime
     */
    public function getTimeUpdate();

    /**
     * Set timeDelete
     *
     * @param DateTime $timeDelete
     * @return $this
     */
    public function setTimeDelete(DateTime $timeDelete);

    /**
     * Get timeDelete
     *
     * @return DateTime
     */
    public function getTimeDelete();
}

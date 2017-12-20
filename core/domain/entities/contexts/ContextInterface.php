<?php

namespace EventEspresso\core\domain\entities\contexts;

defined('EVENT_ESPRESSO_VERSION') || exit;



/**
 * Class ContextInterface
 * Simple DTO for conveying the background details about why some other logic is being performed,
 * that can assist with the decision making process or simply enhance logging.
 *
 * @package EventEspresso\core\domain\entities
 * @author  Brent Christensen
 * @since   4.9.46.rc.076
 */
interface ContextInterface
{

    /**
     * @return string
     */
    public function slug();


    /**
     * @return string
     */
    public function description();
}

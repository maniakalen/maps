<?php
/**
 * PHP Version 5.5
 *
 *  Module definition for Yii2 framework 
 *
 * @category Data flow 
 * @package  linear\workflow
 * @author   Peter Georgiev <peter.georgiev@concatel.com>
 * @license  GNU GENERAL PUBLIC LICENSE https://www.gnu.org/licenses/gpl.html
 * @link     - 
 */

namespace maniakalen\maps;

use Yii;
use yii\base\BootstrapInterface;
use yii\base\Event;
use yii\base\Application;
use yii\helpers\ArrayHelper;

/**
 * Class Module
 *
 *  Module definition for Yii2 framework
 *
 * @category Maps API Integration
 * @package  maniakalen\maps
 * @author   Peter Georgiev <peter.georgiev@concatel.com>
 * @license  GNU GENERAL PUBLIC LICENSE https://www.gnu.org/licenses/gpl.html
 * @link     -
 */
class Module extends \yii\base\Module implements BootstrapInterface
{
	public $center;
	public $zoom = 8;
	public $key;

	public function init()
	{
		parent::init();
		\Yii::setAlias('@maniakalen/maps', dirname(__FILE__));
		return null;
	}

    /**
     * Bootstrap method to be called during application bootstrap stage.
     *
     * @param Application $app the application currently running
     *
     * @return null
     */
    public function bootstrap($app)
    {
    	if ($this->key && $this->center && is_array($this->center) && isset($this->center[0]) && isset($this->center[1])) {
		    $app->view->registerJs( sprintf( 'window.maps_config = {"key":"%s", "center":[%s, %s}, "zoom":%s};', $this->key, $this->center[0], $this->center[1], (int) $this->zoom ) );
	    }
        return null;
    }
}
<?php
/**
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Nodrew\Bundle\DfpBundle\EventListener;

use Nodrew\Bundle\DfpBundle\Model\Collection,
    Symfony\Component\HttpKernel\Event\FilterResponseEvent,
    Symfony\Component\HttpFoundation\Response;

/**
 * @package     NodrewDfpBundle
 * @author      Drew Butler <hi@nodrew.com>
 * @copyright	(c) 2012 Drew Butler
 * @license     http://www.opensource.org/licenses/mit-license.php
 */
class ControlCodeListener
{
    /**
     * The template placeholder where the DFP code is to be inserted.
     */
    const PLACEHOLDER = '<!-- NodrewDfpBundle Control Code -->';

    /**
     * @var Nodrew\Bundle\DfpBundle\Model\Collection
     */
    protected $collection;

    /**
     * The Google DFP Api Key
     *
     * @var string
     */
    protected $publisherId;


    /**
     * Constructor.
     *
     * @param Nodrew\Bundle\DfpBundle\Model\Collection $collection
     * @param strign $apiKey
     */
    public function __construct(Collection $collection, $publisherId)
    {
        $this->publisherId = $publisherId;
        $this->collection  = $collection;
    }

    /**
     * Switch out the Control Code placeholder for the Google DFP control code html,
     * based upon the included ads.
     *
     * @param Symfony\Component\HttpKernel\Event\FilterResponseEvent $event
     */
    public function onKernelResponse(FilterResponseEvent $event)
    {
        $response = $event->getResponse();

        $controlCode = '';
        if (count($this->collection) > 0) {
            $controlCode .= $this->getMainControlCode();
            
            foreach ($this->collection as $unit) {
                
            }
        }

        $response->setContent(str_replace(self::PLACEHOLDER, $controlCode, $response->getContent()));
    }

    /**
     * Get the main google dfp control code block.
     *
     * This inserts the main google script.
     *
     * @return string
     */
    protected function getMainControlCode()
    {
        return <<< CONTROL
<script type='text/javascript'>
var googletag = googletag || {};
googletag.cmd = googletag.cmd || [];
(function() {
var gads = document.createElement('script');
gads.async = true;
gads.type = 'text/javascript';
var useSSL = 'https:' == document.location.protocol;
gads.src = (useSSL ? 'https:' : 'http:') +
'//www.googletagservices.com/tag/js/gpt.js';
var node = document.getElementsByTagName('script')[0];
node.parentNode.insertBefore(gads, node);
})();
</script>

CONTROL;
    }
    
    protected function getControlBlock()
    {
        $targets = '';
        // googletag.target('', '');
        return <<< BLOCK
<script type='text/javascript'>
googletag.cmd.push(function() {
googletag.defineSlot('/7247/stylecaster/community/profile', [300, 250], '{$this->publisherId}').addService(googletag.pubads());
googletag.pubads().enableSingleRequest();
googletag.enableServices();{$targets}
});
</script>
        
BLOCK;
    }
}

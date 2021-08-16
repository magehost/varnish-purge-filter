<?php

/**
 * Varnish Purge Filter Extension for Magento 2
 *
 * PHP version 7
 *
 * @category  MageHost
 * @package   MageHost\VarnishPurgeFilter
 * @author    Toon Van Dooren <toon@magehost.pro>
 * @copyright 2021 MageHost BV (https://magehost.pro)
 * @license   https://opensource.org/licenses/MIT  MIT License
 * @link      https://github.com/magehost/varnish-purge-filter
 */


namespace MageHost\VarnishPurgeFilter\Plugin;

use Psr\Log\LoggerInterface;
use Magento\CacheInvalidate\Model\PurgeCache;
use Magento\Framework\App\Config\ScopeConfigInterface;

/**
 * Class PurgeCachePlugin
 *
 * @package MageHost\VarnishPurgeFilter\Plugin
 */
class PurgeCachePlugin
{

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * @var ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     *
     */
    const CONFIG_PATH_PURGES = 'system/full_page_cache/purge_filters';


    /**
     *
     */
    const PURGE_FILTERS_MAPPING
    = [
        'products'   => 'cat_p',
        'categories' => 'cat_c',
        'cms_blocks' => 'cms_b',
        'cms_pages'  => 'cms_p',
    ];

    /**
     * PurgeCachePlugin constructor.
     *
     * @param  LoggerInterface       $logger
     * @param  ScopeConfigInterface  $scopeConfig
     */
    public function __construct(LoggerInterface $logger, ScopeConfigInterface $scopeConfig)
    {
        $this->logger = $logger;
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * Plugin before sendPurgeRequest and filter tag
     * 
     * @param  PurgeCache  $subject
     * @param              $tags
     *
     * @return string[]
     */
    public function beforeSendPurgeRequest(PurgeCache $subject, $tags)
    {
        if (!is_array($tags)) {
            $tags = [$tags];
        }

        $tagsToFilter = [];

        foreach (self::PURGE_FILTERS_MAPPING as $key => $value) {
            if ($this->scopeConfig->getValue(
                self::CONFIG_PATH_PURGES . '/' . $key,
                ScopeConfigInterface::SCOPE_TYPE_DEFAULT
            )) {
                $tagsToFilter[] = $value;
            }
        }

        if (count($tagsToFilter) > 0) {
            foreach ($tags as $key => $value) {
                if (preg_match('/' . implode('|', $tagsToFilter) . '/i', $value)) {
                    unset($tags[$key]);
                }
            }
        }

        // sendPurgeRequest crashes when passing an empty array, empty string causes empty purge
        if (count($tags) === 0 || !isset($tags)) {
            return ['mh_ban_nothing'];
        }

        return $tags;
    }
}

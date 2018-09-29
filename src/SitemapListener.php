<?php

namespace Eastslopestudio\JigsawSitemap;

use TightenCo\Jigsaw\Jigsaw;
use samdark\sitemap\Sitemap;

class SitemapListener
{

    /**
     * Invalid files
     *
     * @var array
     */
    protected $invalidAssets = ['.htaccess', 'favicon.ico'];

    public function handle(Jigsaw $jigsaw)
    {
        $baseUrl = $jigsaw->getConfig('baseUrl');
        if (empty($baseUrl)) {
            return;
        }

        $sitemap = new Sitemap($jigsaw->getDestinationPath() . '/sitemap.xml');

        collect($jigsaw->getOutputPaths())->each(function ($path) use ($baseUrl, $sitemap) {
            if (!$this->isAsset($path)) {
                $sitemap->addItem($baseUrl . $path, time(), Sitemap::MONTHLY);
            }
        });

        $sitemap->write();
    }

    private function isAsset($path)
    {
        return starts_with($path, '/assets') || str_contains($path, $this->invalidAssets);
    }
}

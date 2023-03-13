<?php

namespace Eastslopestudio\JigsawSitemap;

use TightenCo\Jigsaw\Jigsaw;
use samdark\sitemap\Sitemap;

class SitemapListener
{

    /**
     * Jigsaw instance.
     *
     */
    protected $jigsaw;

    public function handle(Jigsaw $jigsaw)
    {
        $this->jigsaw = $jigsaw;
        
        $baseUrl = $jigsaw->getConfig('baseUrl');
        if (empty($baseUrl)) {
            return;
        }

        $sitemap = new Sitemap($jigsaw->getDestinationPath() . '/sitemap.xml');

        collect($jigsaw->getOutputPaths())->each(function ($path) use ($baseUrl, $sitemap) {
            if (!$this->isAsset($path)) {
                $sitemap->addItem(\Illuminate\Support\Str::finish($baseUrl . $path, '/'), time(), Sitemap::MONTHLY);
            }
        });

        $sitemap->write();

        // Robots.txt
        $robots = "User-agent: *\nAllow: /\n\nSitemap: ".$jigsaw->getConfig('baseUrl')."/sitemap.xml";
        file_put_contents($jigsaw->getDestinationPath() . '/robots.txt', $robots);
    }

    private function isAsset($path)
    {
        $excluded = $this->jigsaw->getConfig('sitemap_exclude');
        $invalidAssets = $excluded ? $excluded->toArray() : [];
        return \Illuminate\Support\Str::startsWith($path, '/assets') || \Illuminate\Support\Str::contains($path, $invalidAssets);
    }
}

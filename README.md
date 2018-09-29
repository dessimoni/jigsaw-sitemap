# Jigsaw Sitemap

Sitemap and sitemap index builder for [Jigsaw](https://jigsaw.tighten.co).

---

## Usage

Add as an event [listener](https://jigsaw.tighten.co/docs/event-listeners) in `bootstrap.php`.

```php
use Eastslopestudio\JigsawSitemap\GenerateSitemapListener;

/**
 * An afterBuild event is fired after the build is complete, and all output files
 * have been written to the build directory. This allows you to obtain a list of
 * the output file paths (to use, for example, when creating a sitemap.xml file),
 * programmatically create output files, or take care of any other post-processing tasks.
 *
 * @link http://jigsaw.tighten.co/docs/event-listeners/
 */
$events->afterBuild([
    GenerateSitemapListener::class,
]);
```

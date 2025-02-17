<?php declare(strict_types=1);

namespace HarmBandstra\SwaggerUiBundle\Composer;

use Composer\Script\Event;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;

class ScriptHandler
{
    private const SWAGGER_UI_DIST_DIR = 'swagger-api/swagger-ui/dist';
    private const BUNDLE_PUBLIC_DIR = 'hypecodeteam/swagger-ui-bundle/src/Resources/public';
    private const SWAGGER_INITIALIZER_JS_FILENAME_DIST = 'swagger-initializer.js.dist';
    private const SWAGGER_INITIALIZER_JS_FILENAME = 'swagger-initializer.js';

    public static function linkAssets(Event $event): void
    {
        $filesystem = new Filesystem();
        $vendorDir = $event->getComposer()->getConfig()->get('vendor-dir');

        $source = sprintf('%s/%s', $vendorDir, self::SWAGGER_UI_DIST_DIR);
        $target = sprintf('%s/%s', $vendorDir, self::BUNDLE_PUBLIC_DIR);

        $filesIterator = new Finder();
        $filesIterator->files()->in($source)->notName('*.map');

        $filesystem->mirror($source, $target, $filesIterator, ['override' => true]);
        self::overrideSwaggerInitializerJs($target);

        $event->getIO()->write('Linked + override SwaggerUI assets.');
    }

    private static function overrideSwaggerInitializerJs(string $targetDir): void
    {
        $targetFile = sprintf('%s/%s', $targetDir, self::SWAGGER_INITIALIZER_JS_FILENAME);
        unlink($targetFile);
        copy(
            sprintf('%s/%s', $targetDir, self::SWAGGER_INITIALIZER_JS_FILENAME_DIST),
            $targetFile
        );
    }
}

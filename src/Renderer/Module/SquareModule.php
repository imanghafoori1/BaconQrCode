<?php
declare(strict_types = 1);

namespace BaconQrCode\Renderer\Module;

use BaconQrCode\Encoder\ByteMatrix;
use BaconQrCode\Renderer\Module\EdgeIterator\EdgeIterator;
use BaconQrCode\Renderer\Path\Path;

/**
 * Groups modules together to a single path.
 */
final class SquareModule implements ModuleInterface
{
    public function createPath(ByteMatrix $matrix) : Path
    {
        $path = new Path();

        foreach (new EdgeIterator($matrix) as $edge) {
            $edge->simplify();
            $points = $edge->getPoints();
            $length = count($points);
            $path = $path->moveTo($points[0][0], $points[0][1]);

            for ($i = 1; $i < $length; ++$i) {
                $path = $path->lineTo($points[$i][0], $points[$i][1]);
            }

            $path = $path->close();
        }

        return $path;
    }
}

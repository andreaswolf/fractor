<?php

declare(strict_types=1);

namespace a9f\Fractor\Configuration;

use a9f\Fractor\Caching\ValueObject\Storage\FileCacheStorage;

final class Option
{
    /**
     * @var string
     */
    public const PATHS = 'paths';

    /**
     * @var string
     */
    public const SKIP = 'skip';

    /**
     * @var string
     */
    public const DRY_RUN = 'dry-run';

    /**
     * @var string
     */
    public const DRY_RUN_SHORT = 'n';

    /**
     * @var string
     */
    public const QUIET = 'quiet';

    /**
     * @var string
     */
    public const QUIET_SHORT = 'q';

    /**
     * @var string
     */
    public const CONFIG = 'config';

    /**
     * @var string
     */
    public const CONFIG_SHORT = 'c';

    public const CACHE_DIR = 'cache_dir';

    /**
     * @var string
     */
    public const ONLY = 'only';

    public const CACHE_CLASS = FileCacheStorage::class;

    public const CONTAINER_CACHE_DIRECTORY = 'container-cache-directory';

    public const CLEAR_CACHE = 'clear-cache';

    public const REGISTERED_FRACTOR_RULES = 'registered_fractor_rules';

    public const OPTIONS = 'options';
}

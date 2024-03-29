<?php

/**
 * Aphiria
 *
 * @link      https://www.aphiria.com
 * @copyright Copyright (C) 2023 David Young
 * @license   https://github.com/aphiria/aphiria/blob/1.x/LICENSE.md
 */

declare(strict_types=1);

namespace Aphiria\Application\Configuration;

use Closure;
use RuntimeException;

/**
 * Defines the global configuration
 */
class GlobalConfiguration
{
    /** @var list<IConfiguration> The underlying static configuration sources */
    private static array $configurationSources = [];

    /**
     * Sets the global configuration instance
     *
     * @param IConfiguration $configuration The configuration to use as the global configuration
     */
    public static function addConfigurationSource(IConfiguration $configuration): void
    {
        self::$configurationSources[] = $configuration;
    }

    /**
     * Gets the array value at the path
     *
     * @param string $path The period-delimited path to the value in the config to get
     * @return array<mixed, mixed> The value at the path
     * @throws RuntimeException Thrown if the underlying config was not set first
     * @throws MissingConfigurationValueException Thrown if there was no value at the input path
     */
    public static function getArray(string $path): array
    {
        self::validateConfigurationSources();

        $value = null;

        foreach (self::$configurationSources as $configurationSource) {
            if ($configurationSource->tryGetArray($path, $value)) {
                return $value;
            }
        }

        throw new MissingConfigurationValueException($path);
    }

    /**
     * Gets the boolean value at the path
     *
     * @param string $path The period-delimited path to the value in the config to get
     * @return bool The value at the path
     * @throws RuntimeException Thrown if the underlying config was not set first
     * @throws MissingConfigurationValueException Thrown if there was no value at the input path
     */
    public static function getBool(string $path): bool
    {
        self::validateConfigurationSources();

        $value = null;

        foreach (self::$configurationSources as $configurationSource) {
            if ($configurationSource->tryGetBool($path, $value)) {
                return $value;
            }
        }

        throw new MissingConfigurationValueException($path);
    }

    /**
     * Gets the float value at the path
     *
     * @param string $path The period-delimited path to the value in the config to get
     * @return float The value at the path
     * @throws RuntimeException Thrown if the underlying config was not set first
     * @throws MissingConfigurationValueException Thrown if there was no value at the input path
     */
    public static function getFloat(string $path): float
    {
        self::validateConfigurationSources();

        $value = null;

        foreach (self::$configurationSources as $configurationSource) {
            if ($configurationSource->tryGetFloat($path, $value)) {
                return $value;
            }
        }

        throw new MissingConfigurationValueException($path);
    }

    /**
     * Gets the int value at the path
     *
     * @param string $path The period-delimited path to the value in the config to get
     * @return int The value at the path
     * @throws RuntimeException Thrown if the underlying config was not set first
     * @throws MissingConfigurationValueException Thrown if there was no value at the input path
     */
    public static function getInt(string $path): int
    {
        self::validateConfigurationSources();

        $value = null;

        foreach (self::$configurationSources as $configurationSource) {
            if ($configurationSource->tryGetInt($path, $value)) {
                return $value;
            }
        }

        throw new MissingConfigurationValueException($path);
    }

    /**
     * Gets the object value at the path
     *
     * @template T of object
     * @param string $path The period-delimited path to the value in the config to get
     * @param Closure(mixed): T $factory The factory that will take in the raw config value and return the object
     * @return T The object at the path
     * @throws RuntimeException Thrown if the underlying config was not set first
     * @throws MissingConfigurationValueException Thrown if there was no value at the input path
     */
    public static function getObject(string $path, Closure $factory): object
    {
        self::validateConfigurationSources();

        $value = null;

        foreach (self::$configurationSources as $configurationSource) {
            if ($configurationSource->tryGetObject($path, $factory, $value)) {
                return $value;
            }
        }

        throw new MissingConfigurationValueException($path);
    }

    /**
     * Gets the string value at the path
     *
     * @param string $path The period-delimited path to the value in the config to get
     * @return string The value at the path
     * @throws RuntimeException Thrown if the underlying config was not set first
     * @throws MissingConfigurationValueException Thrown if there was no value at the input path
     */
    public static function getString(string $path): string
    {
        self::validateConfigurationSources();

        $value = null;

        foreach (self::$configurationSources as $configurationSource) {
            if ($configurationSource->tryGetString($path, $value)) {
                return $value;
            }
        }

        throw new MissingConfigurationValueException($path);
    }

    /**
     * Gets the value at the path
     *
     * @param string $path The period-delimited path to the value in the config to get
     * @return mixed The value at the path
     * @throws RuntimeException Thrown if the underlying config was not set first
     * @throws MissingConfigurationValueException Thrown if there was no value at the input path
     */
    public static function getValue(string $path): mixed
    {
        self::validateConfigurationSources();

        $value = null;

        foreach (self::$configurationSources as $configurationSource) {
            if ($configurationSource->tryGetValue($path, $value)) {
                return $value;
            }
        }

        throw new MissingConfigurationValueException($path);
    }

    /**
     * Removes all configuration sources (useful for testing)
     *
     * @internal
     */
    public static function resetConfigurationSources(): void
    {
        self::$configurationSources = [];
    }

    /**
     * Tries to get an array value at the path
     *
     * @param string $path The period-delimited path to the value in the config to get
     * @param array|null $value The value if one was found, otherwise null
     * @param-out array $value
     * @return bool True if the value existed, otherwise false
     */
    public static function tryGetArray(string $path, ?array &$value): bool
    {
        self::validateConfigurationSources();

        try {
            $value = self::getArray($path);

            return true;
        } catch (MissingConfigurationValueException) {
            $value = null;

            return false;
        }
    }

    /**
     * Tries to get a boolean value at the path
     *
     * @param string $path The period-delimited path to the value in the config to get
     * @param bool|null $value The value if one was found, otherwise null
     * @param-out bool $value
     * @return bool True if the value existed, otherwise false
     */
    public static function tryGetBool(string $path, ?bool &$value): bool
    {
        self::validateConfigurationSources();

        try {
            $value = self::getBool($path);

            return true;
        } catch (MissingConfigurationValueException) {
            $value = null;

            return false;
        }
    }

    /**
     * Tries to get a float value at the path
     *
     * @param string $path The period-delimited path to the value in the config to get
     * @param float|null $value The value if one was found, otherwise null
     * @param-out float $value
     * @return bool True if the value existed, otherwise false
     */
    public static function tryGetFloat(string $path, ?float &$value): bool
    {
        self::validateConfigurationSources();

        try {
            $value = self::getFloat($path);

            return true;
        } catch (MissingConfigurationValueException) {
            $value = null;

            return false;
        }
    }

    /**
     * Tries to get an integer value at the path
     *
     * @param string $path The period-delimited path to the value in the config to get
     * @param int|null $value The value if one was found, otherwise null
     * @param-out int $value
     * @return bool True if the value existed, otherwise false
     */
    public static function tryGetInt(string $path, ?int &$value): bool
    {
        self::validateConfigurationSources();

        try {
            $value = self::getInt($path);

            return true;
        } catch (MissingConfigurationValueException) {
            $value = null;

            return false;
        }
    }

    /**
     * Tries to get the object value at the path
     *
     * @template T of object
     * @param string $path The period-delimited path to the value in the config to get
     * @param Closure(mixed): T $factory The factory that will take in the raw config value and return the object
     * @param T|null $value The value if one was found, otherwise null
     * @param-out T $value
     * @return bool True if the value existed, otherwise false
     * @throws RuntimeException Thrown if the underlying config was not set first
     */
    public static function tryGetObject(string $path, Closure $factory, ?object &$value): bool
    {
        self::validateConfigurationSources();

        try {
            $value = self::getObject($path, $factory);

            return true;
        } catch (MissingConfigurationValueException) {
            $value = null;

            return false;
        }
    }

    /**
     * Tries to get a string value at the path
     *
     * @param string $path The period-delimited path to the value in the config to get
     * @param string|null $value The value if one was found, otherwise null
     * @param-out string $value
     * @return bool True if the value existed, otherwise false
     */
    public static function tryGetString(string $path, ?string &$value): bool
    {
        self::validateConfigurationSources();

        try {
            $value = self::getString($path);

            return true;
        } catch (MissingConfigurationValueException) {
            $value = null;

            return false;
        }
    }

    /**
     * Tries to get a value value at the path
     *
     * @param string $path The period-delimited path to the value in the config to get
     * @param mixed $value The value if one was found, otherwise null
     * @param-out mixed $value
     * @return bool True if the value existed, otherwise false
     */
    public static function tryGetValue(string $path, mixed &$value): bool
    {
        self::validateConfigurationSources();

        try {
            /** @psalm-suppress MixedAssignment This is purposely set to a mixed value */
            $value = self::getValue($path);

            return true;
        } catch (MissingConfigurationValueException) {
            $value = null;

            return false;
        }
    }

    /**
     * Validates that the configuration sources are set
     *
     * @throws RuntimeException Thrown if no configuration sources were set
     */
    private static function validateConfigurationSources(): void
    {
        if (\count(self::$configurationSources) === 0) {
            throw new RuntimeException('No source configurations set');
        }
    }
}

<?php

namespace Framework\Test;

// The class that implements this interface can change its behaviour when executed in test mode.
interface SupportsTestModeInterface
{
    public static function useTestMode(): void;
}
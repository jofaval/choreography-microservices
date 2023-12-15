<?php

interface ServiceHandler
{
    public function success();
    public function fail();
}

class ShipmentsHandler implements ServiceHandler
{
    public function success(): void
    {
        throw new Error("Not implemented");
    }

    public function fail(): void
    {
        throw new Error("Not implemented");
    }
}

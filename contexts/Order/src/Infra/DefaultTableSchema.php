<?php

namespace Kata\Order\Infra;

use EventSauce\EventSourcing\Header;
use EventSauce\MessageRepository\TableSchema\TableSchema;

class DefaultTableSchema implements TableSchema
{
    public function eventIdColumn(): string
    {
        return 'event_id';
    }

    public function aggregateRootIdColumn(): string
    {
        return 'aggregate_root_id';
    }

    public function versionColumn(): string
    {
        return 'version';
    }

    public function payloadColumn(): string
    {
        return 'payload';
    }

    public function additionalColumns(): array
    {
        return [
            'recorded_at' => Header::TIME_OF_RECORDING,
            'event_type' => Header::EVENT_TYPE,
        ];
    }
}

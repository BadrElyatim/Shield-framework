<?php

namespace Shield\Database;

class DB {
    public static function table(string $table) {
        return new Table($table);
    }
}
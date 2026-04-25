<?php
require_once __DIR__ . '/Supabase.php';

class Database {
    public function getConnection() {
        return new Supabase();
    }
}
?>
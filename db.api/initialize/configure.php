<?php
use Phidias\Utilities\Configuration;
use Phidias\Db\Db;

// Obtain DB connection identifiers from configuration
Db::configure(function ($identifier = null) {

    $base = $identifier === null ? "phidias.db" : "phidias.db.$identifier";

    if (!Configuration::get("$base.host")) {
        return null;
    }

    return array(
        "host"     => Configuration::get("$base.host"),
        "username" => Configuration::get("$base.username"),
        "password" => Configuration::get("$base.password"),
        "database" => Configuration::get("$base.database"),
        "charset"  => Configuration::get("$base.charset")
    );

});

<?php

class MemcacheConfig {
    public static $GROUP_DEFAULT = array(
        0 => array(
            'host' => '127.0.0.1',
            'port' => 11211,
            'weight' => 10
        ),
    );

    //sasl认证配置
    const SASL_USERNAME = '';
    const SASL_PASSWORD = '';
}
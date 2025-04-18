<?php
/**
 * Created by PhpStorm.
 * User: Roman
 * Date: 2015.09.17
 * Time: 14:05
 */

namespace app\components;
use yii;
use DateTimeZone;
use DateTime;

class Timezone
{
    public static function all() {
        static $tz = array();
        if(!$tz) {
            $regions = array(
                DateTimeZone::AFRICA,
                DateTimeZone::AMERICA,
                DateTimeZone::ANTARCTICA,
                DateTimeZone::ASIA,
                DateTimeZone::ATLANTIC,
                DateTimeZone::AUSTRALIA,
                DateTimeZone::EUROPE,
                DateTimeZone::INDIAN,
                DateTimeZone::PACIFIC,
            );

            $timezones = array();
            foreach( $regions as $region )
            {
                $timezones = array_merge( $timezones, DateTimeZone::listIdentifiers( $region ) );
            }

            $timezone_offsets = array();
            foreach( $timezones as $timezone )
            {
                $tz = new DateTimeZone($timezone);
                $timezone_offsets[$timezone] = $tz->getOffset(new \DateTime);
            }

            // sort timezone by offset
            asort($timezone_offsets);

            $timezone_list = array();
            foreach( $timezone_offsets as $timezone => $offset )
            {
                $offset_prefix = $offset < 0 ? '-' : '+';
                $offset_formatted = gmdate( 'H:i', abs($offset) );

                $pretty_offset = "UTC${offset_prefix}${offset_formatted}";

                $timezone_list[$timezone] = "(${pretty_offset}) $timezone";
            }
            $tz = $timezone_list;
        }
        return $tz;
    }

    public static function isValid($tz) {
        $zones = self::all();
        return isset($zones[$tz]);
    }

    public static function get($tz) {
        $list = self::all();
        return isset($list[$tz]) ? $list[$tz] : false;
    }
}
<?php
namespace App;
use transit_realtime\FeedMessage;

/**
 * Subway Time Application
 */
class Subwaytime {
    protected $url;
    protected $key;

    public function __construct() {
        $this->url = env( 'MTA_FEED' );
        $this->key = env( 'MTA_KEY' );
    }

    public function get() {
        // Get the stop we're looking for
        $stop_id = env( 'MTA_STOP_ID' );
        // Retrieve the feed
        $data = file_get_contents( $this->get_feed_url() );

        // Parse the feed
        $feed = new FeedMessage();
        $feed->parse( $data );
        foreach ($feed->getEntityList() as $entity) {
            if ( $entity->hasTripUpdate() ) {
                $trip_update = $entity->getTripUpdate();
                var_dump($trip_update->hasDirection());
                $stop_time_updates = $trip_update->getStopTimeUpdate();

                foreach ( $stop_time_updates as $stop_time ) {
                    if ( $stop_id === $stop_time->getStopId() ) {
                        $arrival = $stop_time->getArrival();
                        $arrival_time = \Carbon\Carbon::createFromTimestamp( $arrival->getTime() );

                        if ( ! $arrival->hasSkipped() || ! $arrival->getSkipped() ) {
                            // var_dump($arrival);exit;
                            // var_dump($arrival_time->diffForHumans());
                            // var_dump('Uncertainty');exit;
                        }
                    }
                }
            }
        }
    }

    /**
     * Retrieve the feed URL
     *
     * @return string
     */
    protected function get_feed_url() {
        return sprintf( $this->url, $this->key );
    }
}

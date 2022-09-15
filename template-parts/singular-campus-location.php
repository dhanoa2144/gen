<?php $fields = $args; ?>
<div class="col-md-6">
    <h3><?php echo $fields['page_title']; ?></h3>
    <?php
        $address .= (!empty($fields['loca_building'])) ? $fields['loca_building'] . " " : "";
        $address .= (!empty($fields['loca_unit'])) ? $fields['loca_unit'] . "/" : "";
        $address .= (!empty($fields['loca_streetnumber'])) ? $fields['loca_streetnumber'] . " " : "";
        $address .= (!empty($fields['loca_streetname'])) ? $fields['loca_streetname'] : "";
        $address .= '<br>';
        $address .= (!empty($fields['loca_city'])) ? $fields['loca_city'] . " " : "";
        $address .= (!empty($fields['loca_state'])) ? $fields['loca_state'] . " - " : "";
        $address .= (!empty($fields['loca_postcode'])) ? $fields['loca_postcode'] : "";
    ?>

    <p><?php echo $address; ?></p>
    <p>
        <strong>Phone: </strong><br><?php echo $fields['loca_phone']; ?><br><br>
        <strong>Timings: </strong><br><?php echo $fields['loca_timings']; ?>
    </p>
</div>

<div class="col-md-6 map-container">
    <h3>Map</h3>
    <?php
    $location = $fields['loca_map'];
    if( $location ): ?>
        <div class="acf-map" data-zoom="16">
            <div class="marker" data-lat="<?php echo esc_attr($location['lat']); ?>" data-lng="<?php echo esc_attr($location['lng']); ?>"></div>
        </div>
    <?php endif; ?>
</div>
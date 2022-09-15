<?php
/**
 * Share buttons template part.
 *
 * @package WordPress
 * @subpackage genU Training
 */

$showAccordion = false;
if ($rows = get_field('accordion_fields')) {
    if (array_key_exists('isShortcode', $args)) {
        $showAccordion = true;
    }
}
?>
<?php 
    if ($rows && $showAccordion) :
?>
    <div class="accordion">
    <?php foreach ($rows as $key=>$row) : ?>
    <?php //var_dump($row); ?>
    <?php if ($key === array_key_first($rows) && get_post_type() == 'program') {
        
       // echo 'FIRST ELEMENT!';
        $first_element = true;
        $style = 'display: block; !important'; 
    }
    else{
        $style = '' ;
    }?>
        <div class="row">
            <div class="col-12 btn-container">
                <div class="btn-wrapper">
                    <button class="btn w-100 d-flex align-items-center justify-content-between">
                        <?php echo $row['label']; ?>
                        <i class="fas fa-chevron-down"></i>
                    </button>
                </div>
            </div>
            <div class="col-12 content-container" style="<?php echo $style;?>">
                <div class="content-wrapper">
                    <?php echo $row['content']; ?>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
        <?php //exit; ?>
    </div>
<?php endif; ?>
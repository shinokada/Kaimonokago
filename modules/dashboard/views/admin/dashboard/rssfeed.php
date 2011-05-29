<?php if ($rss_items) : ?>
<!-- News Feed -->
<ul id="news-feed">
    <?php foreach($rss_items as $rss_item): ?>
    <li>
        <h4><?php echo anchor($rss_item->get_permalink(), $rss_item->get_title(), 'target="_blank"'); ?></h4>

        <?php
                $item_date	= strtotime($rss_item->get_date());
                $item_month = date('M', $item_date);
                $item_day	= date('j', $item_date);
        ?>
        <div class="date">
                <span><?php echo $item_month ?></span>
                <?php echo $item_day; ?>
        </div>

        <p class='item_body'><?php echo $rss_item->get_description(); ?></p>
    </li>
    <?php endforeach; ?>
</ul>

<?php endif; ?>
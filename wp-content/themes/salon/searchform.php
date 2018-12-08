<form action="<?php echo esc_url(home_url('/')); ?>/" method="get" class="wp-search-form">
	<i class="oic-zoom"></i>
    <input type="text" name="s" id="search" placeholder="<?php echo get_search_query() == '' ? esc_attr__('Type and hit Enter', 'salon') : get_search_query() ?>" />
</form>
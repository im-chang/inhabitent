<form role="search" method="get" class="search-form" action="<?php echo home_url( '/' ); ?>">

<button class="search-submit">
			<span class="icon-search" aria-hidden="true">
				<i class="fas fa-search fa-2x"></i>
			</span>
			<span class="screen-reader-text"><?php echo esc_html( 'Search' ); ?></span>
		</button>

		<label>
			<input type="search" class="search-field" placeholder="type and hit enter..." value="<?php echo esc_attr( get_search_query() ); ?>" name="s" title="Search for:" />
		</label>

</form>



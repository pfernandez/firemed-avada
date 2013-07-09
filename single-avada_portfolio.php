<?php get_header(); ?>
	<?php
	if(get_post_meta($post->ID, 'pyre_width', true) == 'half') {
		$portfolio_width = 'half';
	} else {
		$portfolio_width = 'full';
	}
	?>
	<div id="content" class="full-width portfolio-<?php echo $portfolio_width; ?>">
		<?php wp_reset_query(); ?>
		<?php $paged = (get_query_var('paged')) ? get_query_var('paged') : 1; ?>
		<?php query_posts($query_string.'&paged='.$paged); ?>
		<?php
		$nav_categories = '';
		$portfolioID = $_GET['portfolioID'];
		$page_categories = get_post_meta($portfolioID, 'pyre_portfolio_category', true);
		if($page_categories && is_array($page_categories) && $page_categories[0] !== '0') {
			$nav_categories = implode(',', $page_categories);
		}
		?>
		<div class="single-navigation clearfix">
			<?php
			if($portfolioID) {
				$previous_post_link = previous_post_link_plus(array('format' => '%link', 'link' => __('Previous', 'Avada'), 'in_same_tax' => 'portfolio_category', 'in_cats' => $nav_categories, 'return' => 'href'));
			} else {
				$previous_post_link = previous_post_link_plus(array('format' => '%link', 'link' => __('Previous', 'Avada'), 'return' => 'href'));
			}
			?>
			<?php if($previous_post_link):
			if($portfolioID) {
				$previous_post_link = tf_addUrlParameter($previous_post_link, 'portfolioID', $portfolioID);
			}
			?>
			<a href="<?php echo $previous_post_link; ?>" rel="prev"><?php _e('Previous', 'Avada'); ?></a>
			<?php endif; ?>
			<?php 
			if($portfolioID) {
				$next_post_link = next_post_link_plus(array('format' => '%link', 'link' => __('Next', 'Avada'), 'in_same_tax' => 'portfolio_category', 'in_cats' => $nav_categories, 'return' => 'href'));
			} else {
				$next_post_link = next_post_link_plus(array('format' => '%link', 'link' => __('Next', 'Avada'), 'return' => 'href'));				
			}
			?>
			<?php if($next_post_link):
			if($portfolioID) {
				$next_post_link = tf_addUrlParameter($next_post_link, 'portfolioID', $portfolioID);
			}
			?>
			<a href="<?php echo $next_post_link; ?>" rel="next"><?php _e('Next', 'Avada'); ?></a>
			<?php endif; ?>
		</div>
		<?php if(have_posts()): the_post(); ?>
		<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<?php
			if($data['legacy_posts_slideshow']):
			$args = array(
			    'post_type' => 'attachment',
			    'numberposts' => $data['posts_slideshow_number']-1,
			    'post_status' => null,
			    'post_parent' => $post->ID,
				'orderby' => 'menu_order',
				'order' => 'ASC',
				'post_mime_type' => 'image',
				'exclude' => get_post_thumbnail_id()
			);
			$attachments = get_posts($args);
			if((has_post_thumbnail() || get_post_meta($post->ID, 'pyre_video', true))):
			?>
			<div class="flexslider post-slideshow">
				<ul class="slides">
					<?php if(get_post_meta($post->ID, 'pyre_video', true)): ?>
					<li class="full-video">
						<?php echo get_post_meta($post->ID, 'pyre_video', true); ?>
					</li>
					<?php endif; ?>
					<?php if(has_post_thumbnail() && !get_post_meta($post->ID, 'pyre_video', true)): ?>
					<?php $attachment_image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full'); ?>
					<?php $full_image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full'); ?>
					<?php $attachment_data = wp_get_attachment_metadata(get_post_thumbnail_id()); ?>
					<li>
						<a href="<?php echo $full_image[0]; ?>" rel="prettyPhoto[gallery<?php the_ID(); ?>]" title="<?php echo get_post_field('post_content', get_post_thumbnail_id()); ?>"><img src="<?php echo $attachment_image[0]; ?>" alt="<?php echo get_post_field('post_excerpt', get_post_thumbnail_id()); ?>" /></a>
					</li>
					<?php endif; ?>
					<?php if($data['posts_slideshow']): ?>
					<?php foreach($attachments as $attachment): ?>
					<?php $attachment_image = wp_get_attachment_image_src($attachment->ID, 'full'); ?>
					<?php $full_image = wp_get_attachment_image_src($attachment->ID, 'full'); ?>
					<?php $attachment_data = wp_get_attachment_metadata($attachment->ID); ?>
					<li>
						<a href="<?php echo $full_image[0]; ?>" rel="prettyPhoto[gallery<?php the_ID(); ?>]" title="<?php echo get_post_field('post_content', $attachment->ID); ?>"><img src="<?php echo $attachment_image[0]; ?>" alt="<?php echo get_post_field('post_excerpt', $attachment->ID); ?>" /></a>
					</li>
					<?php endforeach; ?>
					<?php endif; ?>
				</ul>
			</div>
			<?php endif; ?>
			<?php else: ?>
			<?php
			if((has_post_thumbnail() || get_post_meta($post->ID, 'pyre_video', true))):
			?>
			<div class="flexslider post-slideshow">
				<ul class="slides">
					<?php if(get_post_meta($post->ID, 'pyre_video', true)): ?>
					<li class="full-video">
						<?php echo get_post_meta($post->ID, 'pyre_video', true); ?>
					</li>
					<?php endif; ?>
					<?php if(has_post_thumbnail() && !get_post_meta($post->ID, 'pyre_video', true)): ?>
					<?php $attachment_image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full'); ?>
					<?php $full_image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full'); ?>
					<?php $attachment_data = wp_get_attachment_metadata(get_post_thumbnail_id()); ?>
					<li>
						<a href="<?php echo $full_image[0]; ?>" rel="prettyPhoto[gallery<?php the_ID(); ?>]" title="<?php echo get_post_field('post_content', get_post_thumbnail_id()); ?>"><img src="<?php echo $attachment_image[0]; ?>" alt="<?php echo get_post_field('post_excerpt', get_post_thumbnail_id()); ?>" /></a>
					</li>
					<?php endif; ?>
					<?php if($data['posts_slideshow']): ?>
					<?php
					$i = 2;
					while($i <= $data['posts_slideshow_number']):
					$new_attachment_ID = kd_mfi_get_featured_image_id('featured-image-'.$i, 'avada_portfolio');
					if($new_attachment_ID):
					?>
					<?php $attachment_image = wp_get_attachment_image_src($new_attachment_ID, 'full'); ?>
					<?php $full_image = wp_get_attachment_image_src($new_attachment_ID, 'full'); ?>
					<?php $attachment_data = wp_get_attachment_metadata($new_attachment_ID); ?>
					<li>
						<a href="<?php echo $full_image[0]; ?>" rel="prettyPhoto[gallery<?php the_ID(); ?>]" title="<?php echo get_post_field('post_content', $new_attachment_ID); ?>"><img src="<?php echo $attachment_image[0]; ?>" alt="<?php echo get_post_field('post_excerpt', $new_attachment_ID); ?>" /></a>
					</li>
					<?php endif; $i++; endwhile; ?>
					<?php endif; ?>
				</ul>
			</div>
			<?php endif; ?>
			<?php endif; ?>
			<div class="project-content">
				<div class="project-description post-content">
					<h3><?php echo $data['project_desc_title']; ?></h3>
					<?php the_content(); ?>
				</div>
				<div class="project-info">
					<?php if(get_the_term_list($post->ID, 'portfolio_skills', '', '<br />', '')): ?>
					<h3><?php echo $data['project_details_title']; ?></h3>
					<div class="project-info-box">
						<h4><?php echo $data['skills_title']; ?>:</h4>
						<div class="project-terms">
							<?php echo get_the_term_list($post->ID, 'portfolio_skills', '', '<br />', ''); ?>
						</div>
					</div>
					<?php endif; ?>
					<?php if(get_the_term_list($post->ID, 'portfolio_category', '', '<br />', '')): ?>
					<div class="project-info-box">
						<h4><?php echo $data['categories_title']; ?>:</h4>
						<div class="project-terms">
							<?php echo get_the_term_list($post->ID, 'portfolio_category', '', '<br />', ''); ?>
						</div>
					</div>
					<?php endif; ?>
					<?php if(get_post_meta($post->ID, 'pyre_project_url', true) && get_post_meta($post->ID, 'pyre_project_url_text', true)): ?>
					<div class="project-info-box">
						<h4><?php echo $data['project_url_title']; ?>:</h4>
						<span><a href="<?php echo get_post_meta($post->ID, 'pyre_project_url', true); ?>"><?php echo get_post_meta($post->ID, 'pyre_project_url_text', true); ?></a></span>
					</div>
					<?php endif; ?>
					<?php if(get_post_meta($post->ID, 'pyre_copy_url', true) && get_post_meta($post->ID, 'pyre_copy_url_text', true)): ?>
					<div class="project-info-box">
						<h4><?php echo $data['copyright_title']; ?>:</h4>
						<span><a href="<?php echo get_post_meta($post->ID, 'pyre_copy_url', true); ?>"><?php echo get_post_meta($post->ID, 'pyre_copy_url_text', true); ?></a></span>
					</div>
					<?php endif; ?>
				</div>
			</div>
			<div style="clear:both;"></div>
			<?php $projects = get_related_projects($post->ID); ?>
			<?php if($projects->have_posts()): ?>
			<div class="related-posts related-projects">
				<div class="title"><h2><?php echo __('Related Projects', 'Avada'); ?></h2></div>
				<div id="carousel" class="es-carousel-wrapper">
					<div class="es-carousel">
						<ul>
							<?php while($projects->have_posts()): $projects->the_post(); ?>
							<?php if(has_post_thumbnail()): ?>
							<li>
								<div class="image">
										<?php if($data['image_rollover']): ?>
										<?php the_post_thumbnail('related-img'); ?>
										<?php else: ?>
										<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('related-img'); ?></a>
										<?php endif; ?>
										<div class="image-extras">
											<div class="image-extras-content">
							<?php $full_image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'full'); ?>
							<a class="icon link-icon" href="<?php the_permalink(); ?>">Permalink</a>
							<?php
							if(get_post_meta($post->ID, 'pyre_video_url', true)) {
								$full_image[0] = get_post_meta($post->ID, 'pyre_video_url', true);
							}
							?>
							<a class="icon gallery-icon" href="<?php echo $full_image[0]; ?>" rel="prettyPhoto[galleryrelated]">Gallery</a>
												<h3><?php the_title(); ?></h3>
											</div>
										</div>
								</div>
							</li>
							<?php endif; endwhile; ?>
						</ul>
					</div>
				</div>
			</div>
			<?php endif; ?>
		</div>
		<?php endif; ?>
	</div>
<?php get_footer(); ?>
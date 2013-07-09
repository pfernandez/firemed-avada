			<style type="text/css">
			<?php if(get_post_meta($post->ID, 'pyre_fimg_width', true) && get_post_meta($post->ID, 'pyre_fimg_width', true) != 'auto'): ?>
			#post-<?php echo $post->ID; ?> .post-slideshow,
			#post-<?php echo $post->ID; ?> .floated-post-slideshow,
			#post-<?php echo $post->ID; ?> .post-slideshow .image > img,
			#post-<?php echo $post->ID; ?> .floated-post-slideshow .image > img,
			#post-<?php echo $post->ID; ?> .post-slideshow .image > a > img,
			#post-<?php echo $post->ID; ?> .floated-post-slideshow .image > a > img
			{width:<?php echo get_post_meta($post->ID, 'pyre_fimg_width', true); ?> !important;}
			<?php endif; ?>

			<?php if(get_post_meta($post->ID, 'pyre_fimg_height', true) && get_post_meta($post->ID, 'pyre_fimg_height', true) != 'auto'): ?>
			#post-<?php echo $post->ID; ?> .post-slideshow,
			#post-<?php echo $post->ID; ?> .floated-post-slideshow,
			#post-<?php echo $post->ID; ?> .post-slideshow .image > img,
			#post-<?php echo $post->ID; ?> .floated-post-slideshow .image > img,
			#post-<?php echo $post->ID; ?> .post-slideshow .image > a > img,
			#post-<?php echo $post->ID; ?> .floated-post-slideshow .image > a > img
			{height:<?php echo get_post_meta($post->ID, 'pyre_fimg_height', true); ?> !important;}
			<?php endif; ?>
			</style>
			<?php
			if($data['blog_full_width']) {
				$size = 'full';
			} else {
				$size = 'blog-large';
			}
			?>
			<?php if($data['blog_layout'] == 'Large'): ?>
			<?php
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
			if($attachments || has_post_thumbnail() || get_post_meta(get_the_ID(), 'pyre_video', true)):
			?>
			<div class="flexslider post-slideshow">
				<ul class="slides">
					<?php if(get_post_meta(get_the_ID(), 'pyre_video', true)): ?>
					<li class="full-video">
						<?php echo get_post_meta(get_the_ID(), 'pyre_video', true); ?>
					</li>
					<?php endif; ?>
					<?php if(has_post_thumbnail()): ?>
					<?php $full_image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full'); ?>
					<?php $attachment_data = wp_get_attachment_metadata(get_post_thumbnail_id()); ?>
					<li>
						<div class="image">
								<?php if($data['image_rollover']): ?>
								<?php the_post_thumbnail($size); ?>
								<?php else: ?>
								<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail($size); ?></a>
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
										<a class="icon gallery-icon" href="<?php echo $full_image[0]; ?>" rel="prettyPhoto[gallery<?php echo $post->ID; ?>]" title="<?php echo get_post_field('post_content', get_post_thumbnail_id()); ?>"><img style="display:none;" alt="<?php echo get_post_field('post_excerpt', get_post_thumbnail_id()); ?>" />Gallery</a>
										<h3><?php the_title(); ?></h3>
									</div>
								</div>
						</div>
					</li>
					<?php endif; ?>
					<?php if($data['posts_slideshow']): ?>
					<?php foreach($attachments as $attachment): ?>
					<?php $attachment_image = wp_get_attachment_image_src($attachment->ID, $size); ?>
					<?php $full_image = wp_get_attachment_image_src($attachment->ID, 'full'); ?>
					<?php $attachment_data = wp_get_attachment_metadata($attachment->ID); ?>
					<li>
						<div class="image">
								<a href="<?php the_permalink(); ?>"><img src="<?php echo $attachment_image[0]; ?>" alt="<?php echo $attachment->post_title; ?>" /></a>
								<a style="display:none;" href="<?php echo $full_image[0]; ?>" rel="prettyPhoto[gallery<?php echo $post->ID; ?>]" alt="<?php echo get_post_field('post_excerpt', $attachment->ID); ?>" title="<?php echo get_post_field('post_content', $attachment->ID); ?>"><img style="display:none;" alt="<?php echo get_post_field('post_excerpt', $attachment->ID); ?>" /></a>
						</div>
					</li>
					<?php endforeach; ?>
					<?php endif; ?>
				</ul>
			</div>
			<?php endif; ?>
			<?php endif; ?>
			
			<?php if($data['blog_layout'] == 'Medium'): ?>
			<?php
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
			if($attachments || has_post_thumbnail() || get_post_meta(get_the_ID(), 'pyre_video', true)):
			?>
			<div class="flexslider blog-medium-image floated-post-slideshow">
				<ul class="slides">
					<?php if(get_post_meta(get_the_ID(), 'pyre_video', true)): ?>
					<li class="full-video">
						<?php echo get_post_meta(get_the_ID(), 'pyre_video', true); ?>
					</li>
					<?php endif; ?>
					<?php if(has_post_thumbnail()): ?>
					<?php $full_image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full'); ?>
					<?php $attachment_data = wp_get_attachment_metadata(get_post_thumbnail_id()); ?>
					<li>
						<div class="image">
								<?php if($data['image_rollover']): ?>
								<?php the_post_thumbnail('blog-medium'); ?>
								<?php else: ?>
								<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('blog-medium'); ?></a>
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
										<a class="icon gallery-icon" href="<?php echo $full_image[0]; ?>" rel="prettyPhoto[gallery<?php echo $post->ID; ?>]" title="<?php echo get_post_field('post_content', get_post_thumbnail_id()); ?>"><img style="display:none;" alt="<?php echo get_post_field('post_excerpt', get_post_thumbnail_id()); ?>" />Gallery</a>
										<h3><?php the_title(); ?></h3>
									</div>
								</div>
						</div>
					</li>
					<?php endif; ?>
					<?php if($data['posts_slideshow']): ?>
					<?php foreach($attachments as $attachment): ?>
					<?php $attachment_image = wp_get_attachment_image_src($attachment->ID, 'blog-medium'); ?>
					<?php $full_image = wp_get_attachment_image_src($attachment->ID, 'full'); ?>
					<?php $attachment_data = wp_get_attachment_metadata($attachment->ID); ?>
					<li>
						<div class="image">
								<a href="<?php the_permalink(); ?>"><img src="<?php echo $attachment_image[0]; ?>" alt="<?php echo $attachment->post_title; ?>" /></a>
								<a style="display:none;" href="<?php echo $full_image[0]; ?>" rel="prettyPhoto[gallery<?php echo $post->ID; ?>]" alt="<?php echo get_post_field('post_excerpt', $attachment->ID); ?>" title="<?php echo get_post_field('post_content', $attachment->ID); ?>"><img style="display:none;" alt="<?php echo get_post_field('post_excerpt', $attachment->ID); ?>" /></a>
						</div>
					</li>
					<?php endforeach; ?>
					<?php endif; ?>
				</ul>
			</div>
			<?php endif; ?>
			<?php endif; ?>
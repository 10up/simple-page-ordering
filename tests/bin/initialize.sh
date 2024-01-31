#!/bin/bash
wp-env run tests-wordpress chmod -c ugo+w /var/www/html
wp-env run tests-cli wp rewrite structure '/%postname%/' --hard
wp-env run tests-cli wp site empty --yes

# Create Posts
wp-env run tests-cli wp post create --post_status=publish --post_title='Post 1'
wp-env run tests-cli wp post create --post_status=publish --post_title='Post 2'
wp-env run tests-cli wp post create --post_status=publish --post_title='Post 3'
# Create Pages
wp-env run tests-cli wp post create --post_status=publish --post_type=page  --post_title='Page 1' --menu_order=10
wp-env run tests-cli wp post create --post_status=publish --post_type=page  --post_title='Page 2' --menu_order=20
wp-env run tests-cli wp post create --post_status=publish --post_type=page  --post_title='Page 3' --menu_order=30
wp-env run tests-cli wp post create --post_status=publish --post_type=page --post_parent=6 --post_title='Child Page 1' --menu_order=10
wp-env run tests-cli wp post create --post_status=publish --post_type=page --post_parent=6 --post_title='Child Page 2' --menu_order=20
wp-env run tests-cli wp post create --post_status=publish --post_type=page --post_parent=6 --post_title='Child Page 3' --menu_order=30

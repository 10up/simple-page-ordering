#!/bin/bash
npm run env run tests-wordpress "chmod -c ugo+w /var/www/html"
npm run env run tests-cli "wp rewrite structure '/%postname%/' --hard"
npm run env run tests-cli "wp site empty --yes"

# Create Posts
npm run env run tests-cli "wp post create --post_status=publish --post_title='Post 1'"
npm run env run tests-cli "wp post create --post_status=publish --post_title='Post 2'"
npm run env run tests-cli "wp post create --post_status=publish --post_title='Post 3'"
# Create Pages
npm run env run tests-cli "wp post create --post_status=publish --post_type=page  --post_title='Page 1' --menu_order=10"
npm run env run tests-cli "wp post create --post_status=publish --post_type=page  --post_title='Page 2' --menu_order=20"
npm run env run tests-cli "wp post create --post_status=publish --post_type=page  --post_title='Page 3' --menu_order=30"
npm run env run tests-cli "wp post create --post_status=publish --post_type=page --post_parent=6 --post_title='Child Page 1' --menu_order=10"
npm run env run tests-cli "wp post create --post_status=publish --post_type=page --post_parent=6 --post_title='Child Page 2' --menu_order=20"
npm run env run tests-cli "wp post create --post_status=publish --post_type=page --post_parent=6 --post_title='Child Page 3' --menu_order=30"

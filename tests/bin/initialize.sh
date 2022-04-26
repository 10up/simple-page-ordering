#!/bin/bash
npm run env run tests-wordpress "chmod -c ugo+w /var/www/html"
npm run env run tests-cli "wp rewrite structure '/%postname%/' --hard"

# Create Posts
npm run env run tests-cli "wp post create --post_status=publish --post_title='Post 1'"
npm run env run tests-cli "wp post create --post_status=publish --post_title='Post 2'"
# Create Pages
npm run env run tests-cli "wp post create --post_status=publish --post_type=page  --post_title='Page 1'"
npm run env run tests-cli "wp post create --post_status=publish --post_type=page  --post_title='Page 2'"
npm run env run tests-cli "wp post create --post_status=publish --post_type=page --post_parent=2 --post_title='Child Page 1'"
npm run env run tests-cli "wp post create --post_status=publish --post_type=page --post_parent=2 --post_title='Child Page 2'"

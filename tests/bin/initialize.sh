#!/bin/bash
# npm run env run tests-wordpress "chmod -c ugo+w /var/www/html"
# npm run env run tests-cli "wp rewrite structure '/%postname%/' --hard"


npx wp-env run tests-cli "wp post create --post_type=page --post_title='Page One' --post_status='publish'"
npx wp-env run tests-cli "wp post create --post_type=page --post_title='Page Two' --post_status='publish'"
npx wp-env run tests-cli "wp post create --post_type=page --post_title='Parent page' --post_status='publish'"
PARENT_PAGE_ID=$( npx wp-env run tests-cli "wp post list --post_type=page --title='Parent page' --field='ID'" )
npx wp-env run tests-cli "wp post create --post_type=page --post_title='Child page One' --post_status='publish' --post_parent=${PARENT_PAGE_ID}"
npx wp-env run tests-cli "wp post create --post_type=page --post_title='Child page Two' --post_status='publish' --post_parent=${PARENT_PAGE_ID}"
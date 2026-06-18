#!/usr/bin/env bash

set -euo pipefail

if [[ $# -ne 1 ]]; then
	echo "Usage: $0 <major|minor|patch>" >&2
	exit 1
fi

bump_type="$1"

case "$bump_type" in
	major|minor|patch)
		;;
	*)
		echo "Invalid bump type: $bump_type" >&2
		echo "Expected one of: major, minor, patch" >&2
		exit 1
		;;
esac

script_dir="$(cd "$(dirname "$0")" && pwd)"
repo_dir="$(cd "$script_dir/.." && pwd)"

cd "$repo_dir"

for required_file in readme.txt simple-page-ordering.php class-simple-page-ordering.php package.json package-lock.json CHANGELOG.md; do
	if [[ ! -f "$required_file" ]]; then
		echo "Missing required file: $required_file" >&2
		exit 1
	fi
done

current_version="$(node -p "require('./package.json').version")"

if [[ -z "$current_version" ]]; then
	echo "Unable to determine current version from package.json" >&2
	exit 1
fi

next_version="$(node -e "const [major, minor, patch] = require('./package.json').version.split('.').map(Number); const bump = process.argv[1]; const next = { major: [major + 1, 0, 0], minor: [major, minor + 1, 0], patch: [major, minor, patch + 1] }[bump]; if (!next || next.some(Number.isNaN)) { process.exit(1); } process.stdout.write(next.join('.'));" "$bump_type")"

if [[ -z "$next_version" ]]; then
	echo "Unable to calculate next version" >&2
	exit 1
fi

if grep -Eq "^## \[$next_version\]" CHANGELOG.md; then
	echo "Changelog already contains version $next_version" >&2
	exit 1
fi

if grep -Eq "^= $next_version( - .*)? =$" readme.txt; then
	echo "readme.txt changelog already contains version $next_version" >&2
	exit 1
fi

npm version "$bump_type" --no-git-tag-version >/dev/null

new_version="$(node -p "require('./package.json').version")"

if [[ -z "$new_version" ]]; then
	echo "Unable to determine updated version from package.json" >&2
	exit 1
fi

perl -0pi -e "s/^(Stable tag:\s+).*
/\${1}$new_version\n/m" readme.txt

perl -0pi -e "s/^(== Changelog ==\r?\n\r?\n)/\${1}= $new_version - TBD =\n\n/m" readme.txt

perl -0pi -e "s/^(\s*\* Version:\s+).*
/\${1}$new_version\n/m" simple-page-ordering.php

perl -0pi -e "s/^(define\( 'SIMPLE_PAGE_ORDERING_VERSION', ')([^']+)('\s*\);)
/\${1}$new_version\${3}\n/m" class-simple-page-ordering.php

perl -0pi -e "s/^(## \[Unreleased\].*\n\n)/\${1}## [$new_version] - TBD\n\n/m" CHANGELOG.md

echo "Bumped version to $new_version"

# Plugin header tests

The plugin header test fixture enables ordering for a post type and should
remain a valid WordPress plugin file. Header and version tests should load the
fixture through the same parser used for the main plugin, then assert the
plugin name and version are present. This keeps release metadata failures
visible before packaging.

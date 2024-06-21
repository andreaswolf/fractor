# 6 Rules Overview

## AddPackageToRequireComposerJsonFractor

Add package to "require" in `composer.json`

:wrench: **configure it!**

- class: [`a9f\FractorComposerJson\AddPackageToRequireComposerJsonFractor`](../rules/AddPackageToRequireComposerJsonFractor.php)

```diff
 {
+    "require": {
+        "symfony/console": "^3.4"
+    }
 }
```

<br>

## AddPackageToRequireDevComposerJsonFractor

Add package to "require-dev" in `composer.json`

:wrench: **configure it!**

- class: [`a9f\FractorComposerJson\AddPackageToRequireDevComposerJsonFractor`](../rules/AddPackageToRequireDevComposerJsonFractor.php)

```diff
 {
+    "require-dev": {
+        "symfony/console": "^3.4"
+    }
 }
```

<br>

## ChangePackageVersionComposerJsonFractor

Change package version `composer.json`

:wrench: **configure it!**

- class: [`a9f\FractorComposerJson\ChangePackageVersionComposerJsonFractor`](../rules/ChangePackageVersionComposerJsonFractor.php)

```diff
 {
     "require": {
-        "symfony/console": "^3.4"
+        "symfony/console": "^4.4"
     }
 }
```

<br>

## RemovePackageComposerJsonFractor

Remove package from "require" and "require-dev" in `composer.json`

:wrench: **configure it!**

- class: [`a9f\FractorComposerJson\RemovePackageComposerJsonFractor`](../rules/RemovePackageComposerJsonFractor.php)

```diff
 {
-    "require": {
-        "symfony/console": "^3.4"
-    }
 }
```

<br>

## RenamePackageComposerJsonFractor

Change package name in `composer.json`

:wrench: **configure it!**

- class: [`a9f\FractorComposerJson\RenamePackageComposerJsonFractor`](../rules/RenamePackageComposerJsonFractor.php)

```diff
 {
     "require": {
-        "rector/rector": "dev-main"
+        "rector/rector-src": "dev-main"
     }
 }
```

<br>

## ReplacePackageAndVersionComposerJsonFractor

Change package name and version `composer.json`

:wrench: **configure it!**

- class: [`a9f\FractorComposerJson\ReplacePackageAndVersionComposerJsonFractor`](../rules/ReplacePackageAndVersionComposerJsonFractor.php)

```diff
 {
     "require-dev": {
-        "symfony/console": "^3.4"
+        "symfony/http-kernel": "^4.4"
     }
 }
```

<br>

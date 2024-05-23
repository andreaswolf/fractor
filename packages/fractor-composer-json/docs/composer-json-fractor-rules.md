# 6 Rules Overview

## AddPackageToRequireComposerJsonFractorRule

Add package to "require" in `composer.json`

:wrench: **configure it!**

- class: [`a9f\FractorComposerJson\AddPackageToRequireComposerJsonFractorRule`](../rules/AddPackageToRequireComposerJsonFractorRule.php)

```diff
 {
+    "require": {
+        "symfony/console": "^3.4"
+    }
 }
```

<br>

## AddPackageToRequireDevComposerJsonFractorRule

Add package to "require-dev" in `composer.json`

:wrench: **configure it!**

- class: [`a9f\FractorComposerJson\AddPackageToRequireDevComposerJsonFractorRule`](../rules/AddPackageToRequireDevComposerJsonFractorRule.php)

```diff
 {
+    "require-dev": {
+        "symfony/console": "^3.4"
+    }
 }
```

<br>

## ChangePackageVersionComposerJsonFractorRule

Change package version `composer.json`

:wrench: **configure it!**

- class: [`a9f\FractorComposerJson\ChangePackageVersionComposerJsonFractorRule`](../rules/ChangePackageVersionComposerJsonFractorRule.php)

```diff
 {
     "require": {
-        "symfony/console": "^3.4"
+        "symfony/console": "^4.4"
     }
 }
```

<br>

## RemovePackageComposerJsonFractorRule

Remove package from "require" and "require-dev" in `composer.json`

:wrench: **configure it!**

- class: [`a9f\FractorComposerJson\RemovePackageComposerJsonFractorRule`](../rules/RemovePackageComposerJsonFractorRule.php)

```diff
 {
-    "require": {
-        "symfony/console": "^3.4"
-    }
 }
```

<br>

## RenamePackageComposerJsonFractorRule

Change package name in `composer.json`

:wrench: **configure it!**

- class: [`a9f\FractorComposerJson\RenamePackageComposerJsonFractorRule`](../rules/RenamePackageComposerJsonFractorRule.php)

```diff
 {
     "require": {
-        "rector/rector": "dev-main"
+        "rector/rector-src": "dev-main"
     }
 }
```

<br>

## ReplacePackageAndVersionComposerJsonFractorRule

Change package name and version `composer.json`

:wrench: **configure it!**

- class: [`a9f\FractorComposerJson\ReplacePackageAndVersionComposerJsonFractorRule`](../rules/ReplacePackageAndVersionComposerJsonFractorRule.php)

```diff
 {
     "require-dev": {
-        "symfony/console": "^3.4"
+        "symfony/http-kernel": "^4.4"
     }
 }
```

<br>

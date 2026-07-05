# 3 Rules Overview

## ConvertXliff1To2Fractor

Convert XLIFF 1.2 files to XLIFF 2.0 format (note: within TYPO3, XLIFF 2.0 is only supported from v14 onwards)

- class: [`a9f\FractorXliff\Transform\ConvertXliff1To2Fractor`](../rules/Transform/ConvertXliff1To2Fractor.php)

```diff
 <?xml version="1.0" encoding="UTF-8"?>
-<xliff version="1.2" xmlns="urn:oasis:names:tc:xliff:document:1.2">
-    <file source-language="en" datatype="plaintext" original="messages">
-        <header/>
-        <body>
-            <trans-unit id="label.hello">
+<xliff version="2.0" xmlns="urn:oasis:names:tc:xliff:document:2.0" srcLang="en">
+    <file id="messages">
+        <unit id="label.hello">
+            <segment>
                 <source>Hello</source>
-            </trans-unit>
-        </body>
+            </segment>
+        </unit>
     </file>
 </xliff>
```

<br>

## EnsureXliffHasSourceLanguageFractor

Ensure XLIFF files have the required source-language (v1.x) or srcLang (v2.0) attribute

- class: [`a9f\FractorXliff\CodeQuality\EnsureXliffHasSourceLanguageFractor`](../rules/CodeQuality/EnsureXliffHasSourceLanguageFractor.php)

```diff
 <?xml version="1.0" encoding="UTF-8"?>
 <xliff version="1.2" xmlns="urn:oasis:names:tc:xliff:document:1.2">
-    <file datatype="plaintext" original="messages">
+    <file source-language="en" datatype="plaintext" original="messages">
         <body>
             <trans-unit id="label.hello">
                 <source>Hello</source>
             </trans-unit>
         </body>
     </file>
 </xliff>
```

<br>

## EnsureXliffHasTargetLanguageFractor

Add target-language attribute to localized XLIFF files where the filename starts with a 2-letter ISO language code

- class: [`a9f\FractorXliff\CodeQuality\EnsureXliffHasTargetLanguageFractor`](../rules/CodeQuality/EnsureXliffHasTargetLanguageFractor.php)

```diff
 <!-- de.locallang.xlf -->
 <?xml version="1.0" encoding="UTF-8"?>
 <xliff version="1.2" xmlns="urn:oasis:names:tc:xliff:document:1.2">
-    <file source-language="en" datatype="plaintext" original="messages">
+    <file source-language="en" target-language="de" datatype="plaintext" original="messages">
         <body>
             <trans-unit id="label.hello">
                 <source>Hello</source>
                 <target>Hallo</target>
             </trans-unit>
         </body>
     </file>
 </xliff>
```

<br>

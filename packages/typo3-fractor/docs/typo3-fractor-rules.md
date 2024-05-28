# 4 Rules Overview

## AbstractMessageGetSeverityFluidRector

Migrate to severity property 'value'

- class: [`a9f\Typo3Fractor\TYPO3v12\Fluid\AbstractMessageGetSeverityFluidRector`](../rules/TYPO3v12/Fluid/AbstractMessageGetSeverityFluidRector.php)

```diff
-<div class="{severityClassMapping.{status.severity}}">
+<div class="{severityClassMapping.{status.severity.value}}">
     <!-- stuff happens here -->
 </div>
```

<br>

## EmailFinisherFractor

Convert single recipient values to array for EmailFinisher

- class: [`a9f\Typo3Fractor\TYPO3v10\Yaml\EmailFinisherFractor`](../rules/TYPO3v10/Yaml/EmailFinisherFractor.php)

```diff
 finishers:
   -
     options:
-      recipientAddress: bar@domain.com
-      recipientName: 'Bar'
+      recipients:
+        bar@domain.com: 'Bar'
```

<br>

## RemoveNoCacheHashAndUseCacheHashAttributeFractor

Remove noCacheHash="1" and useCacheHash="1" attribute

- class: [`a9f\Typo3Fractor\TYPO3v10\Fluid\RemoveNoCacheHashAndUseCacheHashAttributeFractor`](../rules/TYPO3v10/Fluid/RemoveNoCacheHashAndUseCacheHashAttributeFractor.php)

```diff
-<f:link.page noCacheHash="1">Link</f:link.page>
-<f:link.typolink useCacheHash="1">Link</f:link.typolink>
+<f:link.page>Link</f:link.page>
+<f:link.typolink>Link</f:link.typolink>
```

<br>

## TranslationFileFractor

Use key translationFiles instead of translationFile

- class: [`a9f\Typo3Fractor\TYPO3v10\Yaml\TranslationFileFractor`](../rules/TYPO3v10/Yaml/TranslationFileFractor.php)

```diff
 TYPO3:
   CMS:
     Form:
       prototypes:
         standard:
           formElementsDefinition:
             Form:
               renderingOptions:
                 translation:
-                  translationFile:
-                    10: 'EXT:form/Resources/Private/Language/locallang.xlf'
+                  translationFiles:
                     20: 'EXT:myextension/Resources/Private/Language/locallang.xlf'
```

<br>

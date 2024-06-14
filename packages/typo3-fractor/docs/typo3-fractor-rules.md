# 7 Rules Overview

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

## MigrateEmailFlagToEmailTypeFlexFormFractor

Migrate email flag to email type

- class: [`a9f\Typo3Fractor\TYPO3v12\FlexForm\MigrateEmailFlagToEmailTypeFlexFormFractor`](../rules/TYPO3v12/FlexForm/MigrateEmailFlagToEmailTypeFlexFormFractor.php)

```diff
 <T3DataStructure>
     <ROOT>
         <sheetTitle>aTitle</sheetTitle>
         <type>array</type>
         <el>
             <email_field>
                 <label>Email</label>
                 <config>
-                    <type>input</type>
-                    <eval>trim,email</eval>
-                    <max>255</max>
+                    <type>email</type>
                 </config>
             </email_field>
         </el>
     </ROOT>
 </T3DataStructure>
```

<br>

## MigrateEvalIntAndDouble2ToTypeNumberFlexFormFractor

Migrate eval int and double2 to type number

- class: [`a9f\Typo3Fractor\TYPO3v12\FlexForm\MigrateEvalIntAndDouble2ToTypeNumberFlexFormFractor`](../rules/TYPO3v12/FlexForm/MigrateEvalIntAndDouble2ToTypeNumberFlexFormFractor.php)

```diff
 <int_field>
     <label>int field</label>
     <config>
-        <type>input</type>
-        <eval>int</eval>
+        <type>number</type>
     </config>
 </int_field>
 <double2_field>
     <label>double2 field</label>
     <config>
-        <type>input</type>
-        <eval>double2</eval>
+        <type>number</type>
+        <format>decimal</format>
     </config>
 </double2_field>
```

<br>

## MigrateNullFlagFlexFormFractor

Migrate null flag

- class: [`a9f\Typo3Fractor\TYPO3v12\FlexForm\MigrateNullFlagFlexFormFractor`](../rules/TYPO3v12/FlexForm/MigrateNullFlagFlexFormFractor.php)

```diff
 <T3DataStructure>
     <ROOT>
         <sheetTitle>aTitle</sheetTitle>
         <type>array</type>
         <el>
             <aFlexField>
                 <label>aFlexFieldLabel</label>
                 <config>
-                    <eval>null</eval>
+                    <nullable>true</nullable>
                 </config>
             </aFlexField>
         </el>
     </ROOT>
 </T3DataStructure>
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
